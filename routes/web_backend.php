<?php

// 后台登录
Route::get('/login', 'AdministratorController@showLoginForm')->name('backend.login');
Route::post('/login', 'AdministratorController@loginHandle');
Route::get('/logout', 'AdministratorController@logoutHandle')->name('backend.logout');
// 修改密码
Route::get('/password/update', 'AdministratorController@showEditPasswordForm')->name('backend.edit.password');
Route::put('/password/update', 'AdministratorController@editPasswordHandle');

Route::group(['middleware' => ['backend.login.check']], function () {
    // 主面板
    Route::get('/dashboard', 'DashboardController@index')->name('backend.dashboard.index');
    // 图片上传
    Route::post('/upload/image', 'UploadController@uploadImageHandle')->name('backend.upload.image');
    // 阿里云视频上传
    Route::post('/video/aliyun/create', 'AliyunVideoUploadController@createVideoToken')->name('video.upload.aliyun.create');
    Route::post('/video/aliyun/refresh', 'AliyunVideoUploadController@refreshVideoToken')->name('video.upload.aliyun.refresh');

    Route::group(['middleware' => 'backend.permission.check'], function () {
        // 管理员
        Route::get('/administrator', 'AdministratorController@index')->name('backend.administrator.index');
        Route::get('/administrator/create', 'AdministratorController@create')->name('backend.administrator.create');
        Route::post('/administrator/create', 'AdministratorController@store');
        Route::get('/administrator/{id}/edit', 'AdministratorController@edit')->name('backend.administrator.edit');
        Route::put('/administrator/{id}/edit', 'AdministratorController@update');
        Route::get('/administrator/{id}/destroy', 'AdministratorController@destroy')->name('backend.administrator.destroy');
        // 角色
        Route::get('/administrator_role', 'AdministratorRoleController@index')->name('backend.administrator_role.index');
        Route::get('/administrator_role/create', 'AdministratorRoleController@create')->name('backend.administrator_role.create');
        Route::post('/administrator_role/create', 'AdministratorRoleController@store');
        Route::get('/administrator_role/{id}/edit', 'AdministratorRoleController@edit')->name('backend.administrator_role.edit');
        Route::put('/administrator_role/{id}/edit', 'AdministratorRoleController@update');
        Route::get('/administrator_role/{id}/destroy', 'AdministratorRoleController@destroy')->name('backend.administrator_role.destroy');
        Route::get('/administrator_role/{id}/permission', 'AdministratorRoleController@showSelectPermissionPage')->name('backend.administrator_role.permission');
        Route::post('/administrator_role/{id}/permission', 'AdministratorRoleController@handlePermissionSave');
        // 权限
        Route::get('/administrator_permission', 'AdministratorPermissionController@index')->name('backend.administrator_permission.index');
        Route::get('/administrator_permission/create', 'AdministratorPermissionController@create')->name('backend.administrator_permission.create');
        Route::post('/administrator_permission/create', 'AdministratorPermissionController@store');
        Route::get('/administrator_permission/{id}/edit', 'AdministratorPermissionController@edit')->name('backend.administrator_permission.edit');
        Route::put('/administrator_permission/{id}/edit', 'AdministratorPermissionController@update');
        Route::get('/administrator_permission/{id}/destroy', 'AdministratorPermissionController@destroy')->name('backend.administrator_permission.destroy');

        // 课程
        Route::get('/course', 'CourseController@index')->name('backend.course.index');
        Route::get('/course/create', 'CourseController@create')->name('backend.course.create');
        Route::post('/course/create', 'CourseController@store');
        Route::get('/course/{id}/edit', 'CourseController@edit')->name('backend.course.edit');
        Route::put('/course/{id}/edit', 'CourseController@update');
        Route::get('/course/{id}/delete', 'CourseController@destroy')->name('backend.course.destroy');
        // 视频
        Route::get('/video', 'CourseVideoController@index')->name('backend.video.index');
        Route::get('/video/create', 'CourseVideoController@create')->name('backend.video.create');
        Route::post('/video/create', 'CourseVideoController@store');
        Route::get('/video/{id}/edit', 'CourseVideoController@edit')->name('backend.video.edit');
        Route::put('/video/{id}/edit', 'CourseVideoController@update');
        Route::get('/video/{id}/delete', 'CourseVideoController@destroy')->name('backend.video.destroy');

        // 充值
        Route::get('/recharge', 'RechargeController@index')->name('backend.recharge');
        Route::get('/recharge/export', 'RechargeController@exportToExcel')->name('backend.recharge.export');

        // 订单
        Route::get('/orders', 'OrderController@index')->name('backend.orders');

        // 会员
        Route::get('/member', 'MemberController@index')->name('backend.member.index');
        Route::get('/member/{id}', 'MemberController@show')->name('backend.member.show');

        // 公告
        Route::get('/announcement', 'AnnouncementController@index')->name('backend.announcement.index');
        Route::get('/announcement/create', 'AnnouncementController@create')->name('backend.announcement.create');
        Route::post('/announcement/create', 'AnnouncementController@store');
        Route::get('/announcement/{id}/edit', 'AnnouncementController@edit')->name('backend.announcement.edit');
        Route::put('/announcement/{id}/edit', 'AnnouncementController@update');
        Route::get('/announcement/{id}/delete', 'AnnouncementController@destroy')->name('backend.announcement.destroy');

        // 用户角色
        Route::get('/role', 'RoleController@index')->name('backend.role.index');
        Route::get('/role/create', 'RoleController@create')->name('backend.role.create');
        Route::post('/role/create', 'RoleController@store');
        Route::get('/role/{id}/edit', 'RoleController@edit')->name('backend.role.edit');
        Route::put('/role/{id}/edit', 'RoleController@update');
        Route::get('/role/{id}/delete', 'RoleController@destroy')->name('backend.role.destroy');

        // 邮件群发
        Route::get('/subscription_email', 'SubscriptionController@create')->name('backend.subscription.email');
        Route::post('/subscription_email', 'SubscriptionController@store');

        // 配置
        Route::get('/setting', 'SettingController@index')->name('backend.setting.index');
        Route::post('/setting', 'SettingController@saveHandler');

        // FAQ分类
        Route::get('/faq/category', 'FaqCategoryController@index')->name('backend.faq.category.index');
        Route::get('/faq/category/create', 'FaqCategoryController@create')->name('backend.faq.category.create');
        Route::post('/faq/category/create', 'FaqCategoryController@store');
        Route::get('/faq/category/{id}/edit', 'FaqCategoryController@edit')->name('backend.faq.category.edit');
        Route::put('/faq/category/{id}/edit', 'FaqCategoryController@update');
        Route::get('/faq/category/{id}/delete', 'FaqCategoryController@destroy')->name('backend.faq.category.destroy');

        // FAQ文章
        Route::get('/faq/article', 'FaqArticleController@index')->name('backend.faq.article.index');
        Route::get('/faq/article/create', 'FaqArticleController@create')->name('backend.faq.article.create');
        Route::post('/faq/article/create', 'FaqArticleController@store');
        Route::get('/faq/article/{id}/edit', 'FaqArticleController@edit')->name('backend.faq.article.edit');
        Route::put('/faq/article/{id}/edit', 'FaqArticleController@update');
        Route::get('/faq/article/{id}/delete', 'FaqArticleController@destroy')->name('backend.faq.article.destroy');

        // 后台菜单
        Route::get('/administrator_menu', 'AdministratorMenuController@index')->name('backend.administrator_menu.index');
        Route::post('/administrator_menu/create', 'AdministratorMenuController@store')->name('backend.administrator_menu.create');
        Route::get('/administrator_menu/{id}/edit', 'AdministratorMenuController@edit')->name('backend.administrator_menu.edit');
        Route::put('/administrator_menu/{id}/edit', 'AdministratorMenuController@update');
        Route::get('/administrator_menu/{id}/delete', 'AdministratorMenuController@destroy')->name('backend.administrator_menu.destroy');
        Route::post('/administrator_menu/change/save', 'AdministratorMenuController@saveChange')->name('backend.administrator_menu.save_change');


        // 图书
        Route::get('/book', 'BookController@index')->name('backend.book.index');
        Route::get('/book/create', 'BookController@create')->name('backend.book.create');
        Route::post('/book/create', 'BookController@store');
        Route::get('/book/{id}/edit', 'BookController@edit')->name('backend.book.edit');
        Route::put('/book/{id}/edit', 'BookController@update');
        Route::get('/book/{id}/delete', 'BookController@destroy')->name('backend.book.destroy');

        // 图书章节
        Route::get('/book/{book_id}/chapter', 'BookChapterController@index')->name('backend.book.chapter.index');
        Route::get('/book/{book_id}/chapter/create', 'BookChapterController@create')->name('backend.book.chapter.create');
        Route::post('/book/{book_id}/chapter/create', 'BookChapterController@store');
        Route::get('/book/{book_id}/chapter/{chapter_id}/edit', 'BookChapterController@edit')->name('backend.book.chapter.edit');
        Route::put('/book/{book_id}/chapter/{chapter_id}/edit', 'BookChapterController@update');
        Route::get('/book/{book_id}/chapter/{chapter_id}/delete', 'BookChapterController@destroy')->name('backend.book.chapter.destroy');

        // 友情链接
        Route::get('/link', 'LinkController@index')->name('backend.link.index');
        Route::get('/link/create', 'LinkController@create')->name('backend.link.create');
        Route::post('/link/create', 'LinkController@store');
        Route::get('/link/{id}/edit', 'LinkController@edit')->name('backend.link.edit');
        Route::put('/link/{id}/edit', 'LinkController@update');
        Route::get('/link/{id}/delete', 'LinkController@destroy')->name('backend.link.destroy');

        // AdFrom
        Route::get('/adfrom', 'AdFromController@index')->name('backend.adfrom.index');
        Route::get('/adfrom/create', 'AdFromController@create')->name('backend.adfrom.create');
        Route::post('/adfrom/create', 'AdFromController@store');
        Route::get('/adfrom/{id}/edit', 'AdFromController@edit')->name('backend.adfrom.edit');
        Route::put('/adfrom/{id}/edit', 'AdFromController@update');
        Route::get('/adfrom/{id}/delete', 'AdFromController@destroy')->name('backend.adfrom.destroy');
        Route::get('/adfrom/{id}/number', 'AdFromController@number')->name('backend.adfrom.number');

        // 课程章节
        Route::get('/course/{course_id}/coursechapter', 'CourseChapterController@index')->name('backend.coursechapter.index');
        Route::get('/course/{course_id}/coursechapter/create', 'CourseChapterController@create')->name('backend.coursechapter.create');
        Route::post('/course/{course_id}/coursechapter/create', 'CourseChapterController@store');
        Route::get('/coursechapter/{id}/edit', 'CourseChapterController@edit')->name('backend.coursechapter.edit');
        Route::put('/coursechapter/{id}/edit', 'CourseChapterController@update');
        Route::get('/coursechapter/{id}/delete', 'CourseChapterController@destroy')->name('backend.coursechapter.destroy');
    });


    // Ajax
    Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function () {
        Route::get('/course/{course_id}/chapters', 'CourseController@chapters')->name('backend.ajax.course.chapters');
    });
});

