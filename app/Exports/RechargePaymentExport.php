<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class RechargePaymentExport implements FromCollection, WithMapping, WithHeadings
{
    protected $result = null;

    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function collection()
    {
        return $this->result ?: collect([]);
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->user->nick_name,
            $row->user->mobile.' ',
            $row->money,
            $row->pay_method,
            $row->statusText(),
            $row->third_id,
            $row->created_at,
            $row->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            '用户',
            '手机号',
            '充值金额',
            '支付方式',
            '状态',
            '支付凭证',
            '创建时间',
            '支付时间',
        ];
    }
}
