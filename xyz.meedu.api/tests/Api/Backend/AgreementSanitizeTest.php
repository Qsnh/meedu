<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Api\Backend;

use App\Constant\AgreementConstant;
use App\Http\Requests\Backend\AgreementRequest;
use Tests\TestCase;

class AgreementSanitizeTest extends TestCase
{
    public function test_filldata_strips_script_tag()
    {
        $request = new AgreementRequest();
        $request->merge([
            'type' => array_key_first(AgreementConstant::TYPES),
            'title' => '服务协议',
            'content' => '<p>正文</p><script>alert(1)</script>',
            'version' => 'v1',
            'is_active' => 0,
        ]);

        $data = $request->filldata();

        $this->assertStringNotContainsString('<script', $data['content']);
        $this->assertStringNotContainsString('alert(1)', $data['content']);
        $this->assertStringContainsString('<p>正文</p>', $data['content']);
    }

    public function test_filldata_strips_javascript_href()
    {
        $request = new AgreementRequest();
        $request->merge([
            'type' => array_key_first(AgreementConstant::TYPES),
            'title' => '服务协议',
            'content' => '<a href="javascript:alert(1)">点击</a>',
            'version' => 'v1',
            'is_active' => 0,
        ]);

        $data = $request->filldata();

        $this->assertStringNotContainsString('javascript:', $data['content']);
    }

    public function test_filldata_preserves_safe_rich_text()
    {
        $request = new AgreementRequest();
        $request->merge([
            'type' => array_key_first(AgreementConstant::TYPES),
            'title' => '服务协议',
            'content' => '<p><strong>加粗</strong><em>斜体</em></p><ul><li>条目</li></ul>',
            'version' => 'v1',
            'is_active' => 0,
        ]);

        $data = $request->filldata();

        $this->assertStringContainsString('<strong>加粗</strong>', $data['content']);
        $this->assertStringContainsString('<em>斜体</em>', $data['content']);
        $this->assertStringContainsString('<li>条目</li>', $data['content']);
    }
}
