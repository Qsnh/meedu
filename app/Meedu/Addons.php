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
use GuzzleHttp\Client;
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

    protected $client;

    /**
     * ServiceProvider MapFile.
     */
    protected $mappingFile;

    public function __construct(bool $forceDelete = false)
    {
        $this->linkDist = base_path('addons');
        $this->realDist = storage_path('app/addons');
        $this->files = new Filesystem();
        $this->forceDelete = $forceDelete;
        $this->client = new Client([
            'verify' => false,
            'timeout' => 5.0,
        ]);
        $this->mappingFile = base_path('/addons/addons_service_provider.json');
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
            ['.git', 'node_modules', 'vendor'],
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
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function serviceProviderLoad(Application $app): void
    {
        if (! file_exists($this->mappingFile)) {
            return;
        }
        $arr = json_decode($this->files->get($this->mappingFile), true);
        if (! $arr) {
            return;
        }
        foreach ($arr as $item) {
            if (file_exists($item['path'])) {
                require_once $item['path'];
                $app->register($item['class']);
            }
        }
    }

    /**
     * 获取ServiceProvider.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getServiceProvider(string $path)
    {
        return glob($path.DIRECTORY_SEPARATOR.'*ServiceProvider.php');
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

    /**
     * 提交插件依赖安装.
     *
     * @param string $addonsName
     * @param string $action
     * @param array  $dep
     *
     * @return bool
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function submitDepAction(string $addonsName, string $action, array $dep)
    {
        $pkgs = [];
        foreach ($dep as $pkgName => $pkgVersion) {
            $pkgs[] = $pkgName.'='.$pkgVersion;
        }
        $params = [
            'php' => config('meedu.addons.api_php_path'),
            'composer' => base_path('composer.phar'),
            'action' => $action,
            'pkg' => implode('|', $pkgs),
            'dir' => base_path(),
            'key' => config('meedu.addons.api_key'),
            'addons' => $addonsName,
            'notify' => route('backend.addons.callback'),
        ];
        try {
            $response = $this->client->get(config('meedu.addons.api').'?'.http_build_query($params));
            if ($response->getStatusCode() != 200) {
                return false;
            }

            return true;
        } catch (Exception $exception) {
            exception_record($exception);

            return false;
        }
    }

    /**
     * @param string $addonsName
     * @param array  $dep
     *
     * @return bool
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function depRequire(string $addonsName, array $dep)
    {
        return $this->submitDepAction($addonsName, 'require', $dep);
    }

    /**
     * @param string $addonsName
     * @param array  $dep
     *
     * @return bool
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function depRemove(string $addonsName, array $dep)
    {
        return $this->submitDepAction($addonsName, 'remove', $dep);
    }

    /**
     * 服务加载Map.
     *
     * @param array $paths
     */
    public function generateServiceProviderMapping(array $paths)
    {
        $rows = [];
        foreach ($paths as $item) {
            $serviceProviders = $this->getServiceProvider($item);
            if ($serviceProviders) {
                $dir = pathinfo($item, PATHINFO_BASENAME);
                foreach ($serviceProviders as $serviceProvider) {
                    $rows[] = [
                        'path' => $serviceProvider,
                        'class' => sprintf('\\Addons\\%s\\%s', $dir, pathinfo($serviceProvider, PATHINFO_FILENAME)),
                    ];
                }
            }
        }
        $this->files->put($this->mappingFile, json_encode($rows));
    }
}
