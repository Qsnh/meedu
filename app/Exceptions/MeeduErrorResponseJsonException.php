<?php

namespace App\Exceptions;

use Exception;

class MeeduErrorResponseJsonException extends Exception
{

    public function render()
    {
        return [
            'code' => $this->getCode() ?: 500,
            'message' => $this->getMessage(),
        ];
    }

}
