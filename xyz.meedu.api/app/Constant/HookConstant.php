<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Constant;

class HookConstant
{

    public const BACKEND_ORDER_CONTROLLER_INDEX_RETURN_DATA = 'backend_order_controller_index_return_data';
    public const BACKEND_ORDER_CONTROLLER_INDEX_QUERY_BUILDER = 'backend_order_controller_index_query_builder';
    public const BACKEND_ORDER_CONTROLLER_DETAIL_RETURN_DATA = 'backend_order_controller_detail_return_data';

    public const BACKEND_MEMBER_CONTROLLER_INDEX_RETURN_DATA = 'backend_member_controller_index_return_data';
    public const BACKEND_COURSE_CONTROLLER_INDEX_RETURN_DATA = 'backend_course_controller_index_return_data';
    public const BACKEND_COURSE_CONTROLLER_CREATE_RETURN_DATA = 'backend_course_controller_create_return_data';
    public const BACKEND_COURSE_CONTROLLER_EDIT_RETURN_DATA = 'backend_course_controller_edit_return_data';
    public const BACKEND_COURSE_CONTROLLER_STORE_SUCCESS = 'backend_course_controller_store_success';
    public const BACKEND_COURSE_CONTROLLER_UPDATE_SUCCESS = 'backend_course_controller_update_success';
    public const BACKEND_COURSE_CONTROLLER_DESTROY_SUCCESS = 'backend_course_controller_destroy_success';

    public const BACKEND_COURSE_VIDEO_CONTROLLER_INDEX_RETURN_DATA = 'backend_course_video_controller_index_return_data';
    public const BACKEND_COURSE_VIDEO_CONTROLLER_CREATE_RETURN_DATA = 'backend_course_video_controller_create_return_data';
    public const BACKEND_COURSE_VIDEO_CONTROLLER_STORE_SUCCESS = 'backend_course_video_controller_store_success';
    public const BACKEND_COURSE_VIDEO_CONTROLLER_UPDATE_SUCCESS = 'backend_course_video_controller_update_success';
    public const BACKEND_COURSE_VIDEO_CONTROLLER_DESTROY_SUCCESS = 'backend_course_video_controller_destroy_success';

    public const BACKEND_MEDIA_VIDEO_CONTROLLER_INDEX_RETURN_DATA = 'backend_media_video_controller_index_return_data';

    public const FRONTEND_OTHER_CONTROLLER_CONFIG_RETURN_DATA = 'frontend_other_controller_config_return_data';
}
