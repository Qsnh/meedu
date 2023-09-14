<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Tencent;

use Illuminate\Support\Facades\Log;
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use TencentCloud\Vod\V20180717\Models\DeleteMediaRequest;

class Vod
{
    protected $secretId;
    protected $secretKey;

    protected $client;

    public function __construct()
    {
        /**
         * @var ConfigService $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);
        $config = $configService->getTencentVodConfig();

        $this->secretId = $config['secret_id'];
        $this->secretKey = $config['secret_key'];
    }

    /**
     * 获取上传签名
     * @return string
     * @throws \Exception
     */
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
        $sign = base64_encode(hash_hmac('sha1', $queryString, $this->secretKey, true) . $queryString);

        return $sign;
    }

    public function deleteVideos(array $fileIds): void
    {
        foreach ($fileIds as $fileId) {
            $req = new DeleteMediaRequest();
            $req->setFileId($fileId);
            try {
                // 这里只管提交不关注是否成功处理
                $this->initClient()->DeleteMedia($req);
            } catch (\Exception $e) {
                Log::error(__METHOD__ . '|腾讯云视频删除', ['err' => $e->getMessage(), 'fileId' => $fileId]);
            }
        }
    }

    protected function initClient()
    {
        if (!$this->client) {
            $credential = new \TencentCloud\Common\Credential($this->secretId, $this->secretKey);
            $this->client = new \TencentCloud\Vod\V20180717\VodClient($credential, '');
        }
        return $this->client;
    }
}
