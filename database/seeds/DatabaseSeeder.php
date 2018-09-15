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
        if (app()->environment('local')) {
            $this->call(CourseSeeder::class);
            $this->call(CourseVideoSeeder::class);
            $this->call(UserSeeder::class);
        }
    }
}
