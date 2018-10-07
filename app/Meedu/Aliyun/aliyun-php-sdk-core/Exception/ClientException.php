<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

class ClientException extends Exception
{
    public function __construct($errorMessage, $errorCode)
    {
        parent::__construct($errorMessage);
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
        $this->setErrorType('Client');
    }

    private $errorCode;
    private $errorMessage;
    private $errorType;

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function getErrorType()
    {
        return $this->errorType;
    }

    public function setErrorType($errorType)
    {
        $this->errorType = $errorType;
    }
}
