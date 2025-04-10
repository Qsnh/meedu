<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace ServiceV2\Service;

use Mockery;
use Tests\TestCase;
use App\Exceptions\ServiceException;
use App\Meedu\ServiceV2\Dao\CommentDao;
use App\Meedu\ServiceV2\Services\CommentService;

class CommentServiceTest extends TestCase
{
    protected $commentDao;
    protected $commentService;

    public function setUp(): void
    {
        parent::setUp();
        $this->commentDao = Mockery::mock(CommentDao::class);
        $this->commentService = new CommentService($this->commentDao);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_comments_empty_list()
    {
        // Arrange
        $rt = 1;
        $rid = 1;
        $this->commentDao->shouldReceive('getComments')
            ->once()
            ->with($rt, $rid)
            ->andReturn([]);

        // Act
        $result = $this->commentService->comments($rt, $rid);

        // Assert
        $this->assertEquals(['data' => [], 'total' => 0], $result);
    }

    public function test_comments_with_replies()
    {
        // Arrange
        $rt = 1;
        $rid = 1;
        $comments = [
            [
                'id' => 1,
                'content' => 'Test comment',
                'is_check' => 1,
                'replies' => [
                    [
                        'id' => 2,
                        'content' => 'Test reply',
                        'is_check' => 1
                    ]
                ]
            ]
        ];
        
        $this->commentDao->shouldReceive('getComments')
            ->once()
            ->with($rt, $rid)
            ->andReturn($comments);

        $this->commentDao->shouldReceive('getTotalCount')
            ->once()
            ->with($rt, $rid)
            ->andReturn(1);

        // Act
        $result = $this->commentService->comments($rt, $rid);

        // Assert
        $this->assertEquals(['data' => $comments, 'total' => 1], $result);
    }

    public function test_comments_with_unchecked_content()
    {
        // Arrange
        $rt = 1;
        $rid = 1;
        $comments = [
            [
                'id' => 1,
                'content' => 'Test comment',
                'is_check' => 0,
                'replies' => [
                    [
                        'id' => 2,
                        'content' => 'Test reply',
                        'is_check' => 0
                    ]
                ]
            ]
        ];
        
        $this->commentDao->shouldReceive('getComments')
            ->once()
            ->with($rt, $rid)
            ->andReturn($comments);

        $this->commentDao->shouldReceive('getTotalCount')
            ->once()
            ->with($rt, $rid)
            ->andReturn(1);

        // Act
        $result = $this->commentService->comments($rt, $rid);

        // Assert
        $this->assertEquals(1, count($result['data']));
        $this->assertEquals('', $result['data'][0]['content']);
        $this->assertEquals('', $result['data'][0]['replies'][0]['content']);
    }

    public function test_replies()
    {
        // Arrange
        $rt = 1;
        $rid = 1;
        $parentId = 1;
        $replies = [
            [
                'id' => 2,
                'content' => 'Test reply',
                'is_check' => 1
            ]
        ];

        $this->commentDao->shouldReceive('getAllChildComments')
            ->once()
            ->with($rt, $rid, $parentId)
            ->andReturn($replies);

        // Act
        $result = $this->commentService->replies($rt, $rid, $parentId);

        // Assert
        $this->assertEquals($replies, $result);
    }

    public function test_replies_with_unchecked_content()
    {
        // Arrange
        $rt = 1;
        $rid = 1;
        $parentId = 1;
        $replies = [
            [
                'id' => 2,
                'content' => 'Test reply',
                'is_check' => 0
            ]
        ];

        $this->commentDao->shouldReceive('getAllChildComments')
            ->once()
            ->with($rt, $rid, $parentId)
            ->andReturn($replies);

        // Act
        $result = $this->commentService->replies($rt, $rid, $parentId);

        // Assert
        $this->assertEquals('', $result[0]['content']);
    }

    public function test_create_simple_comment()
    {
        // Arrange
        $data = [
            'parent_id' => 0,
            'reply_id' => 0,
            'content' => 'Test comment'
        ];

        $createdComment = [
            'id' => 1,
            'content' => 'Test comment',
            'created_at' => '2024-01-01 00:00:00',
            'parent_id' => 0,
            'reply_id' => 0,
            'ip_province' => 'Test Province'
        ];

        $this->commentDao->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($createdComment);

        // Act
        $result = $this->commentService->create($data);

        // Assert
        $this->assertEquals($createdComment, $result);
    }

    public function test_create_with_invalid_parent()
    {
        // Arrange
        $data = [
            'parent_id' => 1000,
            'reply_id' => 0,
            'content' => 'Test reply'
        ];

        $this->commentDao->shouldReceive('findById')
            ->once()
            ->with(1000, ['id', 'is_check'])
            ->andReturn([]);

        // Assert
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        // Act
        $this->commentService->create($data);
    }

    public function test_create_with_unchecked_parent()
    {
        // Arrange
        $data = [
            'parent_id' => 1,
            'reply_id' => 0,
            'content' => 'Test reply'
        ];

        $this->commentDao->shouldReceive('findById')
            ->once()
            ->with(1, ['id', 'is_check'])
            ->andReturn(['id' => 1, 'is_check' => 0]);

        // Assert
        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage('不支持回复');

        // Act
        $this->commentService->create($data);
    }

    public function test_create_with_invalid_reply()
    {
        // Arrange
        $data = [
            'parent_id' => 2000,
            'reply_id' => 2001,
            'content' => 'Test reply'
        ];

        $this->commentDao->shouldReceive('findById')
            ->once()
            ->with(2000, ['id', 'is_check'])
            ->andReturn(['id' => 2000, 'is_check' => 1]);

        $this->commentDao->shouldReceive('findById')
            ->once()
            ->with(2001, ['id', 'is_check'], ['parent_id' => 2000])
            ->andReturn([]);

        // Assert
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        // Act
        $this->commentService->create($data);
    }
}
