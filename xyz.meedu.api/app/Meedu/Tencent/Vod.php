<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Tencent;

use Illuminate\Support\Facades\Log;
use TencentCloud\Common\Credential;
use TencentCloud\Vod\V20180717\VodClient;
use TencentCloud\Vod\V20180717\Models\DeleteMediaRequest;
use TencentCloud\Vod\V20180717\Models\ModifyEventConfigRequest;
use TencentCloud\Vod\V20180717\Models\DescribeEventConfigRequest;

class Vod
{
    private $appId;
    private $secretId;
    private $secretKey;

    protected $client;

    public function __construct(array $config)
    {
        $this->appId = (int)$config['app_id'];
        $this->secretId = $config['secret_id'];
        $this->secretKey = $config['secret_key'];

        $credential = new Credential($this->secretId, $this->secretKey);
        $this->client = new VodClient($credential, '');
    }

    public function getUploadSignature()
    {
        $currentTime = time();
        $data = [
            'secretId' => $this->secretId,
            'currentTimeStamp' => $currentTime,
            'expireTime' => $currentTime + 86400,
            'random' => random_int(0, 100000),
            'vodSubAppId' => config('tencent.vod.app_id'),
        ];
        $queryString = http_build_query($data);
        return base64_encode(hash_hmac('sha1', $queryString, $this->secretKey, true) . $queryString);
    }

    public function deleteVideos(array $fileIds): void
    {
        foreach ($fileIds as $fileId) {
            $req = new DeleteMediaRequest();
            $req->setSubAppId($this->appId);
            $req->setFileId($fileId);
            try {
                $this->client->DeleteMedia($req);
            } catch (\Exception $e) {
                Log::error(__METHOD__ . '|腾讯云视频删除失败,错误信息:' . $e->getMessage(), compact('fileIds'));
            }
        }
    }

    public function describeEventConfig()
    {
        try {
            $req = new DescribeEventConfigRequest();
            $req->setSubAppId($this->appId);
            $response = $this->client->DescribeEventConfig($req);

            return [
                'is_http_mode' => 'PUSH' === $response->getMode(),
                'notification_url' => $response->getNotificationUrl(),
                'is_enabled_upload_media_complete' => 'ON' === $response->getUploadMediaCompleteEventSwitch(),
                'is_enabled_delete_media_complete' => 'ON' === $response->getDeleteMediaCompleteEventSwitch(),
            ];
        } catch (\Exception $e) {
            Log::error(__METHOD__ . '|腾讯云点播-回调配置-查询失败.错误信息:' . $e->getMessage());
            return false;
        }
    }

    public function modifyEventConfig(string $callbackUrl)
    {
        try {
            $req = new ModifyEventConfigRequest();
            $req->setSubAppId($this->appId);
            $req->setMode('PUSH');
            $req->setNotificationUrl($callbackUrl);
            $req->setUploadMediaCompleteEventSwitch('ON');
            $req->setDeleteMediaCompleteEventSwitch('ON');

            $this->client->ModifyEventConfig($req);

            return true;
        } catch (\Exception $e) {
            Log::error(__METHOD__ . '|腾讯云点播-回调配置-设置失败.错误信息:' . $e->getMessage(), compact('callbackUrl'));
            return false;
        }
    }

}
