<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu;

use Aws\S3\S3Client;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class Factory
{

    public static function s3PublicClient(): array
    {
        /**
         * @var ConfigServiceInterface $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);

        $config = $configService->getS3PublicConfig();

        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => $config['region'],
            'credentials' => [
                'key' => $config['key_id'],
                'secret' => $config['key_secret'],
            ],
            'endpoint' => $config['endpoint']['external'],
            'use_path_style_endpoint' => $config['use_path_style_endpoint'],
        ]);

        return ['client' => $s3Client, 'bucket' => $config['bucket']];
    }

    public static function s3PrivateClient(): array
    {
        /**
         * @var ConfigServiceInterface $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);

        $config = $configService->getS3PrivateConfig();

        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => $config['region'],
            'credentials' => [
                'key' => $config['key_id'],
                'secret' => $config['key_secret'],
            ],
            'endpoint' => $config['endpoint']['external'],
            'use_path_style_endpoint' => $config['use_path_style_endpoint'],
        ]);

        return ['client' => $s3Client, 'bucket' => $config['bucket']];
    }

}
