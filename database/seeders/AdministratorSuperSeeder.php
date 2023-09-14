<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Database\Seeders;

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
