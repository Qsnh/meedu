<?php

namespace App\Exceptions;

use Exception;

class MeeduErrorResponseJsonException extends Exception
{

    public function render()
    {
        return exception_response($this);
    }

}
