<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Aliyun;

use Illuminate\Support\Facades\Log;
use AlibabaCloud\Client\AlibabaCloud;

class Vod
{
    protected $accessKeyId;
    protected $accessKeySecret;
    protected $region;
    protected $host;

    public const API_VERSION = '2017-03-21';

    protected $configService;

    public function __construct(array $config)
    {
        $this->accessKeyId = $config['access_key_id'];
        $this->accessKeySecret = $config['access_key_secret'];
        $this->region = $config['region'];
        $this->host = $config['host'];

        AlibabaCloud::accessKeyClient($this->accessKeyId, $this->accessKeySecret)
            ->regionId($this->region)
            ->connectTimeout(3)
            ->timeout(30)
            ->asDefaultClient();
    }

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

    public function queryMessageCallback()
    {
        try {
            $response = AlibabaCloud::rpc()
                ->product('vod')
                ->host($this->host)
                ->version(self::API_VERSION)
                ->action('GetMessageCallback')
                ->request();

            $messageCallback = $response->get('MessageCallback');

            return [
                'callback_url' => $messageCallback['CallbackURL'] ?? '',
                'is_enabled_auth_switch' => 'on' === ($messageCallback['AuthSwitch'] ?? ''),
                'is_http_callback_type' => 'HTTP' === ($messageCallback['CallbackType'] ?? ''),
                'app_id' => $messageCallback['AppId'] ?? '',
                'is_all_event' => 'ALL' === ($messageCallback['EventTypeList'] ?? ''),
                'auth_key' => $messageCallback['AuthKey'] ?? '',
            ];
        } catch (\Exception $e) {
            Log::error(__METHOD__ . '|阿里云点播消息回调配置查询失败|错误信息:' . $e->getMessage());
            return false;
        }
    }

    public function setMessageCallback(string $callbackUrl)
    {
        try {
            AlibabaCloud::rpc()
                ->product('vod')
                ->host($this->host)
                ->version(self::API_VERSION)
                ->action('SetMessageCallback')
                ->options(['query' => [
                    'CallbackType' => 'HTTP',
                    'EventTypeList' => 'ALL',
                    'AuthSwitch' => 'on',
                    'CallbackURL' => $callbackUrl,
                ]])
                ->request();

            return true;
        } catch (\Exception $e) {
            Log::error(__METHOD__ . '|阿里云点播消息回调配置设置失败|错误信息:' . $e->getMessage());
            return false;
        }
    }

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
        $query = [
            'VideoId' => $videoId,
            'AuthTimeout' => 10800,//3个小时有效
            'OutputType' => 'cdn',
            'StreamType' => 'video',
            'ResultType' => 'Single',
            'Formats' => 'mp4,m3u8',
        ];

        $playConfig = [];
        if ($previewSeconds) {
            $playConfig['PreviewTime'] = $previewSeconds;
        }

        $playConfig && $query['PlayConfig'] = json_encode($playConfig, JSON_UNESCAPED_UNICODE);

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
}
