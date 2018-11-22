<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App;

use Exception;
use Carbon\Carbon;
use App\Models\Book;
use App\Models\Role;
use App\Models\Order;
use App\Models\Video;
use App\Models\Course;
use App\Models\OrderGoods;
use App\Models\VideoComment;
use App\Models\CourseComment;
use App\Models\RechargePayment;
use App\Models\UserJoinRoleRecord;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use App\Models\traits\CreatedAtBetween;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, CreatedAtBetween, HasApiTokens;

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
     * 重载passport方法.
     *
     * @param $name
     *
     * @return mixed
     */
    public function findForPassport($name)
    {
        return self::whereMobile($name)->first();
    }

    /**
     * 所属角色.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * 获取随机呢称.
     *
     * @return string
     */
    public static function randomNickName()
    {
        return 'random.'.str_random(10);
    }

    /**
     * 该用户下的课程.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'user_id', 'id');
    }

    /**
     * 用户加入（购买）的课程.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function joinCourses()
    {
        return $this->belongsToMany(Course::class, 'user_course', 'user_id', 'course_id')
            ->withPivot('created_at', 'charge');
    }

    /**
     * 用户购买的视频.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function buyVideos()
    {
        return $this->belongsToMany(Video::class, 'user_video', 'user_id', 'video_id')
            ->withPivot('created_at', 'charge');
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
     * 用户的课程评论.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseComments()
    {
        return $this->hasMany(CourseComment::class, 'user_id');
    }

    /**
     * 用户的视频评论.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videoComments()
    {
        return $this->hasMany(VideoComment::class, 'user_id');
    }

    /**
     * 方法：加入一个课程.
     *
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
     * 方法：购买一个视频.
     *
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
     * 头像修饰器.
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getAvatarAttribute($avatar)
    {
        return $avatar ?: url(config('meedu.member.default_avatar'));
    }

    /**
     * 充值订单.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rechargePayments()
    {
        return $this->hasMany(RechargePayment::class, 'user_id');
    }

    /**
     * 关联订单.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * 余额扣除.
     *
     * @param $money
     */
    public function credit1Dec($money)
    {
        $this->credit1 -= $money;
        $this->save();
    }

    /**
     * 判断用户是否可以观看指定的视频.
     *
     * @param Video $video
     *
     * @return bool
     */
    public function canSeeThisVideo(Video $video)
    {
        $course = $video->course;
        if ($course->charge == 0 || $video->charge == 0) {
            return true;
        }

        // 是否是会员
        if ($this->activeRole()) {
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

    /**
     * 是否为有效会员.
     *
     * @return bool
     */
    public function activeRole()
    {
        return $this->role_id && time() < strtotime($this->role_expired_at);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function joinRoles()
    {
        return $this->hasMany(UserJoinRoleRecord::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'user_book', 'user_id', 'book_id');
    }

    /**
     * @param Role $role
     *
     * @throws \Throwable
     */
    public function buyRole(Role $role)
    {
        throw_if($this->role && $this->role->weight != $role->weight, new Exception('该账户已经存在会员记录'));

        if ($this->role) {
            $startDate = $this->role_expired_at;
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->role_expired_at)->addDays($role->expire_days);
        } else {
            $startDate = Carbon::now();
            $endDate = Carbon::now()->addDays($role->expire_days);
        }

        $this->role_id = $role->id;
        $this->role_expired_at = $endDate;
        $this->save();

        $this->joinRoles()->save(new UserJoinRoleRecord([
            'role_id' => $this->role_id,
            'charge' => $role->charge,
            'started_at' => $startDate,
            'expired_at' => $endDate,
        ]));
    }

    /**
     * 购买书籍处理.
     *
     * @param Book $book
     *
     * @throws Exception
     */
    public function buyBook(Book $book)
    {
        if ($this->books()->whereId($book->id)->exists()) {
            throw new Exception('请勿重复购买');
        }
        $this->books()->attach($book->id);
    }

    /**
     * 今日注册用户数量.
     *
     * @return mixed
     */
    public static function todayRegisterCount()
    {
        return self::createdAtBetween(
            Carbon::now()->format('Y-m-d'),
            Carbon::now()->addDays(1)->format('Y-m-d')
        )->count();
    }

    /**
     * 订单成功的处理.
     *
     * @param Order $order
     *
     * @return bool
     *
     * @throws \Throwable
     */
    public function handlerOrderSuccess(Order $order)
    {
        $goods = $order->goods;
        DB::beginTransaction();
        try {
            foreach ($goods as $goodsItem) {
                switch ($goodsItem->goods_type) {
                    case OrderGoods::GOODS_TYPE_COURSE:
                        $course = Course::find($goodsItem->goods_id);
                        $this->joinACourse($course);
                        break;
                    case OrderGoods::GOODS_TYPE_VIDEO:
                        $video = Video::find($goodsItem->goods_id);
                        $this->buyAVideo($video);
                        break;
                    case OrderGoods::GOODS_TYPE_ROLE:
                        $role = Role::find($goodsItem->goods_id);
                        $this->buyRole($role);
                        break;
                    case OrderGoods::GOODS_TYPE_BOOK:
                        $book = Book::find($goodsItem->goods_id);
                        $this->buyBook($book);
                        break;
                }
            }

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);

            return false;
        }
    }

    /**
     * 是否可以观看指定电子书.
     *
     * @param Book $book
     *
     * @return mixed
     */
    public function canSeeThisBook(Book $book)
    {
        if ($book->charge <= 0) {
            return true;
        }

        if ($this->activeRole()) {
            return true;
        }

        return $this->books()->whereId($book->id)->exists();
    }
}
