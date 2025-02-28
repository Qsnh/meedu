<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use App\Meedu\Factory;
use App\Models\MediaImage;
use Illuminate\Support\Str;
use App\Constant\SystemConstant;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Storage;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class UploadBus
{

    public const SCENE_LIST = [
        'avatar',
        'cover',
        'verify',
        'editor',
        'other',
        'config',
        'decoration',
    ];

    private $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    public function uploadFile2Public(string $username, string $userId, $file, string $dirPrefix, string $scene): array
    {
        if (!$dirPrefix) {
            throw new \Exception('参数 $dirPrefix 必须指定值');
        }

        if ($scene && !in_array($scene, self::SCENE_LIST)) {
            throw new \Exception(__('参数 $scene 的可选值有 :scene', ['scene' => implode(',', self::SCENE_LIST)]));
        }

        /**
         * @var \Illuminate\Http\UploadedFile $file
         */
        if (!$file->isValid()) {
            throw new ServiceException(__('请上传有效文件'));
        }

        $s3Config = $this->configService->getS3PublicConfig();

        // 存储的磁盘
        $disk = SystemConstant::STORAGE_DISK_PUBLIC;
        // 上传文件并返回存储路径
        $path = $file->store($dirPrefix, compact('disk'));
        // 上传文件的原始文件名
        $name = mb_substr(strip_tags($file->getClientOriginalName()), 0, 254);
        // 生成访问URL
        $url = $this->generatePublicUrl($path, $s3Config);

        // 返回此次上传的数据
        $data = compact('path', 'url', 'disk', 'name');
        $data['expired_time'] = time() + 1800;
        $data['encryptData'] = encrypt(json_encode($data));

        $mediaImage = MediaImage::create([
            'url' => $url,
            'path' => $path,
            'disk' => $disk,
            'name' => $name,
            'is_hide' => 0,
            'scene' => $scene,
            'operator_id' => $userId,
            'operator' => $username,
        ]);

        $data['media_image_id'] = $mediaImage['id'];

        return $data;
    }

    private function generatePublicUrl(string $path, array $config): string
    {
        $path = ltrim($path, '/');

        if ($config['cdn']['domain']) {
            return rtrim($config['cdn']['domain'], '/') . '/' . $path;
        }

        $endpoint = rtrim(rtrim(strtolower($config['endpoint']['external'])), '/');

        ['host' => $host] = parse_url($endpoint);

        if ($config['use_path_style_endpoint'] || filter_var($host, FILTER_VALIDATE_IP)) {
            $endpoint = $endpoint . '/' . $config['bucket'];
        } else {
            if (Str::startsWith($endpoint, 'http://')) {
                $endpoint = str_replace('http://', 'http://' . $config['bucket'] . '.', $endpoint);
            } elseif (Str::startsWith($endpoint, 'https://')) {
                $endpoint = str_replace('https://', 'https://' . $config['bucket'] . '.', $endpoint);
            } else {
                $endpoint = 'https://' . $config['bucket'] . '.' . $endpoint;
            }
        }

        return $endpoint . '/' . $path;
    }

    public function uploadBase64Content2Private(string $username, string $userId, string $content, string $dirPrefix, string $filename, string $scene): array
    {
        if (!$content) {
            throw new ServiceException(__('上传内容为空'));
        }

        if (!$dirPrefix) {
            throw new \Exception('参数 $dirPrefix 必须指定值');
        }

        $disk = SystemConstant::STORAGE_DISK_PRIVATE;
        $path = rtrim($dirPrefix, '/') . '/' . $filename;
        $isSuc = Storage::disk($disk)->put($path, base64_decode($content));
        if (!$isSuc) {
            throw new ServiceException(__('文件 :filename 上传失败', ['filename' => $filename]));
        }

        $mediaImage = MediaImage::create([
            'url' => '',
            'path' => $path,
            'disk' => $disk,
            'name' => $filename,
            'is_hide' => 1,
            'scene' => $scene,
            'operator_id' => $userId,
            'operator' => $username,
        ]);

        $data = compact('disk', 'path');
        $data['media_image_id'] = $mediaImage['id'];

        return $data;
    }

    public function generatePrivateUrl(string $path): string
    {
        ['client' => $s3Client, 'bucket' => $bucket] = Factory::s3PrivateClient();

        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $path,
        ]);

        $request = $s3Client->createPresignedRequest($cmd, '+120 minutes');

        return (string)$request->getUri();
    }

}
