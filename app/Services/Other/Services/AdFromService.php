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
use App\Services\Other\Interfaces\AdFromServiceInterface;

class AdFromService implements AdFromServiceInterface
{
    /**
     * @return array
     */
    public function all(): array
    {
        return AdFrom::all()->toArray();
    }

    /**
     * @param int $id
     * @param string $day
     * @return array
     */
    public function getDay(int $id, string $day): array
    {
        $day = AdFromNumber::whereFromId($id)->where('day', $day)->first();

        return $day ? $day->toArray() : [];
    }

    /**
     * @param int $id
     * @param array $data
     */
    public function updateDay(int $id, array $data): void
    {
        AdFromNumber::whereId($id)->update($data);
    }

    /**
     * @param int $id
     * @param string $day
     * @param int $num
     * @return array
     */
    public function createDay(int $id, string $day, int $num): array
    {
        $day = AdFromNumber::create([
            'from_id' => $id,
            'day' => $day,
            'num' => $num,
        ]);

        return $day->toArray();
    }

    /**
     * @param string $fromKey
     * @return array
     */
    public function findFromKey(string $fromKey): array
    {
        $adFrom = AdFrom::whereFromKey($fromKey)->first();
        return $adFrom ? $adFrom->toArray() : [];
    }
}
