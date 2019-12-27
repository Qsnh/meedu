<?php


namespace Tests\Services\Course;


use App\Services\Course\Interfaces\VideoCommentServiceInterface;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\VideoComment;
use App\Services\Course\Services\VideoCommentService;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class VideoCommentServiceTest extends TestCase
{

    /**
     * @var VideoCommentService
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = $this->app->make(VideoCommentServiceInterface::class);
    }

    public function test_create()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $video = factory(Video::class)->create();

        $comment = $this->service->create($video->id, '我是评价的内容');

        $this->assertEquals('我是评价的内容', $comment['original_content']);
        $this->assertEquals($user->id, $comment['user_id']);
    }

    public function test_courseComments()
    {
        $video = factory(Video::class)->create();
        $comments = factory(VideoComment::class, 10)->create([
            'video_id' => $video,
            'user_id' => 1,
        ]);

        $list = $this->service->videoComments($video->id);
        $this->assertEquals($comments->count(), count($list));
    }

}