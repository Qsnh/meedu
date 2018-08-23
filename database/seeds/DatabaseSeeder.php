<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdministratorSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(CourseVideoSeeder::class);
        $this->call(UserSeeder::class);
    }
}
