<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserVerifyFaceSuccessEvent
{
    use Dispatchable, SerializesModels;

    public $userId;
    public $verifyImageUrl;
    public $verifyVideoUrl;

    public $datetime;

    public $name;
    public $idNumber;


    public function __construct(int $userId, string $name, string $idNumber, string $verifyImageUrl, string $verifyVideoUrl, string $datetime)
    {
        $this->userId = $userId;
        $this->verifyImageUrl = $verifyImageUrl;
        $this->verifyVideoUrl = $verifyVideoUrl;
        $this->datetime = $datetime;
        $this->name = $name;
        $this->idNumber = $idNumber;
    }
}
