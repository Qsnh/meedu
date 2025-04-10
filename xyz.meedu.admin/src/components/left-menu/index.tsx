import React, { useEffect, useState } from "react";
import { Menu } from "antd";
import { useSelector } from "react-redux";
import { useNavigate, useLocation } from "react-router-dom";
import styles from "./index.module.scss";
import logo from "../../assets/home/logo.png";
import "../../assets/common/iconfont/iconfont.css";

function getItem(
  label: any,
  key: any,
  icon: any,
  children: any,
  type: any,
  permission: any
) {
  return {
    key,
    icon,
    children,
    label,
    type,
    permission,
  };
}
const items = [
  getItem(
    "主页",
    "/",
    <i className={`iconfont icon-icon-study-n`} />,
    null,
    null,
    "dashboard"
  ),
  getItem(
    "装修",
    "decoration",
    <i className="iconfont icon-icon-decorate" />,
    [
      getItem("电脑端", "/decoration/pc", null, null, null, "viewBlock"),
      getItem("移动端", "/decoration/h5", null, null, null, "viewBlock"),
    ],
    null,
    null
  ),
  getItem(
    "资源",
    "resource",
    <i className="iconfont icon-icon-file" />,
    [
      getItem(
        "图片库",
        "/resource/images/index",
        null,
        null,
        null,
        "media.image.index"
      ),
      getItem(
        "视频库",
        "/resource/videos/index",
        null,
        null,
        null,
        "media.video.list"
      ),
    ],
    null,
    null
  ),
  getItem(
    "课程",
    "courses",
    <i className="iconfont icon-icon-lesson" />,
    [getItem("录播课", "/course/vod/index", null, null, null, "course")],
    null,
    null
  ),
  getItem(
    "学员",
    "user",
    <i className="iconfont icon-icon-me-n" />,
    [getItem("学员列表", "/member/index", null, null, null, "member")],
    null,
    null
  ),
  getItem(
    "财务",
    "finance",
    <i className="iconfont icon-icon-money-n" />,
    [getItem("全部订单", "/order/index", null, null, null, "order")],
    null,
    null
  ),
  getItem(
    "运营",
    "operate",
    <i className="iconfont icon-icon-operate" />,
    [
      getItem("课程评论", "/comments/index", null, null, null, "comment.index"),
      getItem("VIP会员", "/role", null, null, null, "role"),
      getItem("优惠码", "/promocode", null, null, null, "promoCode"),
    ],
    null,
    null
  ),
  getItem(
    "数据",
    "stats",
    <i className="iconfont icon-icon-data-n" />,
    [
      getItem(
        "交易数据",
        "/stats/transaction/index",
        null,
        null,
        null,
        "stats.transaction"
      ),
      getItem(
        "商品数据",
        "/stats/content/index",
        null,
        null,
        null,
        "stats.course"
      ),
      getItem(
        "学员数据",
        "/stats/member/index",
        null,
        null,
        null,
        "stats.user"
      ),
    ],
    null,
    null
  ),
  getItem(
    "系统",
    "system",
    <i className="iconfont icon-icon-setting-n" />,
    [
      getItem(
        "管理人员",
        "/system/administrator",
        null,
        null,
        null,
        "administrator"
      ),
      getItem("系统配置", "/system/index", null, null, null, "setting"),
      getItem(
        "系统日志",
        "/systemLog/index",
        null,
        null,
        null,
        "system.audit.log"
      ),
      getItem(
        "功能模块",
        "/system/application",
        null,
        null,
        null,
        "super-slug"
      ),
    ],
    null,
    null
  ),
];

export const LeftMenu: React.FC = () => {
  const location = useLocation();
  const navigate = useNavigate();
  const user = useSelector((state: any) => state.loginUser.value.user);
  const children2Parent: any = {
    "^/role": ["operate"],
    "^/promocode": ["operate"],
    "^/wechat": ["operate"],
    "^/stats": ["stats"],
    "^/member": ["user"],
    "^/order": ["finance"],
    "^/decoration": ["decoration"],
    "^/course": ["courses"],
    "^/system": ["system"],
    "^/systemLog": ["system"],
    "^/resource": ["resource"],
    "^/comments": ["comments"],
  };

  const hit = (pathname: string): string[] => {
    for (let p in children2Parent) {
      if (pathname.search(p) >= 0) {
        return children2Parent[p];
      }
    }
    return [];
  };

  const openKeyMerge = (pathname: string): string[] => {
    let newOpenKeys = hit(pathname);
    for (let i = 0; i < openKeys.length; i++) {
      let isIn = false;
      for (let j = 0; j < newOpenKeys.length; j++) {
        if (newOpenKeys[j] === openKeys[i]) {
          isIn = true;
          break;
        }
      }
      if (isIn) {
        continue;
      }
      newOpenKeys.push(openKeys[i]);
    }
    return newOpenKeys;
  };

  // 选中的菜单
  const [selectedKeys, setSelectedKeys] = useState<string[]>([
    location.pathname,
  ]);
  // 展开菜单
  const [openKeys, setOpenKeys] = useState<string[]>(hit(location.pathname));
  const [activeMenus, setActiveMenus] = useState<any>([]);

  const onClick = (e: any) => {
    navigate(e.key);
  };

  useEffect(() => {
    if (location.pathname.indexOf("/course/vod") !== -1) {
      setSelectedKeys(["/course/vod/index"]);
      setOpenKeys(openKeyMerge("/course"));
    } else if (location.pathname.indexOf("/system/topicConfig") !== -1) {
      setSelectedKeys(["/system/index"]);
      setOpenKeys(openKeyMerge("/system"));
    } else if (location.pathname.indexOf("/comments/index") !== -1) {
      setSelectedKeys(["/comments/index"]);
      setOpenKeys(openKeyMerge("/comments"));
    } else if (location.pathname.indexOf("/stats/member/index") !== -1) {
      setSelectedKeys(["/stats/member/index"]);
      setOpenKeys(openKeyMerge("/stats"));
    } else if (location.pathname.indexOf("/member/") !== -1) {
      setSelectedKeys(["/member/index"]);
      setOpenKeys(openKeyMerge("/member"));
    } else if (location.pathname.indexOf("/order/code-import") !== -1) {
      setSelectedKeys(["/promocode"]);
      setOpenKeys(openKeyMerge("/promocode"));
    } else if (location.pathname.indexOf("/order/recharge") !== -1) {
      setSelectedKeys(["/order/recharge"]);
      setOpenKeys(openKeyMerge("/order"));
    } else if (location.pathname.indexOf("/order") !== -1) {
      setSelectedKeys(["/order/index"]);
      setOpenKeys(openKeyMerge("/order"));
    } else if (location.pathname.indexOf("/withdrawOrders") !== -1) {
      setSelectedKeys(["/withdrawOrders"]);
      setOpenKeys(openKeyMerge("/order"));
    } else if (location.pathname.indexOf("/role") !== -1) {
      setSelectedKeys(["/role"]);
      setOpenKeys(openKeyMerge("/role"));
    } else if (location.pathname.indexOf("/addrole") !== -1) {
      setSelectedKeys(["/role"]);
      setOpenKeys(openKeyMerge("/role"));
    } else if (location.pathname.indexOf("/editrole") !== -1) {
      setSelectedKeys(["/role"]);
      setOpenKeys(openKeyMerge("/role"));
    } else if (location.pathname.indexOf("/promocode") !== -1) {
      setSelectedKeys(["/promocode"]);
      setOpenKeys(openKeyMerge("/promocode"));
    } else if (location.pathname.indexOf("/createcode") !== -1) {
      setSelectedKeys(["/promocode"]);
      setOpenKeys(openKeyMerge("/promocode"));
    } else if (location.pathname.indexOf("/createmulticode") !== -1) {
      setSelectedKeys(["/promocode"]);
      setOpenKeys(openKeyMerge("/promocode"));
    } else if (location.pathname.indexOf("/wechat/messagereply") !== -1) {
      setSelectedKeys(["/wechat/messagereply/index"]);
      setOpenKeys(openKeyMerge("/wechat"));
    } else if (location.pathname.indexOf("/wechat/mp-wechat-menu") !== -1) {
      setSelectedKeys(["/wechat/messagereply/index"]);
      setOpenKeys(openKeyMerge("/wechat"));
    } else if (location.pathname.indexOf("/system/administrator") !== -1) {
      setSelectedKeys(["/system/administrator"]);
      setOpenKeys(openKeyMerge("/system"));
    } else if (location.pathname.indexOf("/system/adminroles") !== -1) {
      setSelectedKeys(["/system/administrator"]);
      setOpenKeys(openKeyMerge("/system"));
    } else if (location.pathname.indexOf("/systemLog/index") !== -1) {
      setSelectedKeys(["/systemLog/index"]);
      setOpenKeys(openKeyMerge("/systemLog"));
    } else if (location.pathname.indexOf("/system/application") !== -1) {
      setSelectedKeys(["/system/application"]);
      setOpenKeys(openKeyMerge("/system"));
    } else if (location.pathname.indexOf("/system") !== -1) {
      setSelectedKeys(["/system/index"]);
      setOpenKeys(openKeyMerge("/system"));
    } else {
      setSelectedKeys([location.pathname]);
      setOpenKeys(openKeyMerge(location.pathname));
    }
  }, [location.pathname]);

  useEffect(() => {
    checkMenuPermissions(items, user);
  }, [items, user]);

  const checkMenuPermissions = (items: any, user: any) => {
    let menus: any = [];
    if (!user) {
      setActiveMenus(menus);
      return;
    }

    for (let i in items) {
      let menuItem = items[i];
      if (!menuItem.children) {
        // 一级菜单不做权限控制
        if (typeof user.permissions[menuItem.permission] !== "undefined") {
          // 存在权限
          menus.push(menuItem);
        }

        continue;
      }
      let children = [];

      for (let j in menuItem.children) {
        let childrenItem = menuItem.children[j];

        if (childrenItem.permission === "super-slug") {
          // 超管判断
          if (user.is_super) {
            children.push(childrenItem);
          }
          continue;
        }

        if (typeof user.permissions[childrenItem.permission] !== "undefined") {
          // 存在权限
          children.push(childrenItem);
        }
      }

      if (children.length > 0) {
        menus.push(Object.assign({}, menuItem, { children: children }));
      }
    }
    setActiveMenus(menus);
  };

  return (
    <div className={styles["left-menu"]}>
      <div
        style={{
          textDecoration: "none",
          position: "sticky",
          top: 0,
          height: 56,
          zIndex: 10,
          background: "#fff",
        }}
      >
        <img
          src={logo}
          className={styles["App-logo"]}
          onClick={() => {
            window.location.href = "/";
          }}
        />
      </div>
      <div className={styles["menu-box"]}>
        <Menu
          onClick={onClick}
          style={{
            width: 200,
            background: "#ffffff",
            textAlign: "left",
          }}
          selectedKeys={selectedKeys}
          openKeys={openKeys}
          mode="inline"
          items={activeMenus}
          onSelect={(data: any) => {
            setSelectedKeys(data.selectedKeys);
          }}
          onOpenChange={(keys: any) => {
            setOpenKeys(keys);
          }}
        />
      </div>
    </div>
  );
};
