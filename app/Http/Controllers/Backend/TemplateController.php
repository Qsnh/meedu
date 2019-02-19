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

use App\Meedu\Setting;
use App\Models\Template;
use App\Meedu\TemplateView;
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
     * @param $name
     * @param $version
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function installLocal($name, $version)
    {
        if (Template::whereName($name)->whereCurrentVersion($version)->exists()) {
            flash('该模板已经安装');

            return redirect(route('backend.template.index'));
        }

        $sourceFile = storage_path("app/templates/{$name}.zip");

        DB::beginTransaction();
        try {
            [$savePath, $path] = app()->make(TemplateView::class)->install($sourceFile, $name, $version);

            // 创建数据库记录
            Template::create([
                'name' => $name,
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

        app()->make(Setting::class)->save([
            'meedu.system.theme.use' => $template->name,
            'meedu.system.theme.path' => $template->path,
        ]);

        flash('模板更换成功', 'success');

        return back();
    }
}
