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
            if (isset($data['title']) && $data['title'] && $mediaVideo['title'] !== $data['title']) {
                $updateData['title'] = $data['title'];
            }
            if (isset($data['size']) && $data['size'] && $mediaVideo['size'] !== $data['size']) {
                $updateData['size'] = $data['size'];
            }
            if (isset($data['duration']) && $data['duration'] && $mediaVideo['duration'] !== $data['duration']) {
                $updateData['duration'] = $data['duration'];
            }
            if (isset($data['is_hidden']) && $mediaVideo['is_hidden'] !== $data['is_hidden']) {
                $updateData['is_hidden'] = $data['is_hidden'];
            }
            if (isset($data['category_id']) && $mediaVideo['category_id'] !== $data['category_id']) {
                $updateData['category_id'] = $data['category_id'];
            }

            $updateData && $this->otherDao->updateMediaVideo($mediaVideo['id'], $updateData);
        } else {
            $this->otherDao->storeMediaVideo(array_merge($data, [
                'storage_driver' => $service,
                'storage_file_id' => $videoId,
            ]));
        }
    }

    public function deleteMediaVideo(string $service, string $videoId): void
    {
        $this->otherDao->deleteMediaVideos($service, [$videoId]);
    }

    public function mediaVideoVisibilityToggle(string $service, string $videoId): void
    {
        $mediaVideo = $this->otherDao->findMediaVideoByVideoId($service, $videoId);
        if ($mediaVideo && $mediaVideo['is_hidden'] !== 0) {
            $this->otherDao->updateMediaVideo($mediaVideo['id'], ['is_hidden' => 0]);
        }
    }

    public function deleteMediaVideos(string $service, array $videoIds): void
    {
        $this->otherDao->deleteMediaVideos($service, $videoIds);
    }

}
