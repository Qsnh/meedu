<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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
