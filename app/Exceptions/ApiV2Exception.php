<?php


namespace App\Exceptions;

use App\Http\Controllers\Api\V2\Traits\ResponseTrait;

class ApiV2Exception extends \Exception
{
    use ResponseTrait;

    public function render()
    {
        return $this->error($this->getMessage());
    }

}