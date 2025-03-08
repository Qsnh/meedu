import { PermissionPath } from "../types/permission";

// 权限路径配置，按照左侧菜单顺序排列
export const PERMISSION_CONFIG: PermissionPath[] = [
  {
    permission: "dashboard",
    path: "/",
    title: "主页",
  },
  {
    permission: "viewBlock",
    path: "/decoration/pc",
    title: "装修",
  },
  {
    permission: "media.image.index",
    path: "/resource/images/index",
    title: "图片库",
  },
  {
    permission: "media.video.list",
    path: "/resource/videos/index",
    title: "视频库",
  },
  {
    permission: "course",
    path: "/course/vod/index",
    title: "录播课",
  },
  {
    permission: "member",
    path: "/member/index",
    title: "学员列表",
  },
  {
    permission: "order",
    path: "/order/index",
    title: "全部订单",
  },
  {
    permission: "role",
    path: "/role",
    title: "VIP会员",
  },
  {
    permission: "promoCode",
    path: "/promocode",
    title: "优惠码",
  },
  {
    permission: "stats.transaction",
    path: "/stats/transaction/index",
    title: "交易数据",
  },
  {
    permission: "stats.course",
    path: "/stats/content/index",
    title: "商品数据",
  },
  {
    permission: "stats.user",
    path: "/stats/member/index",
    title: "学员数据",
  },
  {
    permission: "administrator",
    path: "/system/administrator",
    title: "管理人员",
  },
  {
    permission: "setting",
    path: "/system/index",
    title: "系统配置",
  },
  {
    permission: "system.audit.log",
    path: "/systemLog/index",
    title: "系统日志",
  },
];
