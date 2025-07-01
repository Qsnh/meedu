declare global {
  interface LinksInterface {
    created_at: string;
    id: number;
    name: string;
    sort: number;
    updated_at: string;
    url: string;
  }

  interface NavsInterface {
    active_routes: string;
    blank: number;
    children: any[];
    id: number;
    name: string;
    parent_id: number;
    platform: string;
    sort: number;
    url: string;
  }

  interface SlidersInterface {
    created_at: string;
    deleted_at?: string;
    id: number;
    platform: string;
    sort: number;
    thumb: string;
    updated_at: string;
    url: string;
  }

  interface BlocksInterface {
    config: string;
    config_render: any;
    id: number;
    page: string;
    platform: string;
    sign: string;
    sort: number;
  }

  interface UserModel {
    avatar: string;
    created_at: string;
    credit1: number;
    credit2: number;
    credit3: number;
    id: number;
    invite_balance: number;
    invite_people_count: number;
    is_active: number;
    is_bind_mobile: number;
    is_bind_qq: number;
    is_bind_wechat: number;
    is_face_verify: false;
    is_lock: number;
    is_password_set: number;
    is_set_nickname: number;
    mobile: string;
    nick_name: string;
    profile_id_number: string;
    profile_real_name: string;
    role: any;
    role_expired_at: any;
    role_id: number;
  }

  interface CourseDetailInterface {
    category_id: number;
    charge: number;
    id: number;
    is_free: number;
    is_rec: number;
    is_show: number;
    published_at: string;
    render_desc: string;
    seo_description: string;
    seo_keywords: string;
    short_description: string;
    slug: string;
    thumb: string;
    title: string;
    user_count: number;
    is_allow_comment: number;
    is_vip_free: number;
  }

  interface CourseDetailChapterInterface {
    course_id: number;
    id: number;
    title: string;
  }

  interface CourseDetailVideosInterface {
    [key: number]: CourseDetailVideoInterface[];
  }
}

export {};
