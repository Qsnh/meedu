<?php


namespace App\Exceptions;


class SystemException extends \Exception
{

    public function render()
    {
        abort(500, $this->getMessage());
    }

}