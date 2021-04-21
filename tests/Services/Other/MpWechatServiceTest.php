<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace Tests\Services\Other;

use Tests\TestCase;
use App\Services\Other\Services\MpWechatService;
use App\Services\Other\Models\MpWechatMessageReply;

class MpWechatServiceTest extends TestCase
{

    /**
     * @var MpWechatService
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(MpWechatService::class);
    }

    public function test_textMessageReplyFind()
    {
        MpWechatMessageReply::create([
            'type' => MpWechatMessageReply::TYPE_TEXT,
            'rule' => 'hello',
            'reply_content' => '你好',
        ]);

        $content = $this->service->textMessageReplyFind('hello');
        $this->assertEquals('你好', $content);

        // 支持正则
        $content = $this->service->textMessageReplyFind('hello1');
        $this->assertEquals('你好', $content);

        $content = $this->service->textMessageReplyFind('world');
        $this->assertEquals('', $content);
    }

    public function test_eventMessageReplyFind()
    {
        MpWechatMessageReply::create([
            'type' => MpWechatMessageReply::TYPE_EVENT,
            'event_type' => 'subscribe',
            'event_key' => '',
            'rule' => '',
            'reply_content' => '欢迎关注',
        ]);

        $content = $this->service->eventMessageReplyFind('subscribe');
        $this->assertEquals('欢迎关注', $content);
    }

    public function test_eventMessageReplyFind_with_repeat()
    {
        // 重复的创建会读取第一条数据

        MpWechatMessageReply::create([
            'type' => MpWechatMessageReply::TYPE_EVENT,
            'event_type' => 'subscribe',
            'event_key' => '',
            'rule' => '',
            'reply_content' => '欢迎关注1',
        ]);
        MpWechatMessageReply::create([
            'type' => MpWechatMessageReply::TYPE_EVENT,
            'event_type' => 'subscribe',
            'event_key' => '',
            'rule' => '',
            'reply_content' => '欢迎关注2',
        ]);

        $content = $this->service->eventMessageReplyFind('subscribe');
        $this->assertEquals('欢迎关注2', $content);
    }

    public function test_eventMessageReplyFind_with_eventKey()
    {
        MpWechatMessageReply::create([
            'type' => MpWechatMessageReply::TYPE_EVENT,
            'event_type' => 'subscribe',
            'event_key' => '',
            'rule' => '',
            'reply_content' => '欢迎关注1',
        ]);
        MpWechatMessageReply::create([
            'type' => MpWechatMessageReply::TYPE_EVENT,
            'event_type' => 'subscribe',
            'event_key' => 'qrcode',
            'rule' => '',
            'reply_content' => '欢迎关注2',
        ]);

        $content = $this->service->eventMessageReplyFind('subscribe', 'qrcode_1');
        $this->assertEquals('欢迎关注2', $content);
    }
}
