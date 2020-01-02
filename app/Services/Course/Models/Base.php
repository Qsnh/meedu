<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Course\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    /**
     * 查询字段.
     *
     * @param bool $id
     *
     * @return array|int
     */
    public function getSelectFields($id = true)
    {
        $fields = $this->fillable;
        $id && $fields = array_push($fields, 'id');

        return $fields;
    }
}
