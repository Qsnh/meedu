<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use App\Meedu\Cache\Impl\ActiveAgreementCache;
use App\Meedu\ServiceV2\Models\Agreement;
use Illuminate\Console\Command;
use Mews\Purifier\Facades\Purifier;

class AgreementSanitizeCommand extends Command
{
    protected $signature = 'agreement:sanitize-history {--dry-run : 仅打印差异,不写库}';

    protected $description = '使用 HTMLPurifier 净化 agreements 表中的存量内容,并清理生效协议缓存';

    public function handle(): int
    {
        $dryRun = (bool)$this->option('dry-run');

        $total = 0;
        $changed = 0;
        $changedTypes = [];

        Agreement::query()->orderBy('id')->chunkById(100, function ($rows) use (&$total, &$changed, &$changedTypes, $dryRun) {
            foreach ($rows as $agreement) {
                $total++;
                $clean = Purifier::clean((string)$agreement->content, 'default');
                if ($clean === $agreement->content) {
                    continue;
                }

                $changed++;
                $changedTypes[$agreement->type] = true;

                $this->line(sprintf('agreement id=%d type=%s 将被净化', $agreement->id, $agreement->type));

                if (!$dryRun) {
                    $agreement->content = $clean;
                    $agreement->save();
                }
            }
        });

        $this->info(sprintf('扫描 %d 条,需净化 %d 条%s', $total, $changed, $dryRun ? ' (dry-run,未写库)' : ''));

        if (!$dryRun && $changed > 0) {
            foreach (array_keys($changedTypes) as $type) {
                ActiveAgreementCache::forget($type);
            }
            $this->info('已清理涉及 type 的生效协议缓存');
        }

        return self::SUCCESS;
    }
}
