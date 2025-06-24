<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Exceptions;

use App\Http\Controllers\Api\V2\Traits\ResponseTrait;

class InterruptionException extends \Exception
{

    use ResponseTrait;

    private $respCode;
    private $respDATA;
    private $respMessage;

    public function __construct(array $data = [], int $code = 0, string $message = '')
    {
        parent::__construct();
        $this->respCode = $code;
        $this->respDATA = $data;
        $this->respMessage = $message;
    }

    public function render()
    {
        if (0 === $this->respCode) {
            return $this->data($this->respDATA, 0, $this->respMessage);
        }

        return $this->error($this->respMessage, $this->respCode, $this->respDATA);
    }

}
