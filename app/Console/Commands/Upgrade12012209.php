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

class Upgrade12012209 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade12012209';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '12.01 22.09分的升级';

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
            $permissions = [
                [
                    'display_name' => '推广链接首页',
                    'slug' => 'backend.adfrom.index',
                    'method' => 'GET',
                    'url' => '/backend/adfrom',
                    'description' => '',
                ],
                [
                    'display_name' => '创建推广链接界面',
                    'slug' => 'backend.adfrom.create',
                    'method' => 'GET',
                    'url' => '/backend/adfrom/create',
                    'description' => '',
                ],
                [
                    'display_name' => '创建推广链接',
                    'slug' => 'backend.adfrom.create',
                    'method' => 'POST',
                    'url' => '/backend/adfrom/create',
                    'description' => '',
                ],
                [
                    'display_name' => '编辑推广链接界面',
                    'slug' => 'backend.adfrom.edit',
                    'method' => 'GET',
                    'url' => '/backend/adfrom/\d+/edit',
                    'description' => '',
                ],
                [
                    'display_name' => '保存推广链接的变动',
                    'slug' => 'backend.adfrom.edit',
                    'method' => 'PUT',
                    'url' => '/backend/adfrom/\d+/edit',
                    'description' => '',
                ],
                [
                    'display_name' => '删除推广链接',
                    'slug' => 'backend.adfrom.destroy',
                    'method' => 'GET',
                    'url' => '/backend/adfrom/\d+/delete',
                    'description' => '',
                ],
                [
                    'display_name' => '查看推广链接推广效果',
                    'slug' => 'backend.adfrom.number',
                    'method' => 'GET',
                    'url' => '/backend/adfrom/\d+/number',
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
                'name' => '推广链接',
                'url' => '/backend/adfrom',
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
