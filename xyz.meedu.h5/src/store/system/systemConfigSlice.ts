import { createSlice } from "@reduxjs/toolkit";

type LinksInterface = {
  id: number;
  sort: number;
  name: string;
  url: string;
  created_at: string;
  updated_at: string;
};

type NavsInterface = {
  id: number;
  sort: number;
  name: string;
  url: string;
  active_routes: string;
  platform: string;
  parent_id: number;
  blank: number;
  children: NavsInterface[];
};

type AppConfigInterface = {
  aboutus: string;
  course_purchase_notice: string;
  credit1_reward: {
    paid_order: string;
    register: number;
    watched_video: number;
    watched_vod_course: number;
  };
  enabled_addons: {
    [key: number]: string;
  };
  h5_url: string;
  icp: string;
  icp2: string;
  icp2_link: string;
  icp_link: string;
  links: LinksInterface[];
  logo: {
    logo: string;
    white_logo?: string;
  };
  member: {
    enabled_face_verify: boolean;
    enabled_mobile_bind_alert: number;
  };
  name: string;
  navs: NavsInterface[];
  pc_url: string;
  player: {
    bullet_secret: {
      color: string;
      opacity: string;
      size: string;
      text: string;
    };
    cover: string;
    enabled_bullet_secret: string;
  };
  sliders: any[];
  socialites: {
    qq: number;
    wechat_oauth: number;
  };
  url: string;
  user_private_protocol: string;
  user_protocol: string;
  vip_protocol: string;
  paid_content_purchase_protocol: string;
  webname?: string;
};

let defaultValue: AppConfigInterface = {
  aboutus: "",
  course_purchase_notice: "",
  credit1_reward: {
    paid_order: "",
    register: 0,
    watched_video: 0,
    watched_vod_course: 0,
  },
  enabled_addons: [],
  h5_url: "",
  icp: "",
  icp2: "",
  icp2_link: "",
  icp_link: "",
  links: [],
  logo: {
    logo: "",
    white_logo: "",
  },
  member: {
    enabled_face_verify: false,
    enabled_mobile_bind_alert: 0,
  },
  name: "",
  navs: [],
  pc_url: "",
  player: {
    bullet_secret: {
      color: "",
      opacity: "",
      size: "",
      text: "",
    },
    cover: "",
    enabled_bullet_secret: "",
  },
  sliders: [],
  socialites: {
    qq: 0,
    wechat_oauth: 0,
  },
  url: "",
  user_private_protocol: "",
  user_protocol: "",
  vip_protocol: "",
  paid_content_purchase_protocol: "",
};

const systemConfigSlice = createSlice({
  name: "systemConfig",
  initialState: {
    value: defaultValue,
  },
  reducers: {
    saveConfigAction(stage, e) {
      stage.value = e.payload;
    },
  },
});

export default systemConfigSlice.reducer;
export const { saveConfigAction } = systemConfigSlice.actions;

export type { AppConfigInterface, LinksInterface, NavsInterface };
