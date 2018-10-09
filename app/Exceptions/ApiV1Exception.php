<?php

namespace App\Exceptions;

use Exception;

class ApiV1Exception extends Exception
{

    public function render()
    {
        return exception_response($this);
    }

}
