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

use Illuminate\Filesystem\Filesystem;

class Autoloader
{
    public function load($loader)
    {
        $directories = $this->directories();
        if (! $directories) {
            return;
        }
        array_map(function ($directory) use ($loader) {
            if (! $this->vendorAutoloadFileExists($directory)) {
                return;
            }
            $autoloadStaticPath = $this->vendor($directory, ['composer', 'autoload_static.php']);
            require_once $autoloadStaticPath;

            $autoloadClassName = $this->getAutoloadStaticClassName($autoloadStaticPath);
            $fullNamespace = '\\Composer\\Autoload\\'.$autoloadClassName;
            $class = new $fullNamespace();

            if (property_exists($class, '$prefixDirsPsr4')) {
                foreach ($fullNamespace::$prefixDirsPsr4 as $item) {
                    foreach ($item as $prefix => $path) {
                        $loader->addPsr4($prefix, $path, true);
                    }
                }
            }

            if (property_exists($class, '$fallbackDirsPsr4')) {
                foreach ($fullNamespace::$fallbackDirsPsr4 as $item) {
                    foreach ($item as $prefix => $path) {
                        $loader->addPsr4('', $path, true);
                    }
                }
            }

            if (property_exists($class, '$prefixesPsr0')) {
                foreach ($fullNamespace::$prefixesPsr0 as $item) {
                    foreach ($item as $prefix => $path) {
                        $loader->add($prefix, $path, true);
                    }
                }
            }

            property_exists($class, '$classMap') && $loader->addClassMap($fullNamespace::$classMap);

            // files
            if (property_exists($class, '$files')) {
                $includeFiles = $fullNamespace::$files;
                foreach ($includeFiles as $fileIdentifier => $file) {
                    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
                        require_once $file;
                        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;
                    }
                }
            }
        }, $directories);
    }

    public function directories()
    {
        return (new Filesystem())->directories(base_path('addons'));
    }

    /**
     * @param $addonsPath
     *
     * @return mixed
     */
    protected function vendorAutoloadFileExists($addonsPath)
    {
        $path = $this->vendor($addonsPath, ['autoload.php']);

        return (new Filesystem())->exists($path);
    }

    /**
     * @param $addonsPath
     *
     * @return string
     */
    protected function vendor($addonsPath, $file = [])
    {
        return $addonsPath.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $file);
    }

    /**
     * @param $path
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function getAutoloadStaticClassName($path)
    {
        $content = (new Filesystem())->get($path);
        preg_match_all('/ComposerStaticInit.*/', $content, $name);
        if (! isset($name[0][0])) {
            throw new \Exception('autoload static file name parse failed.');
        }
        // TODO 缓存
        return $name[0][0];
    }

    /**
     * @param $a1
     * @param $a2
     *
     * @return mixed
     */
    protected function merge($a1, $a2)
    {
        foreach ($a2 as $key => $item) {
            if (isset($a1[$key])) {
                // 存在，那就merge
                $a1[$key] = array_merge($a1[$key], $item);
            } else {
                // 不存在，就创建
                $a1[$key] = $item;
            }
        }

        return $a1;
    }

    /**
     * @param $a1
     * @param $a2
     *
     * @return mixed
     */
    protected function mergeDeep($a1, $a2)
    {
        foreach ($a2 as $key => $item) {
            if (! isset($a1[$key])) {
                $a1[$key] = $item;
                continue;
            }
            foreach ($item as $keyChildren => $itemChildren) {
                if (isset($a1[$key][$keyChildren])) {
                    // 直接合并
                    $a1[$key][$keyChildren] = array_merge($a1[$key][$keyChildren], $itemChildren);
                } else {
                    $a1[$key][$keyChildren] = $itemChildren;
                }
            }
        }

        return $a1;
    }
}
