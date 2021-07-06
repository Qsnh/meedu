<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use Overtrue\Pinyin\Pinyin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Services\Member\Models\UserVideo;
use App\Services\Course\Models\CourseChapter;
use App\Http\Requests\Backend\CourseVideoRequest;
use App\Services\Member\Models\UserVideoWatchRecord;

class CourseVideoController extends BaseController
{
    public function index(Request $request)
    {
        $courseId = $request->input('cid');

        $videos = Video::query()
            ->with(['chapter:id,title'])
            ->where('course_id', $courseId)
            ->orderBy('published_at')
            ->paginate($request->input('size', 10));

        return $this->successData(compact('videos'));
    }

    public function create()
    {
        $courses = Course::select(['id', 'title'])->orderByDesc('published_at')->get();

        return $this->successData(compact('courses'));
    }

    public function store(CourseVideoRequest $request, Video $video)
    {
        $video->fill($request->filldata())->save();

        $this->hook($video->course_id);

        return $this->success();
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);

        $courses = Course::all();

        return $this->successData(compact('video', 'courses'));
    }

    public function update(CourseVideoRequest $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->fill($request->filldata())->save();

        $this->hook($video->course_id);

        return $this->success();
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $courseId = $video->course_id;
        $video->delete();

        $this->hook($courseId);

        return $this->success();
    }

    protected function hook($courseId)
    {
        $count = Video::query()->where('course_id', $courseId)->where('charge', '>', 0)->count();
        $isFree = $count === 0;
        Course::query()->where('id', $courseId)->update(['is_free' => $isFree]);
    }

    public function multiDestroy(Request $request)
    {
        $ids = $request->input('ids');
        $videos = Video::query()->whereIn('id', $ids)->get();
        foreach ($videos as $video) {
            $courseId = $video['course_id'];
            $video->delete();
            $this->hook($courseId);
        }

        return $this->success();
    }

    public function subscribes(Request $request, $videoId)
    {
        $userId = $request->input('user_id');
        $subscribeStartAt = $request->input('subscribe_start_at');
        $subscribeEndAt = $request->input('subscribe_end_at');

        $data = UserVideo::query()
            ->where('video_id', $videoId)
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($subscribeStartAt && $subscribeEndAt, function ($query) use ($subscribeStartAt, $subscribeEndAt) {
                $query->whereBetween('created_at', [$subscribeStartAt, $subscribeEndAt]);
            })
            ->orderByDesc('created_at')
            ->paginate($request->input('size', 10));

        $users = User::query()
            ->select(['id', 'nick_name', 'mobile', 'avatar'])
            ->whereIn('id', array_column($data->items(), 'user_id'))
            ->get()
            ->keyBy('id');

        return $this->successData([
            'data' => $data,
            'users' => $users,
        ]);
    }

    public function subscribeCreate(Request $request, $videoId)
    {
        $userId = $request->input('user_id');
        if (UserVideo::query()->where('user_id', $userId)->where('video_id', $videoId)->exists()) {
            return $this->error(__('订阅关系已存在'));
        }

        if (!User::query()->where('id', $userId)->exists()) {
            return $this->error(__('用户不存在'));
        }

        UserVideo::create([
            'user_id' => $userId,
            'video_id' => $videoId,
            'charge' => 0,
            'created_at' => Carbon::now(),
        ]);

        return $this->success();
    }

    public function subscribeDelete(Request $request, $videoId)
    {
        $userId = $request->input('user_id');
        UserVideo::query()->where('user_id', $userId)->where('video_id', $videoId)->delete();
        return $this->success();
    }

    public function watchRecords(Request $request, $videoId)
    {
        $courseId = $request->input('course_id');
        $userId = $request->input('user_id');
        $watchedStartAt = $request->input('watched_start_at');
        $watchedEndAt = $request->input('watched_end_at');

        // 分页
        $page = (int)$request->input('page');
        $size = $request->input('size', 10);

        $data = UserVideoWatchRecord::query()
            ->when($videoId, function ($query) use ($videoId) {
                $query->where('video_id', $videoId);
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($courseId, function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->when($watchedStartAt && $watchedEndAt, function ($query) use ($watchedStartAt, $watchedEndAt) {
                $query->whereBetween('watched_at', [$watchedStartAt, $watchedEndAt]);
            })
            ->orderByRaw('course_id,video_id,user_id desc')
            ->paginate($size, ['*'], 'page', $page);

        // 课程
        $courses = Course::query()->select(['id', 'title', 'charge'])
            ->whereIn('id', array_column($data->items(), 'course_id'))
            ->get()
            ->keyBy('id');

        // 视频
        $videos = Video::query()->select(['id', 'title', 'charge', 'duration'])
            ->whereIn('id', array_column($data->items(), 'video_id'))
            ->get()
            ->keyBy('id');

        // 用户
        $users = User::query()
            ->with(['tags'])
            ->select(['id', 'nick_name', 'avatar', 'mobile'])
            ->whereIn('id', array_column($data->items(), 'user_id'))
            ->get()
            ->keyBy('id');

        return $this->successData([
            'courses' => $courses,
            'data' => $data,
            'users' => $users,
            'videos' => $videos,
        ]);
    }

    public function import(Request $request)
    {
        $data = $request->input('data');
        if (!$data) {
            return $this->error(__('数据为空'));
        }

        $courseNameArr = array_column($data, 0);
        $courses = Course::query()->whereIn('title', $courseNameArr)->select(['id', 'title'])->get()->pluck('id', 'title');

        $rows = [];
        $now = Carbon::now();
        $py = new Pinyin();
        foreach ($data as $index => $item) {
            $line = $index + 2;
            $courseName = $item[0] ?? '';
            if (!$courseName) {
                return $this->error(sprintf(__('第%d行课程名为空'), $line));
            }
            $courseId = $courses[$courseName] ?? 0;
            if (!$courseId) {
                return $this->error(sprintf(__('第%d行课程不存在'), $line));
            }

            $chapterName = $item[1] ?? '';
            $chapterId = 0;
            if ($chapterName) {
                $chapter = CourseChapter::query()->where('course_id', $courseId)->where('title', $chapterName)->select(['id'])->first();
                if (!$chapter) {
                    $chapter = CourseChapter::create(['title' => $chapterName, 'course_id' => $courseId]);
                }
                $chapterId = $chapter['id'];
            }

            $videoName = $item[2] ?? '';
            if (!$videoName) {
                return $this->error(sprintf(__('第%d视频名为空'), $line));
            }

            $duration = (int)($item[3] ?? 0);
            $tencentVideoId = $item[4] ?? '';
            $url = $item[5] ?? '';
            $aliyunVideoId = $item[6] ?? '';
            $charge = (int)($item[7] ?? 0);

            // 上架时间
            $publishedAt = $item[8] ?? '';
            $publishedAt = $publishedAt ? Carbon::parse($publishedAt) : $now;

            $seoKeywords = $item[9] ?? '';
            $seoDescription = $item[10] ?? '';

            // 试看秒数
            $freeSeconds = (int)($item[11] ?? 0);

            $rows[] = [
                'user_id' => 0,
                'course_id' => $courseId,
                'chapter_id' => $chapterId,
                'title' => $videoName,
                'slug' => implode('-', $py->convert($videoName)),
                'url' => $url,
                'short_description' => '',
                'seo_keywords' => $seoKeywords,
                'seo_description' => $seoDescription,
                'published_at' => $publishedAt,
                'charge' => $charge,
                'aliyun_video_id' => $aliyunVideoId,
                'tencent_video_id' => $tencentVideoId,
                'free_seconds' => $freeSeconds,
                'duration' => $duration,
                'is_show' => Video::IS_SHOW_YES,
                'original_desc' => '',
                'render_desc' => '',
            ];
        }

        DB::transaction(function () use ($rows) {
            foreach (array_chunk($rows, 100) as $item) {
                Video::insert($item);
            }
        });

        return $this->success();
    }
}
