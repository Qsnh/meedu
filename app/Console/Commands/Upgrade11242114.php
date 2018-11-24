<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdministratorMenu;
use Illuminate\Support\Facades\DB;
use App\Models\AdministratorPermission;

class Upgrade11242114 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade:11242114';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'upgrade';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            // 友情链接权限
            $permissions = [
                [
                    'display_name' => '友情链接列表',
                    'slug' => 'backend.link.index',
                    'method' => 'GET',
                    'url' => '/backend/link',
                    'description' => '',
                ],
                [
                    'display_name' => '创建友情链接界面',
                    'slug' => 'backend.link.create',
                    'method' => 'GET',
                    'url' => '/backend/link/create',
                    'description' => '',
                ],
                [
                    'display_name' => '创建友情链接',
                    'slug' => 'backend.link.create',
                    'method' => 'POST',
                    'url' => '/backend/link/create',
                    'description' => '',
                ],
                [
                    'display_name' => '编辑友情链接界面',
                    'slug' => 'backend.link.edit',
                    'method' => 'GET',
                    'url' => '/backend/link/\d+/edit',
                    'description' => '',
                ],
                [
                    'display_name' => '保存友情链接的变动',
                    'slug' => 'backend.link.edit',
                    'method' => 'PUT',
                    'url' => '/backend/link/\d+/edit',
                    'description' => '',
                ],
                [
                    'display_name' => '删除友情链接',
                    'slug' => 'backend.link.destroy',
                    'method' => 'GET',
                    'url' => '/backend/link/\d+/delete',
                    'description' => '',
                ],
            ];

            $permissionId = 0;
            foreach ($permissions as $index => $permission) {
                $p = AdministratorPermission::create($permission);
                $index == 0 && $permissionId = $p->id;
            }

            // 后台菜单
            $data = [
                'name' => '友情链接',
                'url' => '/backend/link',
            ];
            $parent = AdministratorMenu::whereName('运营')->first();
            if (! $parent) {
                return;
            }
            $data['parent_id'] = $parent->id;
            $data['permission_id'] = $permissionId;
            AdministratorMenu::create($data);

            DB::commit();

            $this->info('upgrade success');
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->warn('upgrade error.message:'.$exception->getMessage());
        }
    }
}
