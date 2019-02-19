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

use Illuminate\Http\Request;
use App\Models\AdministratorMenu;
use App\Http\Controllers\Controller;
use App\Models\AdministratorPermission;
use App\Http\Requests\Backend\AdministratorMenuRequest;

class AdministratorMenuController extends Controller
{
    public function index(AdministratorMenu $administratorMenu)
    {
        $menus = $administratorMenu->menus();
        $permissions = AdministratorPermission::get();

        return view('backend.administrator_menu.index', compact('menus', 'permissions'));
    }

    public function store(AdministratorMenuRequest $request)
    {
        AdministratorMenu::create($request->filldata());
        flash('创建成功', 'success');

        return back();
    }

    public function edit(AdministratorMenu $administratorMenu, $id)
    {
        $permissions = AdministratorPermission::get();
        $menus = $administratorMenu->menus();
        $menu = AdministratorMenu::findOrFail($id);

        return view('backend.administrator_menu.edit', compact('menus', 'menu', 'permissions'));
    }

    public function update(AdministratorMenuRequest $request, $id)
    {
        $menu = AdministratorMenu::findOrFail($id);
        $menu->fill($request->filldata())->save();
        flash('编辑成功', 'success');

        return back();
    }

    public function destroy($id)
    {
        $menu = AdministratorMenu::findOrFail($id);
        AdministratorMenu::whereParentId($menu->id)->update(['parent_id' => 0]);
        $menu->delete();
        flash('删除成功', 'success');

        return back();
    }

    public function saveChange(Request $request)
    {
        $data = json_decode($request->post('data'), true);
        foreach ($data as $index => $item) {
            $node = AdministratorMenu::findOrFail($item['id']);
            $node->fill(['order' => $index, 'parent_id' => 0])->save();
            if (isset($item['children'])) {
                foreach ($item['children'] as $childIndex => $child) {
                    $nodeChild = AdministratorMenu::findOrFail($child['id']);
                    $nodeChild->fill(['order' => $childIndex, 'parent_id' => $node->id])->save();
                }
            }
        }
        flash('保存成功', 'success');

        return back();
    }
}
