<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Aliyun;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ServiceException;
use AlibabaCloud\Client\AlibabaCloud;

class Vod
{
    private $accessKeyId;
    private $accessKeySecret;
    private $region;
    private $host;
    private $playDomain;

    public const API_VERSION = '2017-03-21';

    public function __construct(array $config)
    {
        // 必选参数
        $this->accessKeyId = $config['access_key_id'];
        $this->accessKeySecret = $config['access_key_secret'];
        $this->region = $config['region'];
        $this->host = $config['host'];

        // 可选参数
        isset($config['play_domain']) && $this->playDomain = $config['play_domain'];

        // 初始化客户端
        AlibabaCloud::accessKeyClient($this->accessKeyId, $this->accessKeySecret)
            ->regionId($this->region)
            ->connectTimeout(3)
            ->timeout(30)
            ->asDefaultClient();
    }

    // @see https://help.aliyun.com/zh/vod/developer-reference/api-vod-2017-03-21-deletevideo
    public function deleteVideos(array $fileIds): void
    {
        try {
            AlibabaCloud::rpc()
                ->product('vod')
                ->host($this->host)
                ->version(self::API_VERSION)
                ->action('DeleteVideo')
                ->options(['query' => ['VideoIds' => implode(',', $fileIds)]])
                ->request();
        } catch (\Exception $e) {
            Log::error(__METHOD__ . '|阿里云批量删除视频出现异常', ['err' => $e->getMessage(), 'fileIds' => $fileIds]);
        }
    }

    // @see https://help.aliyun.com/zh/vod/developer-reference/api-vod-2017-03-21-getmessagecallback
    public function getMessageCallback()
    {
        $response = AlibabaCloud::rpc()
            ->product('vod')
            ->host($this->host)
            ->version(self::API_VERSION)
            ->action('GetMessageCallback')
            ->request();

        $messageCallback = $response->get('MessageCallback');

        return [
            'callback_url' => $messageCallback['CallbackURL'] ?? '',
            'auth_switch' => $messageCallback['AuthSwitch'] ?? '',
            'callback_type' => $messageCallback['CallbackType'] ?? '',
            'app_id' => $messageCallback['AppId'] ?? '',
            'event_type_list' => $messageCallback['EventTypeList'] ?? '',
            'auth_key' => $messageCallback['AuthKey'] ?? '',
        ];
    }

    // @see https://help.aliyun.com/zh/vod/developer-reference/api-vod-2017-03-21-setmessagecallback
    public function setMessageCallback(string $callbackUrl)
    {
        AlibabaCloud::rpc()
            ->product('vod')
            ->host($this->host)
            ->version(self::API_VERSION)
            ->action('SetMessageCallback')
            ->options(['query' => [
                'CallbackType' => 'HTTP',
                'EventTypeList' => 'ALL',
                'AuthSwitch' => 'off',
                'CallbackURL' => $callbackUrl,
            ]])
            ->request();
    }

    // @see https://help.aliyun.com/zh/vod/developer-reference/api-vod-2017-03-21-createuploadvideo
    public function createUploadVideo(string $title, string $filename)
    {
        $response = AlibabaCloud::rpc()
            ->product('vod')
            ->host($this->host)
            ->version(self::API_VERSION)
            ->action('CreateUploadVideo')
            ->options(['query' => [
                'Title' => $title,
                'FileName' => $filename,
            ]])
            ->request();

        return [
            'upload_auth' => $response->get('UploadAuth'),
            'upload_address' => $response->get('UploadAddress'),
            'video_id' => $response->get('VideoId'),
            'request_id' => $response->get('RequestId'),
        ];
    }

    // @see https://help.aliyun.com/zh/vod/developer-reference/api-vod-2017-03-21-refreshuploadvideo
    public function refreshUploadVideo(string $videoId)
    {
        $response = AlibabaCloud::rpc()
            ->product('vod')
            ->host($this->host)
            ->version(self::API_VERSION)
            ->action('RefreshUploadVideo')
            ->options(['query' => [
                'VideoId' => $videoId,
            ]])
            ->request();

        return [
            'upload_auth' => $response->get('UploadAuth'),
            'upload_address' => $response->get('UploadAddress'),
            'video_id' => $response->get('VideoId'),
            'request_id' => $response->get('RequestId'),
        ];
    }

    // @see https://help.aliyun.com/zh/vod/developer-reference/api-vod-2017-03-21-searchmedia
    public function searchMedia(int $page, int $pageSize, string $scrollToken = ''): array
    {
        $query = [
            'SearchType' => 'video',
            'Fields' => 'Title,CreationTime,VideoId,Size,Duration',
            'PageNo' => $page,
            'PageSize' => $pageSize,
            'Match' => "Status in ('UploadSucc', 'Transcoding', 'Normal', 'TranscodeFail')"
        ];
        if ($scrollToken) {
            $query['ScrollToken'] = $scrollToken;
        }

        $response = AlibabaCloud::rpc()
            ->product('vod')
            ->host($this->host)
            ->version(self::API_VERSION)
            ->action('SearchMedia')
            ->options(['query' => $query])
            ->request();

        $mediaList = $response->get('MediaList');
        $data = [];
        if ($mediaList) {
            foreach ($mediaList as $mediaItem) {
                $tmpVideo = $mediaItem['Video'];
                $data[] = [
                    'title' => $tmpVideo['Title'],
                    'created_at' => $tmpVideo['CreationTime'],
                    'video_id' => $tmpVideo['VideoId'],
                    'size' => $tmpVideo['Size'] ?? 0,
                    'duration' => ceil($tmpVideo['Duration'] ?? 0),
                ];
            }
        }

        return [
            'data' => $data,
            'total' => $response->get('Total'),
            'scroll_token' => $response->get('ScrollToken'),
        ];
    }

    // @see https://help.aliyun.com/zh/vod/developer-reference/api-vod-2017-03-21-getplayinfo
    public function getPlayInfo(string $videoId, int $previewSeconds = 0)
    {
        if (!$this->playDomain) {
            throw new ServiceException(__('阿里云播放域名未配置'));
        }
        
        $query = [
            'VideoId' => $videoId,
            'AuthTimeout' => 10800,//3个小时有效
            'OutputType' => 'cdn',
            'StreamType' => 'video',
            'ResultType' => 'Single', // 每种清晰度和格式只返回一路最新转码完成的流
            'Formats' => 'mp4,m3u8',
        ];

        $playConfig = ['PlayDomain' => $this->playDomain];
        if ($previewSeconds) {
            $playConfig['PreviewTime'] = $previewSeconds;
        }

        $query['PlayConfig'] = json_encode($playConfig);

        $response = AlibabaCloud::rpc()
            ->product('vod')
            ->host($this->host)
            ->version(self::API_VERSION)
            ->action('GetPlayInfo')
            ->options(['query' => $query])
            ->request();

        $playInfoList = $response['PlayInfoList']['PlayInfo'];
        if (!$playInfoList) {
            return [];
        }

        $data = [];
        foreach ($playInfoList as $playInfoItem) {
            $data[] = [
                'format' => $playInfoItem['Format'],
                'url' => $playInfoItem['PlayURL'],
                'duration' => ceil($playInfoItem['Duration'] ?? 0),
                'name' => $playInfoItem['Definition'],
                'height' => $playInfoItem['Height'] ?? 0,
                'width' => $playInfoItem['Width'] ?? 0,
                'size' => $playInfoItem['Size'] ?? 0,
            ];
        }

        $data = collect($data)->groupBy('format')->toArray();

        if (isset($data['m3u8']) && $data['m3u8']) {
            return $data['m3u8'];
        }

        return $data['mp4'] ?? [];
    }

    // @see https://help.aliyun.com/zh/vod/developer-reference/api-vod-2017-03-21-describevoddomainconfigs
    public function describeVodDomainAuthConfig(string $domain)
    {
        $response = AlibabaCloud::rpc()
            ->product('vod')
            ->host($this->host)
            ->version(self::API_VERSION)
            ->action('DescribeVodDomainConfigs')
            ->options(['query' => [
                'DomainName' => $domain,
                'FunctionNames' => 'aliauth',
            ]])
            ->request();

        $configData = [];

        foreach ($response['DomainConfigs']['DomainConfig'] as $configItem) {
            if ('aliauth' !== $configItem['FunctionName']) {
                continue;
            }

            foreach ($configItem['FunctionArgs']['FunctionArg'] as $tmpItem) {
                $configData[$tmpItem['ArgName']] = $tmpItem['ArgValue'];
            }
        }

        return $configData;
    }

    // @see https://help.aliyun.com/zh/vod/developer-reference/api-vod-2017-03-21-batchsetvoddomainconfigs
    public function batchSetVodDomainAuthConfig(string $domain, string $key): void
    {
        AlibabaCloud::rpc()
            ->product('vod')
            ->host($this->host)
            ->version(self::API_VERSION)
            ->action('BatchSetVodDomainConfigs')
            ->options(['query' => [
                'DomainNames' => $domain,
                'Functions' => json_encode([
                    [
                        'functionArgs' => [
                            [
                                'argName' => 'auth_type',
                                'argValue' => 'type_a',
                            ],
                            [
                                'argName' => 'auth_key1',
                                'argValue' => $key,
                            ],
                            [
                                'argName' => 'auth_key2',
                                'argValue' => Str::reverse($key),
                            ],
                            [
                                'argName' => 'auth_m3u8',
                                'argValue' => 'on',
                            ],
                            [
                                'argName' => 'ali_auth_delta',
                                'argValue' => 7200,
                            ],
                            [
                                'argName' => 'ali_auth_remote_desc',
                                'argValue' => 'video_preview_arg=end auth_check_video_preview=on',
                            ],
                        ],
                        'functionName' => 'aliauth',
                    ],
                ]),
            ]])
            ->request();
    }
}
