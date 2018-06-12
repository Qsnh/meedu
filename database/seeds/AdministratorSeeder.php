<?php

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = [
            'name' => '超级管理员',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
        ];
        if (! \App\Models\Administrator::where('email', $administrator['email'])->first()) {
            $administrator = new \App\Models\Administrator($administrator);
            $administrator->save();
        }
    }
}
