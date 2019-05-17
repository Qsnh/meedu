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

use Illuminate\Contracts\Foundation\Application;

class AddonsProvider
{
    /**
     * @param Application $app
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function bootstrap(Application $app)
    {
        $meeduAddons = new Addons();
        $providers = $meeduAddons->getProvidersMap();
        if ($providers) {
            array_map(function ($provider) use ($app) {
                $app->register($provider);
            }, $providers);
        }
    }
}
