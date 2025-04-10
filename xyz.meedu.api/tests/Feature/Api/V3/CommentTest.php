<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V3;

use Carbon\Carbon;
use App\Meedu\Core\HashID;
use App\Constant\BusConstant;
use Tests\Feature\Api\V2\Base;
use App\Meedu\ServiceV2\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Meedu\ServiceV2\Models\Comment;
use Illuminate\Support\Facades\Artisan;

class CommentTest extends Base
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index()
    {
        // 创建测试评论
        $comment = Comment::create([
            'user_id' => $this->user->id,
            'rt' => BusConstant::COMMENT_RT_VOD_COURSE,
            'rid' => 1,
            'content' => '评论内容',
            'is_check' => 1,
            'parent_id' => 0,
            'ip' => '127.0.0.1',
            'ip_province' => '浙江'
        ]);

        // 创建回复
        $reply = Comment::create([
            'user_id' => $this->user->id,
            'rt' => BusConstant::COMMENT_RT_VOD_COURSE,
            'rid' => 1,
            'content' => '回复内容',
            'is_check' => 1,
            'parent_id' => $comment->id,
            'ip' => '127.0.0.1',
            'ip_province' => '浙江'
        ]);

        $response = $this->user($this->user)->getJson('/api/v3/comments?' . http_build_query([
                'rt' => BusConstant::COMMENT_RT_VOD_COURSE,
                'rid' => 1,
            ]));

        ['data' => $data] = $this->assertResponseSuccess($response);

        // 验证返回结构
        $this->assertEquals(HashID::encode($comment->id), $data['data'][0]['id']);
        $this->assertEquals($comment->content, $data['data'][0]['content']);
        $this->assertEquals(1, $data['data'][0]['replies_count']);
        $this->assertCount(1, $data['data'][0]['replies']);
    }

    public function test_replies()
    {
        // 创建父评论
        $parentComment = Comment::create([
            'user_id' => $this->user->id,
            'rt' => BusConstant::COMMENT_RT_VOD_COURSE,
            'rid' => 1,
            'content' => '父评论',
            'is_check' => 1,
            'parent_id' => 0
        ]);

        // 创建多条回复
        for ($i = 0; $i < 5; $i++) {
            Comment::create([
                'user_id' => $this->user->id,
                'rt' => BusConstant::COMMENT_RT_VOD_COURSE,
                'rid' => 1,
                'content' => "回复{$i}",
                'is_check' => 1,
                'parent_id' => $parentComment->id
            ]);
        }

        $response = $this->user($this->user)->getJson('/api/v3/comments/replies?' . http_build_query([
                'rt' => BusConstant::COMMENT_RT_VOD_COURSE,
                'rid' => 1,
                'parent_id' => HashID::encode($parentComment->id)
            ]));

        ['data' => $data] = $this->assertResponseSuccess($response);
        $this->assertCount(5, $data['data']);
    }

    public function test_store_with_empty_params()
    {
        $response = $this->user($this->user)->postJson('/api/v3/comment/store', [
            'content' => '123',
            'rt' => '',
            'rid' => 1,
        ]);
        $this->assertResponseError($response, __('参数错误'));
    }

    public function test_store_with_invalid_rt()
    {
        $response = $this->user($this->user)->postJson('/api/v3/comment/store', [
            'content' => '评论内容',
            'rt' => 999,
            'rid' => 1,
        ]);
        $this->assertResponseError($response, __('参数错误'));
    }

    public function test_store_with_daily_limit()
    {
        Artisan::call('cache:clear');

        $cacheKey = sprintf('user_comment_count:%d:%s', $this->user->id, date('Y-m-d'));
        Cache::put($cacheKey, 100);

        $response = $this->user($this->user)->postJson('/api/v3/comment/store', [
            'content' => '评论内容',
            'rt' => BusConstant::COMMENT_RT_VOD_COURSE,
            'rid' => 1,
        ]);
        $this->assertResponseError($response, __('已超出每日评论限制'));
    }

    public function test_comment_on_disabled_course()
    {
        $course = \App\Services\Course\Models\Course::factory()->create([
            'is_show' => 1,
            'published_at' => Carbon::now()->subDays(1),
            'is_allow_comment' => 0,
        ]);

        $response = $this->user($this->user)->postJson('/api/v3/comment/store', [
            'content' => '评论内容',
            'rt' => BusConstant::COMMENT_RT_VOD_COURSE,
            'rid' => $course->id,
        ]);
        $this->assertResponseError($response, __('禁止提交评论'));
    }

    public function test_store_success()
    {
        Artisan::call('cache:clear');

        $course = \App\Services\Course\Models\Course::factory()->create([
            'is_show' => 1,
            'published_at' => Carbon::now()->subDays(1),
            'is_allow_comment' => 1,
        ]);

        $response = $this->user($this->user)->postJson('/api/v3/comment/store', [
            'content' => '评论内容',
            'rt' => BusConstant::COMMENT_RT_VOD_COURSE,
            'rid' => $course['id'],
        ]);

        ['data' => $data] = $this->assertResponseSuccess($response);

        // 验证返回数据
        $this->assertEquals('', $data['content']);

        // 验证数据库
        $comment = Comment::query()
            ->where('content', '评论内容')
            ->where('user_id', $this->user->id)
            ->where('rt', BusConstant::COMMENT_RT_VOD_COURSE)
            ->where('rid', $course['id'])
            ->first();

        $this->assertNotNull($comment, '评论未成功保存到数据库');

        // 验证评论计数缓存
        $cacheKey = sprintf('user_comment_count:%d:%s', $this->user->id, date('Y-m-d'));
        $this->assertEquals(1, Cache::get($cacheKey));
    }

    public function test_uncheck_comment_content()
    {
        // 创建未审核评论
        $comment = Comment::create([
            'user_id' => $this->user->id,
            'rt' => BusConstant::COMMENT_RT_VOD_COURSE,
            'rid' => 1,
            'content' => '未审核内容',
            'is_check' => 0,
        ]);

        $response = $this->user($this->user)->getJson('/api/v3/comments?' . http_build_query([
                'rt' => BusConstant::COMMENT_RT_VOD_COURSE,
                'rid' => 1,
            ]));

        ['data' => $data] = $this->assertResponseSuccess($response);
        $this->assertEquals('', $data['data'][0]['content']);
    }
}
