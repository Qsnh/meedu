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
use Chumper\Zipper\Zipper;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

class Addons
{
    protected $linkDist;

    protected $realDist;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var bool
     */
    protected $forceDelete;

    public function __construct(bool $forceDelete = false)
    {
        $this->linkDist = base_path('addons');
        $this->realDist = storage_path('app/addons');
        $this->files = new Filesystem();
        $this->forceDelete = $forceDelete;
    }

    /**
     * @param string $compressFilePath
     * @param string $name
     * @param string $version
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function install(string $compressFilePath, string $name, string $version): array
    {
        $extractPath = $this->extract($name, $version, $compressFilePath);
        // 创建软连接
        $linkPath = $this->linkPath($name, $version);
        $this->files->exists($linkPath) && $this->deleteLink($linkPath);
        $this->files->link($extractPath, $linkPath);

        return [$extractPath, $linkPath];
    }

    /**
     * 卸载插件[删除软链接].
     *
     * @param string $name
     * @param string $version
     *
     * @throws \Throwable
     */
    public function uninstall(string $name, string $version): void
    {
        $this->deleteLink($this->linkPath($name, $version));
        $this->forceDelete && $this->files->deleteDirectories($this->extractPath($name, $version));
    }

    /**
     * 插件升级.
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
     * 切换版本.
     *
     * @param string $name
     * @param string $version
     *
     * @return string
     *
     * @throws Exception
     */
    public function switchVersion(string $name, string $version): string
    {
        $linkPath = $this->link($name, $version);

        return $linkPath;
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
        \Chumper\Zipper\Facades\Zipper::make($file)->extractTo(
            $extractPath,
            ['vendor', '.git', 'node_modules'],
            Zipper::BLACKLIST
        );

        return $extractPath;
    }

    /**
     * @param string $name
     * @param string $version
     *
     * @return string
     */
    protected function link(string $name, string $version): string
    {
        // 真实的解压目录
        $extractPath = $this->extractPath($name, $version);
        // 删除已创建的软链接
        $linkPath = $this->linkPath($name, $version);
        $this->files->exists($linkPath) && $this->deleteLink($linkPath);
        // 重新创建软链接
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

    /**
     * @param $path
     *
     * @return bool
     */
    protected function deleteLink($path)
    {
        $eof = substr($path, -1, 1);
        if ($eof == '/' || $eof == '\\') {
            $path = substr($path, 0, mb_strlen($path) - 1);
        }

        if (! windows_os()) {
            return $this->files->delete($path);
        }

        exec("rmdir \"{$path}\"");
    }

    /**
     * 服务自动发现.
     *
     * @param Application $app
     */
    public function serviceProviderLoad(Application $app): void
    {
        $addons = $this->files->directories($this->linkDist);
        if ($addons) {
            array_map(function ($addons) use ($app) {
                $name = pathinfo($addons, PATHINFO_BASENAME);
                $serviceProviderFiles = glob($addons.DIRECTORY_SEPARATOR.'*ServiceProvider.php');
                if ($serviceProviderFiles) {
                    foreach ($serviceProviderFiles as $serviceProviderFile) {
                        $providerName = pathinfo($serviceProviderFile, PATHINFO_FILENAME);
                        $namespace = "\\Addons\\{$name}\\{$providerName}";
                        $app->register($namespace);
                    }
                }
            }, $addons);
        }
    }

    /**
     * 解析插件meedu配置.
     *
     * @param $path
     *
     * @return array|mixed
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function parseMeedu($path)
    {
        $file = $path.DIRECTORY_SEPARATOR.'meedu.json';
        if (! $this->files->exists($file)) {
            return [];
        }

        return json_decode($this->files->get($file), true);
    }

    /**
     * 判断插件是否已经安装.
     *
     * @param string $sign
     *
     * @return bool
     */
    public function isInstall(string $sign): bool
    {
        return $this->files->exists($this->linkDist.DIRECTORY_SEPARATOR.$sign);
    }
}
