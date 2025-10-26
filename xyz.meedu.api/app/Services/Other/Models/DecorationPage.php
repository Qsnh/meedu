<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Models;

use Illuminate\Database\Eloquent\Model;

class DecorationPage extends Model
{
    protected $table = 'decoration_pages';

    protected $fillable = [
        'name', 'page_key', 'is_default',
    ];

    protected $casts = [
        'is_default' => 'integer',
    ];

    /**
     * 关联的装修块
     */
    public function viewBlocks()
    {
        return $this->hasMany(ViewBlock::class, 'decoration_page_id', 'id');
    }
}
