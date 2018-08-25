<?php

namespace App\Models;

trait Scope
{

    public function scopeDes($query)
    {
        return $query->orderByDesc('created_at');
    }

}