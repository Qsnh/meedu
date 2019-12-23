<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Services\Other\Services\AdFromService;

class AdFromSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adfrom:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'adfrom data sync.';

    protected $adFromService;

    /**
     * AdFromSyncCommand constructor.
     *
     * @param AdFromService $adFromService
     */
    public function __construct(AdFromService $adFromService)
    {
        parent::__construct();
        $this->adFromService = $adFromService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $adFrom = $this->adFromService->all();
        foreach ($adFrom as $from) {
            $date = date('Y-m-d');
            $key = sprintf('ad_from_%s_%s', $from['from_key'], $date);
            if (! Cache::has($key)) {
                continue;
            }
            $record = $this->adFromService->getDay($from['id'], $date);
            $num = Cache::get($key, 0);
            if ($record) {
                $this->adFromService->updateDay($record['id'], [
                    'num' => $record['num'] + $num,
                ]);
            } else {
                $this->adFromService->createDay($from['id'], $date, intval($num));
            }
            Cache::forget($key);
        }
    }
}
