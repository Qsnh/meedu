<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Events\DecorationPageUpdateEvent;
use App\Services\Other\Interfaces\DecorationPageServiceInterface;

class DecorationPageController extends BaseController
{
    protected $decorationPageService;

    public function __construct(DecorationPageServiceInterface $decorationPageService)
    {
        $this->decorationPageService = $decorationPageService;
    }

    /**
     * @api {get} /backend/api/v1/decoration-page [管理后台]装修页面-列表
     * @apiGroup 装修管理
     * @apiName DecorationPageList
     * @apiVersion v1.0.0
     *
     * @apiParam {String} page_key 页面标识（必填）
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data 数据
     */
    public function index(Request $request)
    {
        $pageKey = $request->input('page_key');
        if (!$pageKey) {
            return $this->error(__('参数错误'));
        }

        $pages = $this->decorationPageService->getPagesByPageKey($pageKey);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_VIEW,
            compact('pageKey')
        );

        return $this->successData($pages);
    }

    /**
     * @api {post} /backend/api/v1/decoration-page [管理后台]装修页面-创建
     * @apiGroup 装修管理
     * @apiName DecorationPageStore
     * @apiVersion v1.0.0
     *
     * @apiParam {String} name 页面名称
     * @apiParam {String} page_key 页面标识（必填，只能是 pc-page-index 或 h5-page-index）
     *
     * @apiSuccess {Number} code 0成功,非0失败
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $pageKey = $request->input('page_key');

        if (!$name || !$pageKey) {
            return $this->error(__('参数错误'));
        }

        // page_key 必须是 pc-page-index 或 h5-page-index
        if (!in_array($pageKey, ['pc-page-index', 'h5-page-index'])) {
            return $this->error(__('page_key 参数错误'));
        }

        $data = [
            'name' => $name,
            'page_key' => $pageKey,
            'is_default' => 0,
        ];

        $id = $this->decorationPageService->createPage($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_STORE,
            $data
        );

        event(new DecorationPageUpdateEvent($pageKey));

        return $this->successData(['id' => $id]);
    }

    /**
     * @api {put} /backend/api/v1/decoration-page/{id} [管理后台]装修页面-更新
     * @apiGroup 装修管理
     * @apiName DecorationPageUpdate
     * @apiVersion v1.0.0
     *
     * @apiParam {String} name 页面名称
     *
     * @apiSuccess {Number} code 0成功,非0失败
     */
    public function update(Request $request, $id)
    {
        $name = $request->input('name');

        if (!$name) {
            return $this->error(__('参数错误'));
        }

        $page = $this->decorationPageService->getPage($id);
        if (!$page) {
            return $this->error(__('页面不存在'));
        }

        $data = ['name' => $name];

        $this->decorationPageService->updatePage($id, $data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_UPDATE,
            ['id' => $id, 'name' => $name]
        );

        event(new DecorationPageUpdateEvent($page['page_key']));

        return $this->success();
    }

    /**
     * @api {delete} /backend/api/v1/decoration-page/{id} [管理后台]装修页面-删除
     * @apiGroup 装修管理
     * @apiName DecorationPageDestroy
     * @apiVersion v1.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     */
    public function destroy($id)
    {
        $page = $this->decorationPageService->getPage($id);
        if (!$page) {
            return $this->error(__('页面不存在'));
        }

        $this->decorationPageService->deletePage($id);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );

        event(new DecorationPageUpdateEvent($page['page_key']));

        return $this->success();
    }

    /**
     * @api {post} /backend/api/v1/decoration-page/{id}/set-default [管理后台]装修页面-设置默认
     * @apiGroup 装修管理
     * @apiName DecorationPageSetDefault
     * @apiVersion v1.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     */
    public function setDefault($id)
    {
        $page = $this->decorationPageService->getPage($id);
        if (!$page) {
            return $this->error(__('页面不存在'));
        }

        $this->decorationPageService->setDefaultPage($id);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_UPDATE,
            ['id' => $id, 'action' => 'set_default']
        );

        event(new DecorationPageUpdateEvent($page['page_key']));

        return $this->success();
    }

    /**
     * @api {post} /backend/api/v1/decoration-page/{id}/copy [管理后台]装修页面-复制
     * @apiGroup 装修管理
     * @apiName DecorationPageCopy
     * @apiVersion v1.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Number} data.id 新页面ID
     */
    public function copy($id)
    {
        $page = $this->decorationPageService->getPage($id);
        if (!$page) {
            return $this->error(__('页面不存在'));
        }

        $newId = $this->decorationPageService->copyPage($id);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_STORE,
            ['source_id' => $id, 'new_id' => $newId, 'action' => 'copy']
        );

        event(new DecorationPageUpdateEvent($page['page_key']));

        return $this->successData(['id' => $newId]);
    }

    /**
     * @api {get} /backend/api/v1/decoration-page/{id} [管理后台]装修页面-详情
     * @apiGroup 装修管理
     * @apiName DecorationPageDetail
     * @apiVersion v1.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     */
    public function show($id)
    {
        $page = $this->decorationPageService->getPage($id);

        if (!$page) {
            return $this->error(__('页面不存在'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_VIEW_BLOCK,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData($page);
    }
}
