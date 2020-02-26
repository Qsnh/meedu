<?php


namespace Tests\Commands;


use App\Meedu\Setting;
use Illuminate\Filesystem\Filesystem;
use Tests\OriginalTestCase;

class TemplateSwitchCommandTest extends OriginalTestCase
{

    public function tearDown(): void
    {
        $config = [];
        $config['meedu.system.theme.use'] = 'default';
        $config['meedu.system.theme.path'] = resource_path('views');
        app()->make(Setting::class)->append($config);

        parent::tearDown();
    }

    public function test_run()
    {
        $this->artisan('template:switch', ['template' => 'demo'])
            ->expectsOutput('模板不存在');

        $file = $this->app->make(Filesystem::class);
        $file->deleteDirectory(base_path('templates/demo'));

        $file->makeDirectory(base_path('templates/demo'), 0755, true);
        $this->artisan('template:switch', ['template' => 'demo'])
            ->assertExitCode(0)
            ->expectsOutput('success');

        $this->assertEquals(config('meedu.system.theme.use'), 'demo');

        $file->deleteDirectory(base_path('templates/demo'));
    }

    public function test_run_with_default()
    {
        $this->artisan('template:switch', ['template' => 'default'])
            ->expectsOutput('success');

        $this->assertEquals(resource_path('views'), config('meedu.system.theme.path'));
    }

}