<?php

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
        ! $exists && \App\Models\AdministratorRole::create([
            'display_name' => '超级管理员',
            'slug' => config('meedu.administrator.super_slug'),
            'description' => '创世角色',
        ]);
    }
}
