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
        factory(\App\Services\Course\Models\Video::class, 20)->create();
    }
}
