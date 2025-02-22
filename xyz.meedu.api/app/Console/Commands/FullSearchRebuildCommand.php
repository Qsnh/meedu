<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\FullSearchDataRebuildEvent;
use App\Meedu\ServiceV2\Services\FullSearchServiceInterface;
use Symfony\Component\Console\Command\Command as CommandAlias;

class FullSearchRebuildCommand extends Command
{
    protected $signature = 'meedu:full-search:rebuild';

    protected $description = '重新构建全文搜索数据';

    protected $fullSearchService;

    public function __construct(FullSearchServiceInterface $fullSearchService)
    {
        parent::__construct();
        $this->fullSearchService = $fullSearchService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->fullSearchService->clear();
        event(new FullSearchDataRebuildEvent());
        $this->line(__('已发起全文搜索数据重建任务。这个过程需要数分钟完成，请耐心等待！'));
        return CommandAlias::SUCCESS;
    }
}
