<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend;

use App\Models\Template;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::all();
        $currentTemplate = config('meedu.system.theme.use');

        return view('backend.template.index', compact('templates', 'currentTemplate'));
    }

    public function remoteTemplates()
    {
    }

    /**
     * 本地安装.
     *
     * @param $templateName
     * @param $version
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function installLocal($templateName, $version)
    {
        $templateFilePath = storage_path("app/templates/{$templateName}.zip");
        if (! file_exists($templateFilePath)) {
            flash('文件不存在');

            return back();
        }
        if (Template::whereName($templateName)->whereCurrentVersion($version)->exists()) {
            flash('该模板已经安装');

            return redirect(route('backend.template.index'));
        }

        DB::beginTransaction();
        try {
            // 创建目录
            $savePath = storage_path("app/templates/{$templateName}/{$version}");
            if (! file_exists($savePath)) {
                // 创建目录
                app()->make('files')->makeDirectory($savePath, 0755, true);
            }

            // 解压文件
            \Chumper\Zipper\Facades\Zipper::make($templateFilePath)->extractTo($savePath);

            // 创建软链接
            $path = base_path("templates/{$templateName}");
            if (app()->make('files')->exists(public_path('storage'))) {
                app()->make('files')->deleteDirectory($path);
            }
            app()->make('files')->link($savePath, $path);

            // 创建数据库记录
            Template::create([
                'name' => $templateName,
                'current_version' => $version,
                'path' => $path,
                'real_path' => $savePath,
                'author' => '第三方渠道',
                'thumb' => '',
            ]);

            DB::commit();

            flash('安装成功', 'success');

            return redirect(route('backend.template.index'));
        } catch (\Exception $exception) {
            DB::rollBack();
            exception_record($exception);
            flash('安装出现错误，错误信息：'.$exception->getMessage());

            return back();
        }
    }

    /**
     * 更换系统模板
     *
     * @param $templateId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setDefaultHandler($templateId)
    {
        $template = Template::findOrFail($templateId);
        if ($template->path == '' || $template->real_path == '') {
            flash('该模板数据不完整');

            return back();
        }

        if (! is_dir($template->path) || ! is_dir($template->real_path)) {
            flash('该模板文件不存在');

            return back();
        }

        $configFileJson = json_decode(file_get_contents(config('meedu.save')), true);
        $configFileJson['meedu.system.theme.use'] = $template->name;
        $configFileJson['meedu.system.theme.path'] = $template->path;
        file_put_contents(config('meedu.save'), json_encode($configFileJson));

        flash('模板更换成功', 'success');

        return back();
    }
}
