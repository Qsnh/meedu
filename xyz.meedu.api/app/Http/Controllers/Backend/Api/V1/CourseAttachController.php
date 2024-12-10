<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Aws\S3\S3Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Cache;
use App\Services\Course\Models\Course;
use Illuminate\Support\Facades\Storage;
use App\Services\Course\Models\CourseAttach;
use App\Http\Requests\Backend\CourseAttachRequest;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class CourseAttachController extends BaseController
{
    public function index(Request $request)
    {
        $courseId = $request->input('course_id');
        $course = Course::query()->where('id', $courseId)->firstOrFail();
        $attach = CourseAttach::query()->where('course_id', $courseId)->get();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_ATTACH,
            AdministratorLog::OPT_VIEW,
            compact('courseId')
        );

        return $this->successData([
            'data' => $attach,
            'course' => $course,
        ]);
    }

    public function create(Request $request, ConfigServiceInterface $configService)
    {
        $extension = strtolower($request->input('extension', ''));
        if (!$extension) {
            return $this->error(__('参数错误'));
        }
        $contentType = FrontendConstant::VOD_COURSE_ATTACH_CONTENT_TYPE_LIST[$extension] ?? '';
        if (!$contentType) {
            return $this->error(__('格式不支持'));
        }
        $filename = Str::random(32) . '.' . $extension;

        $s3Config = $configService->getS3PrivateConfig();

        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => $s3Config['region'],
            'credentials' => [
                'key' => $s3Config['key_id'],
                'secret' => $s3Config['key_secret'],
            ],
            'endpoint' => $s3Config['endpoint']['external'],
        ]);

        try {
            $savePath = 'course-vod/' . $filename;
            $cmd = $s3Client->getCommand('PutObject', [
                'Bucket' => $s3Config['bucket'],
                'Key' => $savePath,
                'ContentType' => $contentType,
            ]);

            $request = $s3Client->createPresignedRequest($cmd, '+360 minutes');
            $uploadUrl = (string)$request->getUri();

            $key = Str::random(32);
            Cache::put($key, compact('savePath', 'filename', 'extension'), 21600);

            return $this->successData([
                'upload_url' => $uploadUrl,
                'key' => $key,
            ]);
        } catch (\Exception $e) {
            return $this->error(__('无法生成上传URL.错误信息 :error', ['error' => $e->getMessage()]));
        }
    }

    public function store(CourseAttachRequest $request)
    {
        ['key' => $key, 'course_id' => $courseId, 'name' => $name] = $request->filldata();

        $cacheValue = Cache::get($key);
        if (!$cacheValue) {
            return $this->error(__('请重新上传'));
        }

        ['savePath' => $savePath, 'extension' => $extension] = $cacheValue;
        $disk = 's3-private';
        if (!Storage::disk($disk)->exists($savePath)) {
            return $this->error(__('未查询到上传的文件'));
        }

        $attach = CourseAttach::create([
            'course_id' => $courseId,
            'name' => $name,
            'path' => $savePath,
            'only_buyer' => 0,
            'download_times' => 0,
            'extension' => $extension,
            'disk' => 's3-private',
            'size' => Storage::disk($disk)->size($savePath),
        ]);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_ATTACH,
            AdministratorLog::OPT_STORE,
            ['attach_id' => $attach['id']]
        );

        return $this->success();
    }

    public function destroy($id)
    {
        $attach = CourseAttach::query()->where('id', $id)->firstOrFail();

        // 删除附件
        Storage::disk($attach['disk'])->delete($attach['path']);

        // 删除数据库记录
        $attach->delete();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VOD_ATTACH,
            AdministratorLog::OPT_DESTROY,
            ['attach_id' => $attach['id'], 'path' => $attach['path'], 'disk' => $attach['disk']]
        );

        return $this->success();
    }
}
