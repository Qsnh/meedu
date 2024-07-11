<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

use App\Meedu\ServiceV2\Dao\OtherDaoInterface;

class OtherService implements OtherServiceInterface
{
    protected $otherDao;

    public function __construct(OtherDaoInterface $otherDao)
    {
        $this->otherDao = $otherDao;
    }

    public function storeUserUploadImage(int $userId, string $group, string $disk, string $path, string $name, string $visitUrl, string $logApi, string $logIp, string $logUA): void
    {
        if (mb_strlen($logUA) > 255) {
            $logUA = mb_substr($logUA, 0, 255);
        }

        $this->otherDao->storeUserUploadImage($userId, $group, $disk, $path, $name, $visitUrl, $logApi, $logIp, $logUA);
    }

    public function storeOrUpdateMediaVideo(string $service, string $videoId, array $data): void
    {
        $mediaVideo = $this->otherDao->findMediaVideoByVideoId($service, $videoId);
        if ($mediaVideo) {
            $updateData = [];
            if (isset($data['title']) && $mediaVideo['title'] !== $data['title']) {
                $updateData['title'] = $data['title'];
            }
            if (isset($data['size']) && $mediaVideo['size'] !== $data['size']) {
                $updateData['size'] = $data['size'];
            }
            if (isset($data['duration']) && $mediaVideo['duration'] !== $data['duration']) {
                $updateData['duration'] = $data['duration'];
            }

            $this->otherDao->updateMediaVideo($mediaVideo['id'], $updateData);
        } else {
            $this->otherDao->storeMediaVideo(array_merge($data, [
                'storage_driver' => $service,
                'storage_file_id' => $videoId,
            ]));
        }
    }

    public function deleteMediaVideo(string $service, string $videoId): void
    {
        $this->otherDao->deleteMediaVideoByVideoId($service, $videoId);
    }


}
