<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Illuminate\Database\Seeder;

class AdministratorSuperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superSlug = config('meedu.administrator.super_slug');
        $exists = \App\Models\AdministratorRole::whereSlug($superSlug)->exists();
        if ($exists) {
            return;
        }
        \App\Models\AdministratorRole::create([
            'display_name' => '超级管理员',
            'slug' => $superSlug,
            'description' => '创世角色',
        ]);
    }
}
