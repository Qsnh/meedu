<?php


namespace Tests\Unit\Meedu;


use App\Meedu\Tencent\Vod;
use Tests\TestCase;

class VodTest extends TestCase
{

    public function test_vod()
    {
        $vod = new Vod();
        $vod->getUploadSignature();
        $this->assertTrue(true);
    }

}