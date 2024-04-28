<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Other\Interfaces;

interface MpWechatServiceInterface
{

    public function textMessageReplyFind(string $text): string;

    public function eventMessageReplyFind(string $event, $eventKey = ''): string;
}
