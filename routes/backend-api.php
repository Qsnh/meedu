<?php

Route::post('/login', 'LoginController@login');

Route::group(['middleware' => ['auth:administrator']], function () {

    Route::get('/user', 'LoginController@user');

    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/dashboard/system/info', 'DashboardController@systemInfo');

    Route::group(['prefix' => 'video/token'], function () {
        Route::post('/tencent', 'VideoUploadController@tencentToken');
        Route::post('/aliyun/refresh', 'VideoUploadController@aliyunRefreshVideoToken');
        Route::post('/aliyun/create', 'VideoUploadController@aliyunCreateVideoToken');
    });

    // 友情链接
    Route::group(['prefix' => 'link'], function () {
        Route::get('/', 'LinkController@index');
        Route::post('/', 'LinkController@store');
        Route::get('/{id}', 'LinkController@edit');
        Route::put('/{id}', 'LinkController@update');
        Route::delete('/{id}', 'LinkController@destroy');
    });

    // 幻灯片
    Route::group(['prefix' => 'slider'], function () {
        Route::get('/', 'SliderController@index');
        Route::post('/', 'SliderController@store');
        Route::get('/{id}', 'SliderController@edit');
        Route::put('/{id}', 'SliderController@update');
        Route::delete('/{id}', 'SliderController@destroy');
    });

    // 广告推广
    Route::group(['prefix' => 'ad_from'], function () {
        Route::get('/', 'AdFromController@index');
        Route::post('/', 'AdFromController@store');
        Route::get('/{id}', 'AdFromController@edit');
        Route::get('/{id}/number', 'AdFromController@number');
        Route::put('/{id}', 'AdFromController@update');
        Route::delete('/{id}', 'AdFromController@destroy');
    });

    // 公告
    Route::group(['prefix' => 'announcement'], function () {
        Route::get('/', 'AnnouncementController@index');
        Route::post('/', 'AnnouncementController@store');
        Route::get('/{id}', 'AnnouncementController@edit');
        Route::put('/{id}', 'AnnouncementController@update');
        Route::delete('/{id}', 'AnnouncementController@destroy');
    });

    // 课程评论
    Route::group(['prefix' => 'course_comment'], function () {
        Route::get('/', 'CourseCommentController@index');
        Route::delete('/{id}', 'CourseCommentController@destroy');
    });

    // Nav
    Route::group(['prefix' => 'nav'], function () {
        Route::get('/', 'NavController@index');
        Route::post('/', 'NavController@store');
        Route::get('/{id}', 'NavController@edit');
        Route::put('/{id}', 'NavController@update');
        Route::delete('/{id}', 'NavController@destroy');
    });

    // Role
    Route::group(['prefix' => 'role'], function () {
        Route::get('/', 'RoleController@index');
        Route::post('/', 'RoleController@store');
        Route::get('/{id}', 'RoleController@edit');
        Route::put('/{id}', 'RoleController@update');
        Route::delete('/{id}', 'RoleController@destroy');
    });

    // 视频评论
    Route::group(['prefix' => 'video_comment'], function () {
        Route::get('/', 'VideoCommentController@index');
        Route::delete('/{id}', 'VideoCommentController@destroy');
    });

    // 管理员
    Route::group(['prefix' => 'administrator'], function () {
        Route::put('/password', 'AdministratorController@editPasswordHandle');
        Route::get('/', 'AdministratorController@index');
        Route::get('/user', 'AdministratorController@user');
        Route::post('/', 'AdministratorController@store');
        Route::get('/{id}', 'AdministratorController@edit');
        Route::put('/{id}', 'AdministratorController@update');
        Route::delete('/{id}', 'AdministratorController@destroy');
    });

    // 权限
    Route::group(['prefix' => 'administrator_permission'], function () {
        Route::get('/', 'AdministratorPermissionController@index');
        Route::post('/', 'AdministratorPermissionController@store');
        Route::get('/{id}', 'AdministratorPermissionController@edit');
        Route::put('/{id}', 'AdministratorPermissionController@update');
        Route::delete('/{id}', 'AdministratorPermissionController@destroy');
    });

    // 后台菜单
    Route::group(['prefix' => 'administrator_menu'], function () {
        Route::get('/', 'AdministratorMenuController@index');
        Route::post('/', 'AdministratorMenuController@store');
        Route::get('/{id}', 'AdministratorMenuController@edit');
        Route::put('/{id}/', 'AdministratorMenuController@update');
        Route::delete('/{id}/', 'AdministratorMenuController@destroy');
        Route::post('/save', 'AdministratorMenuController@saveChange');
    });

    // 角色
    Route::group(['prefix' => 'administrator_role'], function () {
        Route::get('/', 'AdministratorRoleController@index');
        Route::post('/', 'AdministratorRoleController@store');
        Route::get('/{id}', 'AdministratorRoleController@edit');
        Route::put('/{id}', 'AdministratorRoleController@update');
        Route::delete('/{id}', 'AdministratorRoleController@destroy');
        Route::post('/{id}/permission', 'AdministratorRoleController@permissionSave');
    });

    // 课程章节
    Route::group(['prefix' => 'course_chapter'], function () {
        Route::get('/{course_id}', 'CourseChapterController@index');
        Route::post('/{course_id}', 'CourseChapterController@store');
        Route::get('/{course_id}/{id}', 'CourseChapterController@edit');
        Route::put('/{course_id}/{id}', 'CourseChapterController@update');
        Route::delete('/{course_id}/{id}', 'CourseChapterController@destroy');
    });

    // 课程
    Route::group(['prefix' => 'course'], function () {
        Route::get('/', 'CourseController@index');
        Route::get('/create', 'CourseController@create');
        Route::post('/', 'CourseController@store');
        Route::get('/{id}', 'CourseController@edit');
        Route::put('/{id}', 'CourseController@update');
        Route::delete('/{id}', 'CourseController@destroy');
        Route::get('/{id}/subscribe/users', 'CourseController@subscribeUsers');
    });

    // 视频
    Route::group(['prefix' => 'video'], function () {
        Route::get('/', 'CourseVideoController@index');
        Route::post('/', 'CourseVideoController@store');
        Route::get('/{id}', 'CourseVideoController@edit');
        Route::put('/{id}', 'CourseVideoController@update');
        Route::delete('/{id}', 'CourseVideoController@destroy');
        Route::get('/create/params', 'CourseVideoController@createParams');
    });

    // 会员
    Route::group(['prefix' => 'member'], function () {
        Route::get('/', 'MemberController@index');
        Route::get('/create', 'MemberController@create');
        Route::get('/{id}', 'MemberController@edit');
        Route::post('/', 'MemberController@store');
        Route::put('/{id}', 'MemberController@update');
        Route::get('/inviteBalance/withdrawOrders', 'MemberController@inviteBalanceWithdrawOrders');
        Route::post('/inviteBalance/withdrawOrders', 'MemberController@inviteBalanceWithdrawOrderHandle');
    });

    // 网站配置
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/', 'SettingController@index');
        Route::post('/', 'SettingController@saveHandler');
    });

    // 订单
    Route::group(['prefix' => 'order'], function () {
        Route::get('/', 'OrderController@index');
        Route::get('/{id}/finish', 'OrderController@finishOrder');
    });

    // 图片上传
    Route::post('/upload/image/tinymce', 'UploadController@tinymceImageUpload');

    // 优惠码
    Route::group(['prefix' => 'promoCode'], function () {
        Route::get('/', 'PromoCodeController@index');
        Route::post('/', 'PromoCodeController@store');
        Route::get('/{id}', 'PromoCodeController@edit');
        Route::put('/{id}', 'PromoCodeController@update');
        Route::delete('/{id}', 'PromoCodeController@destroy');
    });

    // 课程分类
    Route::group(['prefix' => 'courseCategory'], function () {
        Route::get('/', 'CourseCategoryController@index');
        Route::post('/', 'CourseCategoryController@store');
        Route::get('/{id}', 'CourseCategoryController@edit');
        Route::put('/{id}', 'CourseCategoryController@update');
        Route::delete('/{id}', 'CourseCategoryController@destroy');
    });

    // 插件
    Route::group(['prefix' => 'addons'], function () {
        Route::get('/', 'AddonsController@index');
        Route::get('/repository', 'AddonsController@repository');
        Route::get('/repository/user', 'AddonsController@user');
        Route::get('/repository/buy', 'AddonsController@buyAddons');
        Route::get('/repository/install', 'AddonsController@installAddons');
        Route::get('/repository/upgrade', 'AddonsController@upgradeAddons');
        Route::post('/switch', 'AddonsController@switchHandler');
    });

    // IndexBanner
    Route::group(['prefix' => 'indexBanner'], function () {
        Route::get('/', 'IndexBannerController@index');
        Route::get('/create', 'IndexBannerController@create');
        Route::post('/', 'IndexBannerController@store');
        Route::get('/{id}', 'IndexBannerController@edit');
        Route::put('/{id}', 'IndexBannerController@update');
        Route::delete('/{id}', 'IndexBannerController@destroy');
    });

    Route::group(['prefix' => 'statistic'], function () {
        Route::get('/userRegister', 'StatisticController@userRegister');
        Route::get('/orderCreated', 'StatisticController@orderCreated');
    });
});