<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Hooks\ViewBlock\HTML;

use App\Meedu\Hooks\HookParams;
use App\Meedu\ViewBlock\Constant;
use App\Meedu\Hooks\HookRuntimeInterface;
use App\Services\Course\Services\CourseService;
use App\Services\Course\Interfaces\CourseServiceInterface;

class VodV1HTMLHook implements HookRuntimeInterface
{
    public function handle(HookParams $params, \Closure $closure)
    {
        $block = $params->getValue('block');

        if (!in_array($block['sign'], [Constant::PC_BLOCK_SIGN_VOD_V1])) {
            return $closure($params);
        }

        $courseIds = collect($block['config_render']['items'])->pluck('id')->map(function ($val) {
            return (int)$val;
        })->toArray();

        if ($courseIds) {
            /**
             * @var CourseService $courseService
             */
            $courseService = app()->make(CourseServiceInterface::class);
            $courses = $courseService->getByIds(
                $courseIds,
                [
                    'id', 'title', 'thumb', 'charge', 'user_count', 'short_description',
                    'published_at', 'category_id', 'is_rec', 'is_free', 'comment_status',
                    'slug',
                ],
                [
                    'category:id,name'
                ]
            );
            $courses = array_column($courses, null, 'id');

            foreach ($block['config_render']['items'] as $index => $courseItem) {
                if (isset($courses[$courseItem['id']])) {
                    $block['config_render']['items'][$index] = $courses[$courseItem['id']];
                }
            }

            $html = app('Illuminate\View\Factory')->file(resource_path('views/frontend/view-block/vod-v1.blade.php'), ['block' => $block])->render();
            $params->setResponse($html);
        }

        return $closure($params);
    }
}
