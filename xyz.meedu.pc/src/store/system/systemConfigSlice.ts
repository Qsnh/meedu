import { createSlice } from "@reduxjs/toolkit";

// 完善系统配置数据结构类型
interface SystemConfig {
  name: string;
  webname?: string; // 网站名称，可选字段
  logo: {
    logo: string;
    white_logo: Record<string, any>;
  };
  url: string;
  pc_url: string;
  h5_url: string;
  icp: string;
  icp_link: string;
  icp2: string;
  icp2_link: string;
  user_protocol: string;
  user_private_protocol: string;
  vip_protocol: string;
  aboutus: string;
  course_purchase_notice: string;
  player: {
    cover: string;
    enabled_bullet_secret: string;
    bullet_secret: {
      size: string;
      color: string;
      opacity: string;
      text: string;
    };
  };
  member: {
    enabled_mobile_bind_alert: number;
    enabled_face_verify: boolean;
  };
  socialites: {
    qq: number;
    wechat_oauth: number;
  };
  credit1_reward: {
    register: number;
    watched_vod_course: number;
    watched_video: number;
    paid_order: string;
  };
  enabled_addons: any[];
  sliders: any[];
  navs: NavItem[];
  links: LinkItem[];
}

interface NavItem {
  id: number;
  sort: number;
  name: string;
  url: string;
  active_routes: string;
  platform: string;
  parent_id: number;
  blank: number;
  children: NavItem[];
}

interface LinkItem {
  id: number;
  sort: number;
  name: string;
  url: string;
  created_at: string;
  updated_at: string;
}

type SystemConfigStoreInterface = {
  config: SystemConfig | null;
  configFunc: {
    vip: boolean;
    live: boolean;
    book: boolean;
    topic: boolean;
    paper: boolean;
    practice: boolean;
    mockPaper: boolean;
    wrongBook: boolean;
    wenda: boolean;
    share: boolean;
    codeExchanger: boolean;
    snapshort: boolean;
    ke: boolean;
    promoCode: boolean;
    daySignIn: boolean;
    credit1Mall: boolean;
    tuangou: boolean;
    miaosha: boolean;
    cert: boolean;
  };
};

let defaultValue: SystemConfigStoreInterface = {
  config: null,
  configFunc: {
    vip: true,
    live: false,
    book: false,
    topic: false,
    paper: false,
    practice: false,
    mockPaper: false,
    wrongBook: false,
    wenda: false,
    share: false,
    codeExchanger: false,
    snapshort: false,
    ke: false,
    promoCode: false,
    daySignIn: false,
    credit1Mall: false,
    tuangou: false,
    miaosha: false,
    cert: false,
  },
};

const systemConfigSlice = createSlice({
  name: "systemConfig",
  initialState: {
    value: defaultValue,
  },
  reducers: {
    saveConfigAction(stage, e) {
      stage.value.config = e.payload;
    },
    saveConfigFuncAction(stage, e) {
      stage.value.configFunc = e.payload;
    },
  },
});

export default systemConfigSlice.reducer;
export const { saveConfigAction, saveConfigFuncAction } =
  systemConfigSlice.actions;

export type { SystemConfigStoreInterface, SystemConfig, NavItem, LinkItem };
