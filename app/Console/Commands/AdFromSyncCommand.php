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

use App\Models\AdFrom;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

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

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $adFroms = AdFrom::all();
        foreach ($adFroms as $from) {
            $date = date('Y-m-d');
            $key = sprintf('ad_from_%s_%s', $from->from_key, $date);
            if (! Cache::has($key)) {
                continue;
            }
            $record = $from->numbers()->where('day', $date)->first();
            $num = Cache::get($key, 0);
            if ($record) {
                $record->update(['num' => $record->num + $num]);
            } else {
                $from->numbers()->create([
                    'day' => $date,
                    'num' => $num,
                ]);
            }
            Cache::forget($key);
        }
    }
}
