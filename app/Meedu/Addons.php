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
     * @param string $path
     * @param string $name
     * @param string $version
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function install(string $path, string $name, string $version): array
    {
        $extractPath = $this->extract($name, $version, $path);
        // 创建软连接
        $linkPath = $this->linkDist.DIRECTORY_SEPARATOR.$name;
        $this->files->exists($linkPath) && $this->files->deleteDirectory($linkPath);
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
        $this->files->deleteDirectory($this->link($name, $version));
        $this->forceDelete && $this->files->deleteDirectories($this->extract($name, $version));
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
     * @param string $versionPath
     *
     * @return string
     *
     * @throws Exception
     */
    public function switchVersion(string $name, string $version, string $versionPath = ''): string
    {
        if (! $this->files->exists($versionPath)) {
            throw new Exception(sprintf('文件[%s]不存在', $versionPath));
        }
        $linkPath = $this->link($name, $version, $versionPath);

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
        \Chumper\Zipper\Facades\Zipper::make($file)->extractTo($extractPath, ['vendor', '.git'], Zipper::BLACKLIST);

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
     * @param string $name
     * @param string $version
     *
     * @return array
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function parseDependencies(string $name, string $version): array
    {
        $dist = $this->linkDist.DIRECTORY_SEPARATOR.$name.DIRECTORY_SEPARATOR.'composer.json';
        if (! $this->files->exists($dist)) {
            return [];
        }
        $composerFileContent = json_decode($this->files->get($dist), true);
        $dependencies = $composerFileContent['require'] ?? [];
        if (! $dependencies) {
            return [];
        }

        return $dependencies;
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
}
