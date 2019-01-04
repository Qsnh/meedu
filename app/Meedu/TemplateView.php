<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu;

use Exception;
use Illuminate\Filesystem\Filesystem;

class TemplateView
{
    protected $linkDist;
    protected $realDist;
    protected $assetsDirectoryName = 'public';
    protected $forceDelete;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * TemplateView constructor.
     *
     * @param bool $forceDelete
     */
    public function __construct(bool $forceDelete = false)
    {
        $this->linkDist = base_path('templates');
        $this->realDist = storage_path('app/templates');
        $this->files = new Filesystem();
        $this->forceDelete = $forceDelete;
    }

    /**
     * @param string $sourceFile
     * @param string $name
     * @param string $version
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function install(string $sourceFile, string $name, string $version): array
    {
        $extractPath = $this->extract($name, $version, $sourceFile);
        // 创建软连接
        $linkPath = $this->linkDist.DIRECTORY_SEPARATOR.$name;
        $this->files->exists($linkPath) && $this->files->deleteDirectory($linkPath);
        $this->files->link($extractPath, $linkPath);

        return [$extractPath, $linkPath];
    }

    /**
     * 卸载模板[删除软链接].
     *
     * @param string $name
     * @param string $version
     */
    public function uninstall(string $name, string $version): void
    {
        $this->files->deleteDirectory($this->link($name, $version));
        $this->forceDelete && $this->files->deleteDirectories($this->extract($name, $version));
    }

    /**
     * 模板升级.
     *
     * @param string $name
     * @param string $newVersion
     * @param string $oldVersion
     * @param string $newVersionFile
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function upgrade(string $name, string $newVersion, string $oldVersion, string $newVersionFile): array
    {
        $extractPath = $this->extract($name, $newVersion, $newVersionFile);
        $linkPath = $this->link($name, $newVersion);

        return [$extractPath, $linkPath];
    }

    /**
     * 解压文件.
     *
     * @param string $name
     * @param string $version
     * @param string $file
     *
     * @return string
     *
     * @throws \Throwable
     */
    protected function extract(string $name, string $version, string $file): string
    {
        if (! $this->files->exists($file)) {
            throw new Exception(sprintf('文件[%s]不存在', $file));
        }
        $extractPath = $this->extractPath($name, $version);
        if (! $this->files->exists($extractPath)) {
            $this->files->makeDirectory($extractPath, 0755, true);
        }
        \Chumper\Zipper\Facades\Zipper::make($version)->extractTo($extractPath);

        return $extractPath;
    }

    /**
     * @param string $name
     * @param string $version
     * @param string $distPath
     *
     * @return string
     */
    protected function link(string $name, string $version, string $distPath = ''): string
    {
        $extractPath = $this->extractPath($name, $version);
        $linkPath = $distPath ?: $this->linkPath($name, $version);
        $this->files->exists($linkPath) && $this->files->deleteDirectory($linkPath);
        $this->files->link($extractPath, $linkPath);

        return $linkPath;
    }

    /**
     * 解压存储路径.
     *
     * @param string $name
     * @param string $version
     *
     * @return string
     */
    protected function extractPath(string $name, string $version): string
    {
        $extractPath = $this->realDist.DIRECTORY_SEPARATOR.$name.DIRECTORY_SEPARATOR.$version;

        return $extractPath;
    }

    /**
     * 软链接路径.
     *
     * @param string $name
     * @param string $version
     *
     * @return string
     */
    protected function linkPath(string $name, string $version): string
    {
        $linkPath = $this->linkDist.DIRECTORY_SEPARATOR.$name;

        return $linkPath;
    }
}
