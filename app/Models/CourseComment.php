<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseComment extends Model
{
    use SoftDeletes, Scope;

    protected $table = 'course_comments';

    protected $fillable = [
        'user_id', 'course_id', 'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function getContent()
    {
        return (new \Parsedown)->text($this->content);
    }

}
