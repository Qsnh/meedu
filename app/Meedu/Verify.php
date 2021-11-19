<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu;

class Verify
{
    public function gen($data = [])
    {
        $data = array_merge($data, [
            'expired_at' => time() + 3600,
        ]);
        return encrypt($data);
    }

    public function check(string $sign)
    {
        try {
            $data = decrypt($sign);
            if (!$data) {
                return false;
            }
            $expiredAt = $data['expired_at'] ?? 0;
            if (time() > $expiredAt) {
                return false;
            }

            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }
}
