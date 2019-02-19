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
    protected $config = [];

    public function __construct()
    {
        $this->config = config('generator');
    }

    public function render()
    {
        foreach ($this->config as $item) {
            $this->run($item);
        }
    }

    public function run($config)
    {
        echo "生成Request\n";
        $this->request($config);

        echo "生成Controller\n";
        $this->controller($config);

        echo "生成create\n";
        $this->create($config);

        echo "生成edit\n";
        $this->edit($config);

        echo "生成index\n";
        $this->index($config);

        echo "生成router\n";
        $this->router($config);
    }

    public function request($config)
    {
        $viewPath = app_path('Meedu/AutoTool/template/request.template');
        $viewContent = file_get_contents($viewPath);

        $request = $config['model'].'Request';
        $viewContent = str_replace('{request}', $request, $viewContent);

        $rules = [];
        foreach ($config['request']['rules'] as $key => $rule) {
            $rules[] = "'{$key}' => '{$rule}'";
        }
        $viewContent = str_replace('{rules}', implode(",\n", $rules), $viewContent);

        $messages = [];
        foreach ($config['request']['messages'] as $key => $rule) {
            $messages[] = "'{$key}' => '{$rule}'";
        }
        $viewContent = str_replace('{messages}', implode(",\n", $messages), $viewContent);

        $filldata = [];
        foreach ($config['request']['filldata'] as $rule) {
            $filldata[] = "'{$rule}' => \$this->input('{$rule}')";
        }
        $viewContent = str_replace('{filldata}', implode(",\n", $filldata), $viewContent);

        $dist = app_path('Http/Requests/Backend/'.$request.'.php');
        ! file_exists($dist) && file_put_contents($dist, $viewContent);

        echo "request生成完成\n";
    }

    public function controller($config)
    {
        $viewPath = app_path('Meedu/AutoTool/template/controller.template');
        $viewContent = file_get_contents($viewPath);

        $controller = $config['model'].'Controller';
        $viewContent = str_replace('{{$controllerName}}', $controller, $viewContent);
        $viewContent = str_replace('{{$model}}', $config['model'], $viewContent);
        $viewContent = str_replace('{{$request}}', $config['model'].'Request', $viewContent);
        $viewContent = str_replace('{{$name}}', strtolower($config['model']), $viewContent);

        $dist = app_path('Http/Controllers/Backend/'.$controller.'.php');
        ! file_exists($dist) && file_put_contents($dist, $viewContent);

        echo "controller生成完成\n";
    }

    public function router($config)
    {
        $viewPath = app_path('Meedu/AutoTool/template/router.template');
        $viewContent = file_get_contents($viewPath);

        $viewContent = str_replace('{{$model}}', $config['model'], $viewContent);
        $viewContent = str_replace('{{$name}}', strtolower($config['model']), $viewContent);

        echo $viewContent;
    }

    public function create($config)
    {
        $viewPath = app_path('Meedu/AutoTool/template/create.template');
        $viewContent = file_get_contents($viewPath);

        $viewContent = str_replace('{name}', $config['name'], $viewContent);
        $viewContent = str_replace('{app}', strtolower($config['model']), $viewContent);

        $form = [];
        foreach ($config['template']['edit']['fields'] as $field => $name) {
            $template = <<<EOF
<div class="form-group">
    <label>{$name}</label>
    <input type="text" name="{$field}" class="form-control" placeholder="{$name}">
</div>
EOF;
            $form[] = $template;
        }
        $viewContent = str_replace('{form}', implode("\n", $form), $viewContent);

        $distPath = resource_path('views/backend/'.strtolower($config['model']));
        if (! is_dir($distPath)) {
            mkdir($distPath, 0777, true);
        }
        $dist = $distPath.'/create.blade.php';
        ! file_exists($dist) && file_put_contents($dist, $viewContent);

        echo "create生成完成\n";
    }

    public function edit($config)
    {
        $viewPath = app_path('Meedu/AutoTool/template/edit.template');
        $viewContent = file_get_contents($viewPath);

        $viewContent = str_replace('{name}', $config['name'], $viewContent);
        $viewContent = str_replace('{app}', strtolower($config['model']), $viewContent);

        $form = [];
        foreach ($config['template']['edit']['fields'] as $field => $name) {
            $template = <<<EOF
<div class="form-group">
    <label>{$name}</label>
    <input type="text" name="{$field}" value="{{\$one->$field}}" class="form-control" placeholder="{$name}">
</div>
EOF;
            $form[] = $template;
        }
        $viewContent = str_replace('{form}', implode("\n", $form), $viewContent);

        $distPath = resource_path('views/backend/'.strtolower($config['model']));
        if (! is_dir($distPath)) {
            mkdir($distPath, 0777, true);
        }
        $dist = $distPath.'/edit.blade.php';
        ! file_exists($dist) && file_put_contents($dist, $viewContent);

        echo "edit生成完成\n";
    }

    public function index($config)
    {
        $viewPath = app_path('Meedu/AutoTool/template/index.template');
        $viewContent = file_get_contents($viewPath);

        $viewContent = str_replace('{name}', $config['name'], $viewContent);
        $viewContent = str_replace('{app}', strtolower($config['model']), $viewContent);

        $fields = $config['template']['index']['fields'];
        $viewContent = str_replace('{columnNum}', count($fields) + 2, $viewContent);

        $header = [];
        $table = [];
        foreach ($fields as $field => $name) {
            $header[] = "<th>{$name}</th>";
            $table[] = "<td>{{\$row->$field}}</td>";
        }

        $viewContent = str_replace('{header}', implode("\n", $header), $viewContent);
        $viewContent = str_replace('{table}', implode("\n", $table), $viewContent);

        $distPath = resource_path('views/backend/'.strtolower($config['model']));
        if (! is_dir($distPath)) {
            mkdir($distPath, 0777, true);
        }
        $dist = $distPath.'/index.blade.php';
        ! file_exists($dist) && file_put_contents($dist, $viewContent);

        echo "index生成完成\n";
    }
}
