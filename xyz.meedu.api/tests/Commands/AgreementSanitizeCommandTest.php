<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Commands;

use Tests\OriginalTestCase;
use App\Constant\AgreementConstant;
use Illuminate\Support\Facades\Cache;
use App\Meedu\ServiceV2\Models\Agreement;
use App\Meedu\Cache\Impl\ActiveAgreementCache;

class AgreementSanitizeCommandTest extends OriginalTestCase
{
    public function test_command_strips_script_from_existing_rows()
    {
        $type = array_key_first(AgreementConstant::TYPES);

        $agreement = Agreement::query()->create([
            'type' => $type,
            'title' => '历史协议',
            'content' => '<p>合法</p><script>alert(1)</script>',
            'version' => 'v0',
            'is_active' => 0,
        ]);

        $this->artisan('agreement:sanitize-history')->assertExitCode(0);

        $agreement->refresh();
        $this->assertStringNotContainsString('<script', $agreement->content);
        $this->assertStringNotContainsString('alert(1)', $agreement->content);
    }

    public function test_dry_run_does_not_modify_data()
    {
        $type = array_key_first(AgreementConstant::TYPES);
        $original = '<p>正文</p><script>alert(1)</script>';

        $agreement = Agreement::query()->create([
            'type' => $type,
            'title' => '历史协议',
            'content' => $original,
            'version' => 'v0',
            'is_active' => 0,
        ]);

        $this->artisan('agreement:sanitize-history', ['--dry-run' => true])->assertExitCode(0);

        $agreement->refresh();
        $this->assertSame($original, $agreement->content);
    }

    public function test_command_clears_active_agreement_cache()
    {
        $type = array_key_first(AgreementConstant::TYPES);

        Agreement::query()->create([
            'type' => $type,
            'title' => '历史协议',
            'content' => '<script>alert(1)</script>',
            'version' => 'v1',
            'is_active' => 1,
            'effective_at' => now()->subDay(),
        ]);

        Cache::put(sprintf(ActiveAgreementCache::CACHE_KEY, $type), ['stale' => true], 60);

        $this->artisan('agreement:sanitize-history')->assertExitCode(0);

        $this->assertFalse(Cache::has(sprintf(ActiveAgreementCache::CACHE_KEY, $type)));
    }
}
