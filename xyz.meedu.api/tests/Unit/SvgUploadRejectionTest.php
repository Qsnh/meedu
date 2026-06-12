<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit;

use Tests\CreatesApplication;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ApiV2\UploadImageRequest;
use App\Http\Requests\ApiV2\AvatarChangeRequest;
use App\Http\Requests\Backend\ImageUploadRequest;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class SvgUploadRejectionTest extends BaseTestCase
{
    use CreatesApplication;

    private function validate(array $rules, UploadedFile $file): bool
    {
        return Validator::make(['file' => $file], $rules)->passes();
    }

    private function rulesOf(string $requestClass): array
    {
        return (new $requestClass())->rules();
    }

    private function fakeSvg(): UploadedFile
    {
        return UploadedFile::fake()->createWithContent(
            'xss.svg',
            '<?xml version="1.0"?><svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>'
        );
    }

    private function fakePng(): UploadedFile
    {
        return UploadedFile::fake()->image('legit.png', 100, 100);
    }

    public function test_backend_image_upload_rejects_svg()
    {
        $this->assertFalse($this->validate($this->rulesOf(ImageUploadRequest::class), $this->fakeSvg()));
    }

    public function test_backend_image_upload_accepts_png()
    {
        $this->assertTrue($this->validate($this->rulesOf(ImageUploadRequest::class), $this->fakePng()));
    }

    public function test_apiv2_upload_image_rejects_svg()
    {
        $this->assertFalse($this->validate($this->rulesOf(UploadImageRequest::class), $this->fakeSvg()));
    }

    public function test_apiv2_upload_image_accepts_png()
    {
        $this->assertTrue($this->validate($this->rulesOf(UploadImageRequest::class), $this->fakePng()));
    }

    public function test_apiv2_avatar_change_rejects_svg()
    {
        $this->assertFalse($this->validate($this->rulesOf(AvatarChangeRequest::class), $this->fakeSvg()));
    }

    public function test_apiv2_avatar_change_accepts_png()
    {
        $this->assertTrue($this->validate($this->rulesOf(AvatarChangeRequest::class), $this->fakePng()));
    }

    public function test_svg_content_with_png_extension_still_rejected_by_mimetypes()
    {
        // 攻击者将 svg 内容改名为 .png 上传：mimetypes 规则会基于 fileinfo 嗅探的真实 MIME 拦截
        // 使用真实临时文件以便 Symfony 的 MimeTypeGuesser 能正确嗅探 image/svg+xml
        $tmp = tempnam(sys_get_temp_dir(), 'svg_test_') . '.png';
        file_put_contents(
            $tmp,
            '<?xml version="1.0"?><svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>'
        );
        $file = new UploadedFile($tmp, 'fake.png', 'image/png', null, true);
        try {
            $this->assertFalse($this->validate($this->rulesOf(UploadImageRequest::class), $file));
        } finally {
            @unlink($tmp);
        }
    }
}
