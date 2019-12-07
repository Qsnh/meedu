<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Http\Request;
use App\Models\AdministratorMenu;
use App\Models\AdministratorPermission;
use App\Http\Requests\Backend\AdministratorMenuRequest;

class AdministratorMenuController extends BaseController
{
    public function index(AdministratorMenu $administratorMenu)
    {
        $menus = $administratorMenu->menus();
        $permissions = AdministratorPermission::get();

        return $this->successData(compact('menus', 'permissions'));
    }

    public function store(AdministratorMenuRequest $request)
    {
        AdministratorMenu::create($request->filldata());

        return $this->success();
    }

    public function edit(AdministratorMenu $administratorMenu, $id)
    {
        $permissions = AdministratorPermission::get();
        $menus = $administratorMenu->menus();
        $menu = AdministratorMenu::findOrFail($id);

        return $this->successData(compact('menus', 'menu', 'permissions'));
    }

    public function update(AdministratorMenuRequest $request, $id)
    {
        $menu = AdministratorMenu::findOrFail($id);
        $menu->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy($id)
    {
        $menu = AdministratorMenu::findOrFail($id);
        AdministratorMenu::whereParentId($menu->id)->update(['parent_id' => 0]);
        $menu->delete();

        return $this->success();
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

        return $this->success();
    }
}
