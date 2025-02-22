<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\PublishedCoursesSearchIndexBuildEvent;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;
use Symfony\Component\Console\Command\Command as CommandAlias;

class PublishedCoursesIndexBuildSearchCommand extends Command
{
    protected $signature = 'meedu:full-search:published-courses-index';

    protected $description = '已经上架的课程定时建立搜索索引';

    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        parent::__construct();
        $this->configService = $configService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->configService->enabledFullSearch()) {
            return CommandAlias::SUCCESS;
        }

        event(new PublishedCoursesSearchIndexBuildEvent());

        return CommandAlias::SUCCESS;
    }
}
