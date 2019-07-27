<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

class ServerException extends ClientException
{
    private $httpStatus;
    private $requestId;

    public function __construct($errorMessage, $errorCode, $httpStatus, $requestId)
    {
        $messageStr = $errorCode.' '.$errorMessage.' HTTP Status: '.$httpStatus.' RequestID: '.$requestId;
        parent::__construct($messageStr, $errorCode);
        $this->setErrorMessage($errorMessage);
        $this->setErrorType('Server');
        $this->httpStatus = $httpStatus;
        $this->requestId = $requestId;
    }

    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    public function getRequestId()
    {
        return $this->requestId;
    }
}
