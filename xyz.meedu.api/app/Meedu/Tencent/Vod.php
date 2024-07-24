<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Tencent;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use TencentCloud\Common\Credential;
use App\Exceptions\ServiceException;
use TencentCloud\Vod\V20180717\VodClient;
use TencentCloud\Vod\V20180717\Models\MediaInfo;
use TencentCloud\Vod\V20180717\Models\MediaMetaData;
use TencentCloud\Vod\V20180717\Models\MediaBasicInfo;
use TencentCloud\Vod\V20180717\Models\DeleteMediaRequest;
use TencentCloud\Vod\V20180717\Models\MediaTranscodeInfo;
use TencentCloud\Vod\V20180717\Models\MediaTranscodeItem;
use TencentCloud\Vod\V20180717\Models\ModifyEventConfigRequest;
use TencentCloud\Vod\V20180717\Models\DescribeMediaInfosRequest;
use TencentCloud\Vod\V20180717\Models\DescribeEventConfigRequest;

class Vod
{
    private $appId;
    private $secretId;
    private $secretKey;
    private $playKey;
    private $playDomain;

    private $client;

    public function __construct(array $config)
    {
        $this->appId = (int)$config['app_id'];
        $this->secretId = $config['secret_id'];
        $this->secretKey = $config['secret_key'];
        $this->playKey = $config['play_key'] ?? '';
        $this->playDomain = $config['play_domain'];

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

    public function modifyEventConfig(string $callbackUrl): bool
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

    // @see https://cloud.tencent.com/document/product/266/31763
    public function getPlayUrls(string $videoId): array
    {
        if (!$this->playDomain) {
            throw new ServiceException(__('腾讯云播放域名未配置'));
        }

        $req = new DescribeMediaInfosRequest();
        $req->setSubAppId($this->appId);
        $req->setFileIds([$videoId]);
        $req->setFilters(['basicInfo', 'metaData', 'transcodeInfo']);

        $response = $this->client->DescribeMediaInfos($req);

        $mediaInfoSet = $response->getMediaInfoSet();
        $data = [];
        foreach ($mediaInfoSet as $item) {
            /**
             * @var MediaInfo $item
             */

            if ($item->getFileId() !== $videoId) {
                continue;
            }

            /**
             * @var MediaTranscodeInfo $transcodeInfo
             */
            $transcodeInfo = $item->getTranscodeInfo();

            if ($transcodeInfo) {
                foreach ($transcodeInfo->getTranscodeSet() as $transcodeItem) {
                    /**
                     * @var MediaTranscodeItem $transcodeItem
                     */

                    $data[] = [
                        'url' => $transcodeItem->getUrl(),
                        'format' => strtolower(strtolower(pathinfo($transcodeItem->getUrl(), PATHINFO_EXTENSION))),
                        'duration' => ceil($transcodeItem->getDuration()),
                        'name' => $transcodeItem->getHeight(),
                        'height' => $transcodeItem->getHeight(),
                        'width' => $transcodeItem->getWidth(),
                        'size' => $transcodeItem->getSize(),
                    ];
                }
            } else {
                /**
                 * @var MediaBasicInfo $tmpBasicInfo
                 */
                $tmpBasicInfo = $item->getBasicInfo();

                /**
                 * @var MediaMetaData $tmpMetaData
                 */
                $tmpMetaData = $item->getMetaData();

                // 兜底使用源文件metaData+basicInfo
                $data[] = [
                    'url' => $tmpBasicInfo->getMediaUrl(),
                    'format' => strtolower($tmpBasicInfo->getType()),
                    'duration' => ceil($tmpMetaData->getDuration()),
                    'name' => $tmpMetaData->getHeight(),
                    'height' => $tmpMetaData->getHeight(),
                    'width' => $tmpMetaData->getWidth(),
                    'size' => $tmpMetaData->getSize(),
                ];
            }

            break;
        }

        $data = collect($data)->groupBy('format')->toArray();
        $playUrls = [];

        if (isset($data['m3u8'])) {
            $playUrls = $data['m3u8'];
        } elseif (isset($data['mp4'])) {
            $playUrls = $data['mp4'];
        }

        foreach ($playUrls as $key => $playUrlItem) {
            $tmpUrl = $playUrlItem['url'];
            $tmpUrlInfo = parse_url($tmpUrl);
            $playUrls[$key]['url'] = str_replace($tmpUrlInfo['host'], $this->playDomain, $tmpUrl);
        }

        return $playUrls;
    }

    public function generateUrlWithSignature($url, int $previewSeconds = 0)
    {
        if (!$this->playKey) {
            return $url;
        }

        $urlInfo = parse_url($url);
        $dir = pathinfo($urlInfo['path'], PATHINFO_DIRNAME) . '/';
        // 链接有效时间,默认三个小时
        $t = dechex(time() + 3600 * 3);
        // 试看时长[单位:秒]
        $exper = 0;
        if ($previewSeconds > 0) {
            $exper = $previewSeconds >= 30 ? $previewSeconds : 30;
        };
        // ip限制[1个]
        $rlimit = 1;
        // 标识符
        $us = Str::random(6);

        // 生成签名
        $sign = md5($this->playKey . $dir . $t . $exper . $rlimit . $us);

        return sprintf('%s?t=%s&exper=%d&rlimit=%d&us=%s&sign=%s', $url, $t, $exper, $rlimit, $us, $sign);
    }

}
