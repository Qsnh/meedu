<?php

namespace App;

use App\Models\Course;
use App\Models\CourseComment;
use App\Models\Order;
use App\Models\RechargePayment;
use App\Models\Role;
use App\Models\Video;
use App\Models\VideoComment;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ACTIVE_YES = 1;
    const ACTIVE_NO = -1;

    const LOCK_YES = 1;
    const LOCK_NO = -1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'nick_name', 'mobile', 'password',
        'is_lock', 'is_active', 'role_id', 'role_expired_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'show_url', 'credit1_text', 'credit2_text', 'credit3_text',
    ];

    /**
     * 所属角色
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * 获取随机呢称
     * @return string
     */
    public static function randomNickName()
    {
        return 'random.' . str_random(10);
    }

    /**
     * 该用户下的课程
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'user_id', 'id');
    }

    /**
     * 用户加入（购买）的课程
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function joinCourses()
    {
        return $this->belongsToMany(Course::class, 'user_course', 'user_id', 'course_id')->withPivot('created_at', 'charge');
    }

    /**
     * 用户购买的视频
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function buyVideos()
    {
        return $this->belongsToMany(Video::class, 'user_video', 'user_id', 'video_id')->withPivot('created_at', 'charge');
    }

    public function getShowUrlAttribute()
    {
        return route('backend.member.show', $this);
    }

    public function getCredit1TextAttribute()
    {
        return config('meedu.credit.credit1.name');
    }

    public function getCredit2TextAttribute()
    {
        return config('meedu.credit.credit2.name');
    }

    public function getCredit3TextAttribute()
    {
        return config('meedu.credit.credit3.name');
    }

    /**
     * 用户的课程评论
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseComments()
    {
        return $this->hasMany(CourseComment::class, 'user_id');
    }

    /**
     * 用户的视频评论
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videoComments()
    {
        return $this->hasMany(VideoComment::class, 'user_id');
    }

    /**
     * 方法：加入一个课程
     * @param Course $course
     */
    public function joinACourse(Course $course)
    {
        if (! $this->joinCourses()->whereId($course->id)->exists()) {
            $this->joinCourses()->attach($course->id, [
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'charge' => $course->charge,
            ]);
        }
    }

    /**
     * 方法：购买一个视频
     * @param Video $video
     */
    public function buyAVideo(Video $video)
    {
        if (! $this->buyVideos()->whereId($video->id)->exists()) {
            $this->buyVideos()->attach($video->id, [
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'charge' => $video->charge,
            ]);
        }
    }

    /**
     * 头像修饰器
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getAvatarAttribute($avatar)
    {
        return $avatar ?: config('meedu.member.default_avatar');
    }

    /**
     * 充值订单
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rechargePayments()
    {
        return $this->hasMany(RechargePayment::class, 'user_id');
    }

    /**
     * 关联订单
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * 余额扣除
     * @param $money
     */
    public function credit1Dec($money)
    {
        $this->credit1 -= $money;
        $this->save();
    }

    /**
     * 判断用户是否可以观看指定的视频
     * @param Video $video
     * @return bool
     */
    public function canSeeThisVideo(Video $video)
    {
        $course = $video->course;
        if ($video->charge == 0 && $course->charge == 0) {
            return true;
        }

        // 是否加入课程
        $hasJoinCourse = $this->joinCourses()->whereId($video->course->id)->exists();
        if ($hasJoinCourse) {
            return true;
        }

        // 是否购买视频
        return $this->buyVideos()->whereId($video->id)->exists();
    }

}
