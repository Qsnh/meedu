<?php

use Illuminate\Database\Seeder;

class CourseVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Video::class, 50)->create();
    }
}
