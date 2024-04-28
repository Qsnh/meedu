<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Aliyun;

use Illuminate\Support\Facades\Log;
use AlibabaCloud\Client\AlibabaCloud;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class Vod
{
    protected $accessKeyId;
    protected $accessKeySecret;
    protected $region;
    protected $host;

    public const API_VERSION = '2017-03-21';

    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
        $config = $configService->getAliyunVodConfig();
        $this->accessKeyId = $config['access_key_id'];
        $this->accessKeySecret = $config['access_key_secret'];
        $this->region = $config['region'];
        $this->host = $config['host'];
    }

    public function deleteVideos(array $fileIds): void
    {
        // 批量删除这里不做强制的结果绑定
        // 也就是我提交了删除的行为，具体能不能删掉不关注
        // 这里仅记录操作的结果用作debug
        try {
            $this->initClient();

            $response = AlibabaCloud::rpc()
                ->product('vod')
                ->host($this->host)
                ->version(self::API_VERSION)
                ->action('DeleteVideo')
                ->options(['query' => ['VideoIds' => implode(',', $fileIds)]])
                ->request();
        } catch (\Exception $e) {
            Log::error(__METHOD__ . '|阿里云批量删除视频', ['err' => $e->getMessage(), 'fileIds' => $fileIds]);
        }
    }

    protected function initClient()
    {
        AlibabaCloud::accessKeyClient($this->accessKeyId, $this->accessKeySecret)
            ->regionId($this->region)
            ->connectTimeout(3)
            ->timeout(30)
            ->asDefaultClient();
    }
}
