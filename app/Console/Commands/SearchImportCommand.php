<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Meedu\Core\UpgradeLog\UpgradeToV45;

class SearchImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meedu:search:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '全文搜索数据导入';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        UpgradeToV45::courseAndVideoMigrateMeiliSearch();
        return Command::SUCCESS;
    }
}
