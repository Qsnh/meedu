declare global {
  interface VideoParseInfo {
    poster: string;
    duration: number;
  }

  interface IApiResponse<T> {
    status: number;
    message: string;
    data: T;
  }

  interface MIAdministrator {
    id: number;
    name: string;
    email: string;
    last_login_ip: string;
    last_login_date: string;
    created_at: string;
    updated_at: string;
    is_ban_login: number;
    login_times: number;
    permissions: Record<string, number>;
    role_id: number[];
    is_super: boolean;
    roles: {
      id: number;
      display_name: string;
      slug: string;
      description: string;
      created_at: string;
      updated_at: string;
      permission_ids: number[];
      pivot: {
        administrator_id: number;
        role_id: number;
      };
    }[];
  }

  interface CourseDetail {
    id: number;
    user_id: number;
    title: string;
    slug: string;
    thumb: string;
    charge: number;
    short_description: string;
    original_desc: string;
    render_desc: string;
    seo_keywords: string;
    seo_description: string;
    published_at: string;
    is_show: number;
    created_at: string;
    updated_at: string;
    category_id: number;
    is_rec: number;
    user_count: number;
    is_free: number;
    is_allow_comment: number;
    is_vip_free: number;
  }

  interface CourseDetailResponse extends IApiResponse<CourseDetail> {}

  interface CourseCategory {
    id: number;
    name: string;
    sort: number;
    parent_id?: number;
  }

  interface CourseCategoryWithChildren {
    id: number;
    name: string;
    sort: number;
    children: CourseCategory[];
  }

  interface CourseCreateData {
    categories: CourseCategoryWithChildren[];
  }

  interface CourseCreateResponse extends IApiResponse<CourseCreateData> {}

  interface CourseFormData {
    category_id: number;
    title: string;
    thumb: string;
    is_show: number;
    is_free: number;
    is_vip_free: number;
    short_description: string;
    original_desc: string;
    render_desc: string;
    charge: number;
    published_at: string;
    is_allow_comment: number;
  }

  interface CategoryOption {
    label: string;
    value: number;
  }
}

export {};
