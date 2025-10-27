<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use App\Constant\BackendPermission;
use Illuminate\Support\Facades\Route;

// 公开路由
Route::post('/login', 'LoginController@login');
Route::get('/captcha/image', 'CaptchaController@image');

// 需要认证但不需要权限检查的路由
Route::group(['middleware' => ['auth:administrator']], function () {
    // 系统已启用插件
    Route::get('/addons', 'AddonsController@index');
    // 安全退出
    Route::post('/logout', 'LoginController@logout');
    // 当前登录管理员信息
    Route::get('/user', 'LoginController@user')->middleware('backend.sensitive.mask');
    // 管理员修改密码
    Route::put('/administrator/password', 'AdministratorController@editPasswordHandle');
});

// 需要权限检查的路由
Route::group(['middleware' => ['auth:administrator', 'backend.sensitive.mask']], function () {
    // 主面板
    Route::get('/dashboard', 'DashboardController@index')->middleware('mbp:' . BackendPermission::DASHBOARD);
    Route::get('/dashboard/check', 'DashboardController@check')->middleware('mbp:' . BackendPermission::DASHBOARD);
    Route::get('/dashboard/system/info', 'DashboardController@systemInfo')->middleware('mbp:' . BackendPermission::DASHBOARD);
    Route::get('/dashboard/graph', 'DashboardController@graph')->middleware('mbp:' . BackendPermission::DASHBOARD);

    // 资源-图片库
    Route::group(['prefix' => '/media/image'], function () {
        Route::get('/index', 'MediaImageController@index')->middleware('mbp:' . BackendPermission::MEDIA_IMAGE_INDEX);
        Route::post('/create', 'MediaImageController@upload')->middleware('mbp:' . BackendPermission::MEDIA_IMAGE_STORE);
        Route::post('/delete/multi', 'MediaImageController@destroy')->middleware('mbp:' . BackendPermission::MEDIA_IMAGE_DELETE_MULTI);
    });

    // 资源-视频库
    Route::group(['prefix' => 'media/videos'], function () {
        Route::get('/index', 'MediaVideoController@index')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_LIST);
        Route::post('/delete/multi', 'MediaVideoController@deleteVideos')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_DELETE_MULTI);
        Route::post('/change-category', 'MediaVideoController@changeCategory')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_CHANGE_CATEGORY);
        Route::post('/record-category-id', 'MediaVideoController@recordCategoryId')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_UPLOAD);
    });

    // 资源-视频分类
    Route::group(['prefix' => 'media/video-category'], function () {
        Route::get('/index', 'MediaVideoCategoryController@index')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_LIST);
        Route::get('/create', 'MediaVideoCategoryController@create')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_CATEGORY_STORE);
        Route::post('/create', 'MediaVideoCategoryController@store')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_CATEGORY_STORE);
        Route::get('/{id}', 'MediaVideoCategoryController@edit')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_CATEGORY_UPDATE);
        Route::put('/{id}', 'MediaVideoCategoryController@update')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_CATEGORY_UPDATE);
        Route::delete('/{id}', 'MediaVideoCategoryController@destroy')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_CATEGORY_DELETE);
        Route::put('/change-sort', 'MediaVideoCategoryController@changeSort')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_CATEGORY_UPDATE);
        Route::put('/change-parent', 'MediaVideoCategoryController@changeParent')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_CATEGORY_UPDATE);
    });

    // 资源-视频上传token
    Route::group(['prefix' => 'video/token'], function () {
        Route::post('/tencent', 'VideoUploadController@tencentToken')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_UPLOAD);
        Route::post('/aliyun/refresh', 'VideoUploadController@aliyunRefreshVideoToken')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_UPLOAD);
        Route::post('/aliyun/create', 'VideoUploadController@aliyunCreateVideoToken')->middleware('mbp:' . BackendPermission::MEDIA_VIDEO_UPLOAD);
    });

    // 装修-友情链接
    Route::group(['prefix' => 'link'], function () {
        Route::get('/index', 'LinkController@index')->middleware('mbp:' . BackendPermission::LINK);
        Route::post('/create', 'LinkController@store')->middleware('mbp:' . BackendPermission::LINK_STORE);
        Route::get('/{id}', 'LinkController@edit')->middleware('mbp:' . BackendPermission::LINK_UPDATE);
        Route::put('/{id}', 'LinkController@update')->middleware('mbp:' . BackendPermission::LINK_UPDATE);
        Route::delete('/{id}', 'LinkController@destroy')->middleware('mbp:' . BackendPermission::LINK_DESTROY);
    });

    // 运营-公告
    Route::group(['prefix' => 'announcement'], function () {
        Route::get('/index', 'AnnouncementController@index')->middleware('mbp:' . BackendPermission::ANNOUNCEMENT);
        Route::post('/create', 'AnnouncementController@store')->middleware('mbp:' . BackendPermission::ANNOUNCEMENT_STORE);
        Route::get('/{id}', 'AnnouncementController@edit')->middleware('mbp:' . BackendPermission::ANNOUNCEMENT_UPDATE);
        Route::put('/{id}', 'AnnouncementController@update')->middleware('mbp:' . BackendPermission::ANNOUNCEMENT_UPDATE);
        Route::delete('/{id}', 'AnnouncementController@destroy')->middleware('mbp:' . BackendPermission::ANNOUNCEMENT_DESTROY);
    });

    // 装修-PC首页导航
    Route::group(['prefix' => 'nav'], function () {
        Route::get('/index', 'NavController@index')->middleware('mbp:' . BackendPermission::NAV);
        Route::get('/create', 'NavController@create')->middleware('mbp:' . BackendPermission::NAV_STORE);
        Route::post('/create', 'NavController@store')->middleware('mbp:' . BackendPermission::NAV_STORE);
        Route::get('/{id}', 'NavController@edit')->middleware('mbp:' . BackendPermission::NAV_UPDATE);
        Route::put('/{id}', 'NavController@update')->middleware('mbp:' . BackendPermission::NAV_UPDATE);
        Route::delete('/{id}', 'NavController@destroy')->middleware('mbp:' . BackendPermission::NAV_DESTROY);
    });

    // 运营-VIP会员
    Route::group(['prefix' => 'role'], function () {
        Route::get('/index', 'RoleController@index')->middleware('mbp:' . BackendPermission::ROLE);
        Route::post('/create', 'RoleController@store')->middleware('mbp:' . BackendPermission::ROLE_STORE);
        Route::get('/{id}', 'RoleController@edit')->middleware('mbp:' . BackendPermission::ROLE_UPDATE);
        Route::put('/{id}', 'RoleController@update')->middleware('mbp:' . BackendPermission::ROLE_UPDATE);
        Route::delete('/{id}', 'RoleController@destroy')->middleware('mbp:' . BackendPermission::ROLE_DESTROY);
    });

    // 系统-管理人员
    Route::group(['prefix' => 'administrator'], function () {
        Route::get('/index', 'AdministratorController@index')->middleware('mbp:' . BackendPermission::ADMINISTRATOR);
        Route::get('/create', 'AdministratorController@create')->middleware('mbp:' . BackendPermission::ADMINISTRATOR_STORE);
        Route::post('/create', 'AdministratorController@store')->middleware('mbp:' . BackendPermission::ADMINISTRATOR_STORE);
        Route::get('/{id}', 'AdministratorController@edit')->middleware('mbp:' . BackendPermission::ADMINISTRATOR_UPDATE);
        Route::put('/{id}', 'AdministratorController@update')->middleware('mbp:' . BackendPermission::ADMINISTRATOR_UPDATE);
        Route::delete('/{id}', 'AdministratorController@destroy')->middleware('mbp:' . BackendPermission::ADMINISTRATOR_DESTROY);
    });

    // 系统-管理人员-角色
    Route::group(['prefix' => 'administrator_role'], function () {
        Route::get('/index', 'AdministratorRoleController@index')->middleware('mbp:' . BackendPermission::ADMINISTRATOR_ROLE);
        Route::get('/create', 'AdministratorRoleController@create')->middleware('mbp:' . BackendPermission::ADMINISTRATOR_ROLE_STORE);
        Route::post('/create', 'AdministratorRoleController@store')->middleware('mbp:' . BackendPermission::ADMINISTRATOR_ROLE_STORE);
        Route::get('/{id}', 'AdministratorRoleController@edit')->middleware('mbp:' . BackendPermission::ADMINISTRATOR_ROLE_UPDATE);
        Route::put('/{id}', 'AdministratorRoleController@update')->middleware('mbp:' . BackendPermission::ADMINISTRATOR_ROLE_UPDATE);
        Route::delete('/{id}', 'AdministratorRoleController@destroy')->middleware('mbp:' . BackendPermission::ADMINISTRATOR_ROLE_DESTROY);
    });

    // 课程-录播课-课时-章节管理
    Route::group(['prefix' => 'course_chapter'], function () {
        Route::get('/{course_id}/index', 'CourseChapterController@index')->middleware('mbp:' . BackendPermission::COURSE_CHAPTER);
        Route::post('/{course_id}/create', 'CourseChapterController@store')->middleware('mbp:' . BackendPermission::COURSE_CHAPTER_STORE);
        Route::get('/{course_id}/{id}', 'CourseChapterController@edit')->middleware('mbp:' . BackendPermission::COURSE_CHAPTER_UPDATE);
        Route::put('/{course_id}/{id}', 'CourseChapterController@update')->middleware('mbp:' . BackendPermission::COURSE_CHAPTER_UPDATE);
        Route::delete('/{course_id}/{id}', 'CourseChapterController@destroy')->middleware('mbp:' . BackendPermission::COURSE_CHAPTER_DESTROY);
    });

    // 课程-录播课
    Route::group(['prefix' => 'course'], function () {
        Route::get('/index', 'CourseController@index')->middleware('mbp:' . BackendPermission::COURSE);
        Route::get('/create', 'CourseController@create')->middleware('mbp:' . BackendPermission::COURSE_STORE);
        Route::post('/create', 'CourseController@store')->middleware('mbp:' . BackendPermission::COURSE_STORE);
        Route::get('/{id}', 'CourseController@edit')->middleware('mbp:' . BackendPermission::COURSE_UPDATE);
        Route::put('/{id}', 'CourseController@update')->middleware('mbp:' . BackendPermission::COURSE_UPDATE);
        Route::delete('/{id}', 'CourseController@destroy')->middleware('mbp:' . BackendPermission::COURSE_DESTROY);

        Route::get('/{id}/watch/records', 'CourseController@watchRecords')->middleware('mbp:' . BackendPermission::COURSE_WATCH_RECORDS);
        Route::post('/{id}/watch/records/delete', 'CourseController@delWatchRecord')->middleware('mbp:' . BackendPermission::COURSE_WATCH_RECORDS_DELETE);

        Route::get('/{id}/subscribes', 'CourseController@subscribes')->middleware('mbp:' . BackendPermission::COURSE_SUBSCRIBES);
        Route::get('/{id}/subscribe/delete', 'CourseController@deleteSubscribe')->middleware('mbp:' . BackendPermission::COURSE_SUBSCRIBE_DELETE);
        Route::post('/{id}/subscribe/create', 'CourseController@createSubscribe')->middleware('mbp:' . BackendPermission::COURSE_SUBSCRIBE_CREATE);
        Route::post('/{id}/subscribe/import', 'CourseController@importUsers')->middleware('mbp:' . BackendPermission::COURSE_SUBSCRIBE_CREATE);
        Route::get('/{id}/user/{userId}/watch/records', 'CourseController@videoWatchRecords')->middleware('mbp:' . BackendPermission::COURSE_WATCH_RECORDS);
    });

    // 课程-录播课-附件
    Route::group(['prefix' => 'course_attach'], function () {
        Route::get('/index', 'CourseAttachController@index')->middleware('mbp:' . BackendPermission::COURSE_ATTACH);
        Route::get('/create', 'CourseAttachController@create')->middleware('mbp:' . BackendPermission::COURSE_ATTACH_STORE);
        Route::post('/create', 'CourseAttachController@store')->middleware('mbp:' . BackendPermission::COURSE_ATTACH_STORE);
        Route::delete('/{id}', 'CourseAttachController@destroy')->middleware('mbp:' . BackendPermission::COURSE_ATTACH_DESTROY);
    });

    // 课程-录播课-课时
    Route::group(['prefix' => 'video'], function () {
        Route::get('/index', 'CourseVideoController@index')->middleware('mbp:' . BackendPermission::VIDEO);
        Route::get('/create', 'CourseVideoController@create')->middleware('mbp:' . BackendPermission::VIDEO_STORE);
        Route::post('/create', 'CourseVideoController@store')->middleware('mbp:' . BackendPermission::VIDEO_STORE);
        Route::get('/{id}', 'CourseVideoController@edit')->middleware('mbp:' . BackendPermission::VIDEO_UPDATE);
        Route::put('/{id}', 'CourseVideoController@update')->middleware('mbp:' . BackendPermission::VIDEO_UPDATE);
        Route::delete('/{id}', 'CourseVideoController@destroy')->middleware('mbp:' . BackendPermission::VIDEO_DESTROY);
        Route::post('/delete/multi', 'CourseVideoController@multiDestroy')->middleware('mbp:' . BackendPermission::VIDEO_DESTROY);
        Route::get('/{id}/watch/records', 'CourseVideoController@watchRecords')->middleware('mbp:' . BackendPermission::VIDEO_WATCH_RECORDS);
        Route::post('/import', 'CourseVideoController@import')->middleware('mbp:' . BackendPermission::VIDEO_STORE);
    });

    // 学员
    Route::group(['prefix' => 'member'], function () {
        Route::post('/import', 'MemberController@import')->middleware('mbp:' . BackendPermission::MEMBER_STORE);

        Route::get('/index', 'MemberController@index')->middleware('mbp:' . BackendPermission::MEMBER);
        Route::get('/create', 'MemberController@create')->middleware('mbp:' . BackendPermission::MEMBER_STORE);
        Route::post('/create', 'MemberController@store')->middleware('mbp:' . BackendPermission::MEMBER_STORE);
        Route::get('/{id}', 'MemberController@edit')->middleware('mbp:' . BackendPermission::MEMBER_UPDATE);
        Route::put('/{id}', 'MemberController@update')->middleware('mbp:' . BackendPermission::MEMBER_UPDATE);
        Route::delete('/{id}/profile', 'MemberController@deleteUserProfile')->middleware('mbp:' . BackendPermission::MEMBER_PROFILE_DESTROY);
        Route::put('/field/multi', 'MemberController@updateFieldMulti')->middleware('mbp:' . BackendPermission::MEMBER_UPDATE);

        // 更新用户标签
        Route::put('/{id}/tags', 'MemberController@tagUpdate')->middleware('mbp:' . BackendPermission::MEMBER_TAGS);
        // 备注
        Route::get('/{id}/remark', 'MemberController@remark')->middleware('mbp:' . BackendPermission::MEMBER_REMARK);
        Route::put('/{id}/remark', 'MemberController@updateRemark')->middleware('mbp:' . BackendPermission::MEMBER_REMARK_UPDATE);

        // 用户详情
        Route::get('/{id}/detail', 'MemberController@detail')->middleware('mbp:' . BackendPermission::MEMBER_DETAIL);
        Route::get('/{id}/detail/userOrders', 'MemberController@userOrders')->middleware('mbp:' . BackendPermission::MEMBER_DETAIL_USER_ORDERS);
        Route::get('/{id}/detail/userInvite', 'MemberController@userInvite')->middleware('mbp:' . BackendPermission::MEMBER_DETAIL);
        Route::get('/{id}/detail/credit1Records', 'MemberController@credit1Records')->middleware('mbp:' . BackendPermission::MEMBER_DETAIL_CREDIT1_RECORDS);

        // 积分变更
        Route::post('/credit1/change', 'MemberController@credit1Change')->middleware('mbp:' . BackendPermission::MEMBER_CREDIT1_CHANGE);
        // 发送站内消息
        Route::post('/{id}/message', 'MemberController@sendMessage')->middleware('mbp:' . BackendPermission::MEMBER_MESSAGE_SEND);
        Route::post('/message/multi', 'MemberController@sendMessageMulti')->middleware('mbp:' . BackendPermission::MEMBER_MESSAGE_SEND);

        // 用户标签管理
        Route::group(['prefix' => 'tag'], function () {
            Route::get('/index', 'MemberTagController@index')->middleware('mbp:' . BackendPermission::MEMBER_TAG);
            Route::get('/create', 'MemberTagController@create')->middleware('mbp:' . BackendPermission::MEMBER_TAG_STORE);
            Route::post('/create', 'MemberTagController@store')->middleware('mbp:' . BackendPermission::MEMBER_TAG_STORE);
            Route::get('/{id}', 'MemberTagController@edit')->middleware('mbp:' . BackendPermission::MEMBER_TAG_UPDATE);
            Route::put('/{id}', 'MemberTagController@update')->middleware('mbp:' . BackendPermission::MEMBER_TAG_UPDATE);
            Route::delete('/{id}', 'MemberTagController@destroy')->middleware('mbp:' . BackendPermission::MEMBER_TAG_DESTROY);
        });
    });

    // 系统-系统配置
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/', 'SettingController@index')->middleware('mbp:' . BackendPermission::SETTING);
        Route::post('/', 'SettingController@saveHandler')->middleware('mbp:' . BackendPermission::SETTING_SAVE);
    });

    // 财务-全部订单
    Route::group(['prefix' => 'order'], function () {
        Route::get('/', 'OrderController@index')->middleware('mbp:' . BackendPermission::ORDER);
        Route::get('/{id}', 'OrderController@detail')->middleware('mbp:' . BackendPermission::ORDER_DETAIL);
        Route::get('/{id}/finish', 'OrderController@finishOrder')->middleware('mbp:' . BackendPermission::ORDER_FINISH);
        Route::get('/{id}/cancel', 'OrderController@cancel')->middleware('mbp:' . BackendPermission::ORDER_CANCEL);
        Route::post('/{id}/refund', 'OrderController@submitRefund')->middleware('mbp:' . BackendPermission::ORDER_REFUND);
        Route::get('/refund/list', 'OrderController@refundOrders')->middleware('mbp:' . BackendPermission::ORDER_REFUND_LIST);
        Route::delete('/refund/{id}', 'OrderController@deleteRefundOrder')->middleware('mbp:' . BackendPermission::ORDER_REFUND_DELETE);
    });

    // 运营-优惠码
    Route::group(['prefix' => 'promoCode'], function () {
        Route::get('/', 'PromoCodeController@index')->middleware('mbp:' . BackendPermission::PROMO_CODE);
        Route::post('/', 'PromoCodeController@store')->middleware('mbp:' . BackendPermission::PROMO_CODE_STORE);
        Route::get('/{id}', 'PromoCodeController@edit')->middleware('mbp:' . BackendPermission::PROMO_CODE_UPDATE);
        Route::put('/{id}', 'PromoCodeController@update')->middleware('mbp:' . BackendPermission::PROMO_CODE_UPDATE);
        Route::post('/delete/multi', 'PromoCodeController@destroy')->middleware('mbp:' . BackendPermission::PROMO_CODE_DESTROY_MULTI);
        Route::post('/import', 'PromoCodeController@import')->middleware('mbp:' . BackendPermission::PROMO_CODE_STORE);
        Route::post('/generator', 'PromoCodeController@generator')->middleware('mbp:' . BackendPermission::PROMO_CODE_GENERATOR);
    });

    // 课程-录播课-录播课分类
    Route::group(['prefix' => 'courseCategory'], function () {
        Route::get('/', 'CourseCategoryController@index')->middleware('mbp:' . BackendPermission::COURSE_CATEGORY);
        Route::get('/create', 'CourseCategoryController@create')->middleware('mbp:' . BackendPermission::COURSE_CATEGORY_STORE);
        Route::post('/', 'CourseCategoryController@store')->middleware('mbp:' . BackendPermission::COURSE_CATEGORY_STORE);
        Route::get('/{id}', 'CourseCategoryController@edit')->middleware('mbp:' . BackendPermission::COURSE_CATEGORY_UPDATE);
        Route::put('/{id}', 'CourseCategoryController@update')->middleware('mbp:' . BackendPermission::COURSE_CATEGORY_UPDATE);
        Route::delete('/{id}', 'CourseCategoryController@destroy')->middleware('mbp:' . BackendPermission::COURSE_CATEGORY_DESTROY);
    });

    // 插件
    Route::group(['prefix' => 'addons'], function () {
        Route::post('/switch', 'AddonsController@switchHandler')->middleware('mbp:' . BackendPermission::SUPER_ADMIN_ONLY);
    });

    // 装修-页面-装修
    Route::group(['prefix' => 'viewBlock'], function () {
        Route::get('/index', 'ViewBlockController@index')->middleware('mbp:' . BackendPermission::DECORATION_PAGE_BLOCKS);
        Route::get('/create', 'ViewBlockController@create')->middleware('mbp:' . BackendPermission::DECORATION_PAGE_BLOCKS);
        Route::post('/create', 'ViewBlockController@store')->middleware('mbp:' . BackendPermission::DECORATION_PAGE_BLOCKS);
        Route::get('/{id}', 'ViewBlockController@edit')->middleware('mbp:' . BackendPermission::DECORATION_PAGE_BLOCKS);
        Route::put('/{id}', 'ViewBlockController@update')->middleware('mbp:' . BackendPermission::DECORATION_PAGE_BLOCKS);
        Route::delete('/{id}', 'ViewBlockController@destroy')->middleware('mbp:' . BackendPermission::DECORATION_PAGE_BLOCKS);
    });

    // 装修-页面
    Route::group(['prefix' => 'decoration-page'], function () {
        Route::get('/', 'DecorationPageController@index')->middleware('mbp:' . BackendPermission::DECORATION_PAGE);
        Route::post('/', 'DecorationPageController@store')->middleware('mbp:' . BackendPermission::DECORATION_PAGE_STORE);
        Route::get('/{id}', 'DecorationPageController@show')->middleware('mbp:' . BackendPermission::DECORATION_PAGE_UPDATE);
        Route::put('/{id}', 'DecorationPageController@update')->middleware('mbp:' . BackendPermission::DECORATION_PAGE_UPDATE);
        Route::delete('/{id}', 'DecorationPageController@destroy')->middleware('mbp:' . BackendPermission::DECORATION_PAGE_DESTROY);
        Route::post('/{id}/set-default', 'DecorationPageController@setDefault')->middleware('mbp:' . BackendPermission::DECORATION_PAGE_SET_DEFAULT);
        Route::post('/{id}/copy', 'DecorationPageController@copy')->middleware('mbp:' . BackendPermission::DECORATION_PAGE_COPY);
    });

    // 系统-系统日志
    Route::group(['prefix' => 'log'], function () {
        Route::get('/admin', 'LogController@admin')->middleware('mbp:' . BackendPermission::SYSTEM_AUDIT_LOG);
        Route::get('/userLogin', 'LogController@userLogin')->middleware('mbp:' . BackendPermission::SYSTEM_AUDIT_LOG);
        Route::get('/uploadImages', 'LogController@uploadImages')->middleware('mbp:' . BackendPermission::SYSTEM_AUDIT_LOG);
        Route::get('/runtime', 'LogController@runtime')->middleware('mbp:' . BackendPermission::SYSTEM_AUDIT_LOG);
        Route::delete('/{sign}', 'LogController@destroy')->middleware('mbp:' . BackendPermission::SYSTEM_AUDIT_LOG_CLEAR);
    });

    // 运营-课程评论
    Route::group(['prefix' => 'comment'], function () {
        Route::get('/index', 'CommentController@index')->middleware('mbp:' . BackendPermission::COMMENT_INDEX);
        Route::post('/delete', 'CommentController@destroy')->middleware('mbp:' . BackendPermission::COMMENT_DELETE);
        Route::post('/check', 'CommentController@check')->middleware('mbp:' . BackendPermission::COMMENT_CHECK);
    });

    // 运营-协议管理
    Route::group(['prefix' => 'agreement'], function () {
        Route::get('/index', 'AgreementController@index')->middleware('mbp:' . BackendPermission::AGREEMENTS);
        Route::get('/create', 'AgreementController@create')->middleware('mbp:' . BackendPermission::AGREEMENTS);
        Route::post('/create', 'AgreementController@store')->middleware('mbp:' . BackendPermission::AGREEMENTS);
        Route::get('/{id}', 'AgreementController@edit')->middleware('mbp:' . BackendPermission::AGREEMENTS);
        Route::put('/{id}', 'AgreementController@update')->middleware('mbp:' . BackendPermission::AGREEMENTS);
        Route::delete('/{id}', 'AgreementController@destroy')->middleware('mbp:' . BackendPermission::AGREEMENTS);
        Route::get('/{id}/records', 'AgreementController@records')->middleware('mbp:' . BackendPermission::AGREEMENTS_RECORDS);
    });
});
