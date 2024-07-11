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
}
