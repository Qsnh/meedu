<?php

namespace App;

use App\Models\Course;
use App\Models\CourseComment;
use App\Models\Role;
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
        return $this->belongsToMany(Course::class, 'user_course', 'user_id', 'course_id')->withPivot('created_at');
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
     * 方法：加入课程
     * @param Course $course
     */
    public function joinACourse(Course $course)
    {
        if (! $this->joinCourses()->whereId($course->id)->exists()) {
            $this->joinCourses()->attach($course->id, ['created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }
    }

}
