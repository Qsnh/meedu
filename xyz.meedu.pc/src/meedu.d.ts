declare global {
  interface ResponseInterface {
    data: any;
    code: number;
    message?: string;
  }

  interface AppFeatureInterface {
    vip: boolean;
  }

  interface AppConfigInterface {
    aboutus: string;
    credit1_reward: {
      register: number;
      watched_vod_course: number;
      watched_video: number;
      paid_order: string;
    };
    enabled_addons: string[];
    h5_url: string;
    icp: string;
    icp2: string;
    icp2_link: string;
    icp_link: string;
    logo: {
      logo: string;
      white_logo?: string;
    };
    member: {
      enabled_mobile_bind_alert: number;
      enabled_face_verify: boolean;
    };
    pc_url: string;
    player: {
      cover: string;
      enabled_bullet_secret: string;
      bullet_secret: {
        color: string;
        opacity: string;
        size: string;
        text: string;
      };
    };
    socialites: {
      qq: number;
      wechat_oauth: number;
    };
    url: string;
    user_private_protocol: string;
    user_protocol: string;
    webname: string;
  }

  interface UserDetailInterface {
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
    is_face_verify: boolean;
    is_lock: number;
    is_password_set: number;
    is_set_nickname: number;
    mobile: string;
    nick_name: string;
    profile_id_number: string;
    profile_real_name: string;
    role?: {
      id: number;
      name: string;
      desc_rows?: string[];
    };
    role_expired_at: null;
    role_id: number;
  }
}

export {};
