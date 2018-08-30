<?php

namespace App\Observers;


use App\Models\CourseComment;

class CourseCommentObserver
{

    public function saved(CourseComment $comment)
    {
        at_user($comment->content, $comment->user, $comment, 'CourseComment');
    }

}