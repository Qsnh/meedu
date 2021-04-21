<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Services\Base\Services;

use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Base\Interfaces\RenderServiceInterface;

class RenderService implements RenderServiceInterface
{
    private $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @param $content
     *
     * @return mixed
     */
    public function render(string $content): string
    {
        $render = ucfirst($this->configService->getEditor());
        $method = 'render'.$render;

        return $this->$method($content);
    }

    protected function renderMarkdown(string $content): string
    {
        $content = markdown_to_html($content);

        return $this->renderHtml($content);
    }

    protected function renderHtml(string $content): string
    {
        return clean($content);
    }
}
