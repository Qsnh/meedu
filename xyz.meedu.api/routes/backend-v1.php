<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Route;

Route::post('/login', 'LoginController@login');

Route::get('/captcha/image', 'CaptchaController@image');

Route::group(['middleware' => ['auth:administrator']], function () {
    Route::get('/addons', 'AddonsController@index');
    Route::post('/logout', 'LoginController@logout');
});

Route::group(['middleware' => ['auth:administrator', 'backend.permission', 'backend.sensitive.mask']], function () {
    Route::get('/user', 'LoginController@user');

    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/dashboard/check', 'DashboardController@check');
    Route::get('/dashboard/system/info', 'DashboardController@systemInfo');
    Route::get('/dashboard/graph', 'DashboardController@graph');

    Route::group(['prefix' => '/media/image'], function () {
        Route::get('/index', 'MediaImageController@index');
        Route::post('/create', 'MediaImageController@upload');
        Route::post('/delete/multi', 'MediaImageController@destroy');
    });

    Route::group(['prefix' => 'media/videos'], function () {
        Route::get('/index', 'MediaVideoController@index');
        Route::post('/delete/multi', 'MediaVideoController@deleteVideos');
        Route::post('/change-category', 'MediaVideoController@changeCategory');
        Route::post('/record-category-id', 'MediaVideoController@recordCategoryId');
    });

    Route::group(['prefix' => 'media/video-category'], function () {
        Route::get('/index', 'MediaVideoCategoryController@index');
        Route::get('/create', 'MediaVideoCategoryController@create');
        Route::post('/create', 'MediaVideoCategoryController@store');
        Route::get('/{id}', 'MediaVideoCategoryController@edit');
        Route::put('/{id}', 'MediaVideoCategoryController@update');
        Route::delete('/{id}', 'MediaVideoCategoryController@destroy');
        Route::put('/change-sort', 'MediaVideoCategoryController@changeSort');
        Route::put('/change-parent', 'MediaVideoCategoryController@changeParent');
    });

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

    // Nav
    Route::group(['prefix' => 'nav'], function () {
        Route::get('/', 'NavController@index');
        Route::get('/create', 'NavController@create');
        Route::post('/', 'NavController@store');
        Route::get('/{id}', 'NavController@edit');
        Route::put('/{id}', 'NavController@update');
        Route::delete('/{id}', 'NavController@destroy');
    });

    // Role
    Route::group(['prefix' => 'role'], function () {
        Route::get('/', 'RoleController@index');
        Route::get('/all', 'RoleController@all');
        Route::post('/', 'RoleController@store');
        Route::get('/{id}', 'RoleController@edit');
        Route::put('/{id}', 'RoleController@update');
        Route::delete('/{id}', 'RoleController@destroy');
    });

    // 管理员
    Route::group(['prefix' => 'administrator'], function () {
        Route::put('/password', 'AdministratorController@editPasswordHandle');
        Route::get('/', 'AdministratorController@index');
        Route::get('/create', 'AdministratorController@create');
        Route::post('/', 'AdministratorController@store');
        Route::get('/{id}', 'AdministratorController@edit');
        Route::put('/{id}', 'AdministratorController@update');
        Route::delete('/{id}', 'AdministratorController@destroy');
    });

    // 权限
    Route::group(['prefix' => 'administrator_permission'], function () {
        Route::get('/', 'AdministratorPermissionController@index');
    });

    // 角色
    Route::group(['prefix' => 'administrator_role'], function () {
        Route::get('/', 'AdministratorRoleController@index');
        Route::get('/create', 'AdministratorRoleController@create');
        Route::post('/', 'AdministratorRoleController@store');
        Route::get('/{id}', 'AdministratorRoleController@edit');
        Route::put('/{id}', 'AdministratorRoleController@update');
        Route::delete('/{id}', 'AdministratorRoleController@destroy');
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
        Route::get('/all', 'CourseController@all');
        Route::get('/create', 'CourseController@create');
        Route::post('/', 'CourseController@store');
        Route::get('/{id}', 'CourseController@edit');
        Route::put('/{id}', 'CourseController@update');
        Route::delete('/{id}', 'CourseController@destroy');

        Route::get('/{id}/watch/records', 'CourseController@watchRecords');
        Route::post('/{id}/watch/records/delete', 'CourseController@delWatchRecord');

        Route::get('/{id}/subscribes', 'CourseController@subscribes');
        Route::get('/{id}/subscribe/delete', 'CourseController@deleteSubscribe');
        Route::post('/{id}/subscribe/create', 'CourseController@createSubscribe');
        Route::post('/{id}/subscribe/import', 'CourseController@importUsers');
        Route::get('/{id}/user/{userId}/watch/records', 'CourseController@videoWatchRecords');
    });

    // 课程
    Route::group(['prefix' => 'course_attach'], function () {
        Route::get('/', 'CourseAttachController@index');
        Route::get('/create', 'CourseAttachController@create');
        Route::post('/', 'CourseAttachController@store');
        Route::delete('/{id}', 'CourseAttachController@destroy');
    });

    // 视频
    Route::group(['prefix' => 'video'], function () {
        Route::get('/', 'CourseVideoController@index');
        Route::get('/create', 'CourseVideoController@create');
        Route::post('/', 'CourseVideoController@store');
        Route::get('/{id}', 'CourseVideoController@edit');
        Route::put('/{id}', 'CourseVideoController@update');
        Route::delete('/{id}', 'CourseVideoController@destroy');
        Route::post('/delete/multi', 'CourseVideoController@multiDestroy');
        // 购买管理
        Route::get('/{id}/subscribes', 'CourseVideoController@subscribes');
        Route::post('/{id}/subscribe/create', 'CourseVideoController@subscribeCreate');
        Route::get('/{id}/subscribe/delete', 'CourseVideoController@subscribeDelete');
        // 观看记录
        Route::get('/{id}/watch/records', 'CourseVideoController@watchRecords');
        // 批量导入
        Route::post('/import', 'CourseVideoController@import');
    });

    // 会员
    Route::group(['prefix' => 'member'], function () {
        // 批量导入
        Route::post('/import', 'MemberController@import');

        Route::get('/', 'MemberController@index');
        Route::get('/create', 'MemberController@create');
        Route::get('/{id}', 'MemberController@edit');
        Route::post('/', 'MemberController@store');
        Route::put('/{id}', 'MemberController@update');
        Route::delete('/{id}/profile', 'MemberController@deleteUserProfile');
        Route::put('/field/multi', 'MemberController@updateFieldMulti');

        // 更新用户标签
        Route::put('/{id}/tags', 'MemberController@tagUpdate');
        // 备注
        Route::get('/{id}/remark', 'MemberController@remark');
        Route::put('/{id}/remark', 'MemberController@updateRemark');

        // 用户详情
        Route::get('/{id}/detail', 'MemberController@detail');
        Route::get('/{id}/detail/userCourses', 'MemberController@userCourses');
        Route::get('/{id}/detail/userVideos', 'MemberController@userVideos');
        Route::get('/{id}/detail/userRoles', 'MemberController@userRoles');
        Route::get('/{id}/detail/userCollect', 'MemberController@userCollect');
        Route::get('/{id}/detail/userHistory', 'MemberController@userHistory');
        Route::get('/{id}/detail/userOrders', 'MemberController@userOrders');
        Route::get('/{id}/detail/userInvite', 'MemberController@userInvite');
        Route::get('/{id}/detail/credit1Records', 'MemberController@credit1Records');
        Route::get('/{id}/detail/videoWatchRecords', 'MemberController@userVideoWatchRecords');

        // 积分变更
        Route::post('/credit1/change', 'MemberController@credit1Change');
        // 发送站内消息
        Route::post('/{id}/message', 'MemberController@sendMessage');
        Route::post('/message/multi', 'MemberController@sendMessageMulti');

        // 用户标签管理
        Route::group(['prefix' => 'tag'], function () {
            Route::get('/index', 'MemberTagController@index');
            Route::get('/create', 'MemberTagController@create');
            Route::post('/create', 'MemberTagController@store');
            Route::get('/{id}', 'MemberTagController@edit');
            Route::put('/{id}', 'MemberTagController@update');
            Route::delete('/{id}', 'MemberTagController@destroy');
        });
    });

    // 网站配置
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/', 'SettingController@index');
        Route::post('/', 'SettingController@saveHandler');
    });

    // 订单
    Route::group(['prefix' => 'order'], function () {
        Route::get('/', 'OrderController@index');
        Route::get('/{id}', 'OrderController@detail');
        Route::get('/{id}/finish', 'OrderController@finishOrder');
        Route::get('/{id}/cancel', 'OrderController@cancel');
        Route::post('/{id}/refund', 'OrderController@submitRefund');
        Route::get('/refund/list', 'OrderController@refundOrders');
        Route::delete('/refund/{id}', 'OrderController@deleteRefundOrder');
    });

    // 优惠码
    Route::group(['prefix' => 'promoCode'], function () {
        Route::get('/', 'PromoCodeController@index');
        Route::post('/', 'PromoCodeController@store');
        Route::get('/{id}', 'PromoCodeController@edit');
        Route::put('/{id}', 'PromoCodeController@update');
        Route::post('/delete/multi', 'PromoCodeController@destroy');
        Route::post('/import', 'PromoCodeController@import');
        Route::post('/generator', 'PromoCodeController@generator');
    });

    // 课程分类
    Route::group(['prefix' => 'courseCategory'], function () {
        Route::get('/', 'CourseCategoryController@index');
        Route::get('/create', 'CourseCategoryController@create');
        Route::post('/', 'CourseCategoryController@store');
        Route::get('/{id}', 'CourseCategoryController@edit');
        Route::put('/{id}', 'CourseCategoryController@update');
        Route::delete('/{id}', 'CourseCategoryController@destroy');
    });

    // 插件
    Route::group(['prefix' => 'addons'], function () {
        Route::post('/switch', 'AddonsController@switchHandler');
    });

    // 装修
    Route::group(['prefix' => 'viewBlock'], function () {
        Route::get('/index', 'ViewBlockController@index');
        Route::get('/create', 'ViewBlockController@create');
        Route::post('/create', 'ViewBlockController@store');
        Route::get('/{id}', 'ViewBlockController@edit');
        Route::put('/{id}', 'ViewBlockController@update');
        Route::delete('/{id}', 'ViewBlockController@destroy');
    });

    Route::group(['prefix' => 'log'], function () {
        Route::get('/admin', 'LogController@admin');
        Route::get('/userLogin', 'LogController@userLogin');
        Route::get('/uploadImages', 'LogController@uploadImages');
        Route::get('/runtime', 'LogController@runtime');
        Route::delete('/{sign}', 'LogController@destroy');
    });

    // 评论
    Route::group(['prefix' => 'comment'], function () {
        Route::get('/index', 'CommentController@index');
        Route::post('/delete', 'CommentController@destroy');
        Route::post('/check', 'CommentController@check');
    });

    // 协议管理
    Route::group(['prefix' => 'agreement'], function () {
        Route::get('/index', 'AgreementController@index');
        Route::get('/create', 'AgreementController@create');
        Route::post('/create', 'AgreementController@store');
        Route::get('/{id}', 'AgreementController@edit');
        Route::put('/{id}', 'AgreementController@update');
        Route::delete('/{id}', 'AgreementController@destroy');
        Route::get('/{id}/records', 'AgreementController@records');
    });
});
