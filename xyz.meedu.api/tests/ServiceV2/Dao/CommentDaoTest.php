<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\ServiceV2\Dao;

use Tests\TestCase;
use App\Meedu\ServiceV2\Dao\CommentDao;
use App\Meedu\ServiceV2\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentDaoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var CommentDao
     */
    protected $commentDao;

    public function setUp(): void
    {
        parent::setUp();
        $this->commentDao = new CommentDao();
    }

    public function test_get_comments_empty()
    {
        $rt = 1;
        $rid = 1;
        
        $comments = $this->commentDao->getComments($rt, $rid);
        
        $this->assertEmpty($comments);
    }

    public function test_get_comments_with_replies()
    {
        // Create parent comment
        $parentComment = Comment::create([
            'user_id' => 1,
            'rt' => 1,
            'rid' => 1,
            'parent_id' => 0,
            'reply_id' => 0,
            'content' => 'Parent comment',
            'ip' => '127.0.0.1',
            'ip_province' => 'Test Province',
            'is_check' => 1,
        ]);

        // Create reply
        Comment::create([
            'user_id' => 2,
            'rt' => 1,
            'rid' => 1,
            'parent_id' => $parentComment->id,
            'reply_id' => 0,
            'content' => 'Reply comment',
            'ip' => '127.0.0.1',
            'ip_province' => 'Test Province',
            'is_check' => 1,
        ]);

        $comments = $this->commentDao->getComments(1, 1);

        $this->assertCount(1, $comments);
        $this->assertEquals('Parent comment', $comments[0]['content']);
        $this->assertCount(1, $comments[0]['replies']);
        $this->assertEquals('Reply comment', $comments[0]['replies'][0]['content']);
    }

    public function test_get_all_child_comments()
    {
        // Create parent comment
        $parentComment = Comment::create([
            'user_id' => 1,
            'rt' => 1,
            'rid' => 1,
            'parent_id' => 0,
            'reply_id' => 0,
            'content' => 'Parent comment',
            'ip' => '127.0.0.1',
            'ip_province' => 'Test Province',
            'is_check' => 1,
        ]);

        // Create multiple replies
        for ($i = 0; $i < 3; $i++) {
            Comment::create([
                'user_id' => 2,
                'rt' => 1,
                'rid' => 1,
                'parent_id' => $parentComment->id,
                'reply_id' => 0,
                'content' => "Reply comment {$i}",
                'ip' => '127.0.0.1',
                'ip_province' => 'Test Province',
                'is_check' => 1,
            ]);
        }

        $replies = $this->commentDao->getAllChildComments(1, 1, $parentComment->id);

        $this->assertCount(3, $replies);
        $this->assertEquals('Reply comment 0', $replies[0]['content']);
        $this->assertEquals('Reply comment 1', $replies[1]['content']);
        $this->assertEquals('Reply comment 2', $replies[2]['content']);
    }

    public function test_get_comments_by_ids()
    {
        // Create multiple comments
        $comments = [];
        for ($i = 0; $i < 3; $i++) {
            $comments[] = Comment::create([
                'user_id' => 1,
                'rt' => 1,
                'rid' => 1,
                'parent_id' => 0,
                'reply_id' => 0,
                'content' => "Comment {$i}",
                'ip' => '127.0.0.1',
                'ip_province' => 'Test Province',
                'is_check' => 1,
            ]);
        }

        $commentIds = array_column($comments, 'id');
        $result = $this->commentDao->getCommentsByIds($commentIds);

        $this->assertCount(3, $result);
        foreach ($result as $comment) {
            $this->assertContains($comment['id'], $commentIds);
        }
    }

    public function test_create_comment()
    {
        $data = [
            'user_id' => 1,
            'rt' => 1,
            'rid' => 1,
            'content' => 'Test comment',
            'ip' => '127.0.0.1',
            'province' => 'Test Province',
        ];

        $comment = $this->commentDao->create($data);

        $this->assertNotNull($comment['id']);
        $this->assertEquals($data['content'], $comment['content']);
        $this->assertEquals($data['user_id'], $comment['user_id']);
        $this->assertEquals($data['rt'], $comment['rt']);
        $this->assertEquals($data['rid'], $comment['rid']);
        $this->assertEquals(0, $comment['is_check']); // Default value
    }

    public function test_find_by_id()
    {
        // Create a comment
        $comment = Comment::create([
            'user_id' => 1,
            'rt' => 1,
            'rid' => 1,
            'parent_id' => 0,
            'reply_id' => 0,
            'content' => 'Test comment',
            'ip' => '127.0.0.1',
            'ip_province' => 'Test Province',
            'is_check' => 1,
        ]);

        $result = $this->commentDao->findById($comment->id, ['id', 'content', 'is_check']);

        $this->assertEquals($comment->id, $result['id']);
        $this->assertEquals($comment->content, $result['content']);
        $this->assertEquals($comment->is_check, $result['is_check']);
    }

    public function test_find_by_id_with_parent_filter()
    {
        // Create parent comment
        $parentComment = Comment::create([
            'user_id' => 1,
            'rt' => 1,
            'rid' => 1,
            'parent_id' => 0,
            'reply_id' => 0,
            'content' => 'Parent comment',
            'ip' => '127.0.0.1',
            'ip_province' => 'Test Province',
            'is_check' => 1,
        ]);

        // Create reply
        $replyComment = Comment::create([
            'user_id' => 2,
            'rt' => 1,
            'rid' => 1,
            'parent_id' => $parentComment->id,
            'reply_id' => 0,
            'content' => 'Reply comment',
            'ip' => '127.0.0.1',
            'ip_province' => 'Test Province',
            'is_check' => 1,
        ]);

        $result = $this->commentDao->findById($replyComment->id, ['id', 'content'], ['parent_id' => $parentComment->id]);

        $this->assertEquals($replyComment->id, $result['id']);
        $this->assertEquals($replyComment->content, $result['content']);
    }

    public function test_find_by_id_with_invalid_filter()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('下面参数 invalid_param 不支持过滤');

        $this->commentDao->findById(1, ['id'], ['invalid_param' => 'value']);
    }

    public function test_get_total_count()
    {
        // Create multiple comments
        for ($i = 0; $i < 5; $i++) {
            Comment::create([
                'user_id' => 1,
                'rt' => 1,
                'rid' => 1,
                'parent_id' => 0,
                'reply_id' => 0,
                'content' => "Comment {$i}",
                'ip' => '127.0.0.1',
                'ip_province' => 'Test Province',
                'is_check' => 1,
            ]);
        }

        // Create comments for different rt/rid
        Comment::create([
            'user_id' => 1,
            'rt' => 2,
            'rid' => 1,
            'parent_id' => 0,
            'reply_id' => 0,
            'content' => 'Different rt',
            'ip' => '127.0.0.1',
            'ip_province' => 'Test Province',
            'is_check' => 1,
        ]);

        $count = $this->commentDao->getTotalCount(1, 1);

        $this->assertEquals(5, $count);
    }
}
