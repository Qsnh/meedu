<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Services\Member;

use Tests\TestCase;
use App\Services\Member\Models\User;
use App\Services\Member\Services\CreditService;
use App\Services\Member\Models\UserCreditRecord;
use App\Services\Member\Interfaces\CreditServiceInterface;

class CreditServiceTest extends TestCase
{

    /**
     * @var CreditService
     */
    protected $service;

    public function setUp():void
    {
        parent::setUp();
        $this->service = $this->app->make(CreditServiceInterface::class);
    }

    public function test_createCredit1Record()
    {
        $user = factory(User::class)->create(['credit1' => 1]);
        $this->service->createCredit1Record($user->id, 100, 'meedu123');

        $record = UserCreditRecord::query()->where('user_id', $user->id)->where('field', 'credit1')->first();
        $this->assertNotEmpty($record);
        $this->assertEquals(100, $record->sum);
        $this->assertEquals('meedu123', $record->remark);

        $user->refresh();
        $this->assertEquals(101, $user->credit1);
    }

    public function test_getCredit1RecordsPaginate()
    {
        $user = factory(User::class)->create(['credit1' => 1]);
        UserCreditRecord::create([
            'user_id' => $user->id,
            'field' => 'credit1',
            'sum' => 1,
            'remark' => 1,
        ]);
        UserCreditRecord::create([
            'user_id' => $user->id,
            'field' => 'credit1',
            'sum' => 1,
            'remark' => 1,
        ]);
        UserCreditRecord::create([
            'user_id' => $user->id,
            'field' => 'credit1',
            'sum' => 1,
            'remark' => 1,
        ]);
        $data = $this->service->getCredit1RecordsPaginate($user->id, 1, 10);
        $this->assertEquals(3, count($data));
    }

    public function test_getCredit1RecordsCount()
    {
        $user = factory(User::class)->create(['credit1' => 1]);
        UserCreditRecord::create([
            'user_id' => $user->id,
            'field' => 'credit1',
            'sum' => 1,
            'remark' => 1,
        ]);
        UserCreditRecord::create([
            'user_id' => $user->id,
            'field' => 'credit1',
            'sum' => 1,
            'remark' => 1,
        ]);

        $this->assertEquals(2, $this->service->getCredit1RecordsCount($user->id));
    }
}
