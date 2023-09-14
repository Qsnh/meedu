<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Models;

use Illuminate\Database\Eloquent\Model;

class ViewBlock extends Model
{
    protected $table = 'view_blocks';

    protected $fillable = [
        'platform', 'page', 'sign', 'sort', 'config',
    ];

    protected $appends = [
        'config_render',
    ];

    public function getConfigRenderAttribute()
    {
        if (!$this->config) {
            return [];
        }
        return json_decode($this->config, true);
    }
}
