<?php

use Illuminate\Database\Seeder;

class DefaultTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! \App\Models\Template::whereName('default')->exists()) {
            \App\Models\Template::create([
                'name' => 'default',
                'path' => resource_path('views'),
                'real_path' => resource_path('views'),
                'author' => 'XiaoTeng',
                'current_version' => '0.1',
                'thumb' => '',
            ]);
        }
    }
}
