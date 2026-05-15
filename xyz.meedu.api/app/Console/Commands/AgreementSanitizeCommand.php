<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use App\Events\AgreementChangeEvent;
use App\Meedu\ServiceV2\Models\Agreement;
use App\Meedu\ServiceV2\Services\AgreementService;
use Illuminate\Console\Command;

class AgreementSanitizeCommand extends Command
{
    protected $signature = 'agreement:sanitize-history {--dry-run : 仅打印差异,不写库}';

    protected $description = '使用 HTMLPurifier 净化 agreements 表中的存量内容,并清理生效协议缓存';

    public function handle(): int
    {
        $dryRun = (bool)$this->option('dry-run');

        $total = 0;
        $changed = 0;
        $changedAgreements = [];

        Agreement::query()->orderBy('id')->chunkById(100, function ($rows) use (&$total, &$changed, &$changedAgreements, $dryRun) {
            foreach ($rows as $agreement) {
                $total++;

                $original = (string)$agreement->content;
                if ($original === '') {
                    continue;
                }

                $clean = AgreementService::sanitizeContent($original);
                if ($clean === $original) {
                    continue;
                }

                $changed++;
                $changedAgreements[$agreement->id] = $agreement->type;

                $this->line(sprintf('agreement id=%d type=%s 将被净化', $agreement->id, $agreement->type));

                if (!$dryRun) {
                    $agreement->content = $clean;
                    $agreement->save();
                }
            }
        });

        $this->info(sprintf('扫描 %d 条,需净化 %d 条%s', $total, $changed, $dryRun ? ' (dry-run,未写库)' : ''));

        if (!$dryRun && $changed > 0) {
            foreach ($changedAgreements as $id => $type) {
                event(new AgreementChangeEvent((int)$id, (string)$type));
            }
            $this->info('已派发协议变更事件,生效协议缓存将由监听器清理');
        }

        return self::SUCCESS;
    }
}
