<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\AutoTool;

class Generator
{
    protected $name;
    protected $controller;
    protected $model;
    protected $request;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    public function genController()
    {
        $stub = file_get_contents(base_path('./app/Meedu/AutoTool/stubs/controller.stub'));
        $stub = str_replace('|request|', $this->request, $stub);
        $stub = str_replace('|controller|', $this->controller, $stub);
        $stub = str_replace('|model|', $this->model, $stub);
        file_put_contents(base_path('app/Http/Controllers/Backend/Api/V1/'.$this->controller.'.php'), $stub);
    }

    public function genRoute()
    {
        $stub = file_get_contents(base_path('./app/Meedu/AutoTool/stubs/route.stub'));
        $stub = str_replace('|controller|', $this->controller, $stub);
        $stub = str_replace('|name|', $this->name, $stub);
        echo $stub;
    }
}
