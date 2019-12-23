<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Other\Services;

use App\Services\Other\Models\AdFrom;
use App\Services\Other\Models\AdFromNumber;

class AdFromService
{
    public function all(): array
    {
        return AdFrom::all()->toArray();
    }

    public function getDay(int $id, string $day): array
    {
        $day = AdFromNumber::whereFromId($id)->whereDay($day)->first();

        return $day ? $day->toArray() : [];
    }

    public function updateDay(int $id, array $data)
    {
        AdFromNumber::whereId($id)->update($data);
    }

    public function createDay(int $id, string $day, int $num): array
    {
        $day = AdFromNumber::create([
            'from_id' => $id,
            'day' => $day,
            'num' => $num,
        ]);

        return $day->toArray();
    }
}
