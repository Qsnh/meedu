import { useEffect } from "react";
import { Card, Row, Col } from "antd";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { titleAction } from "../../store/user/loginUserSlice";
import {
  DesktopOutlined,
  MobileOutlined,
  MenuOutlined,
  LinkOutlined,
} from "@ant-design/icons";
import styles from "./index.module.scss";

const DecorationIndexPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const user = useSelector((state: any) => state.loginUser.value.user);

  useEffect(() => {
    document.title = "装修管理";
    dispatch(titleAction("装修管理"));
  }, []);

  // 判断用户是否有 decorationPage 权限
  const hasDecorationPagePermission = () => {
    if (!user || !user.permissions) {
      return false;
    }
    return typeof user.permissions["decorationPage"] !== "undefined";
  };

  // 判断用户是否有 nav 权限
  const hasNavPermission = () => {
    if (!user || !user.permissions) {
      return false;
    }
    return typeof user.permissions["nav"] !== "undefined";
  };

  // 判断用户是否有 link 权限
  const hasLinkPermission = () => {
    if (!user || !user.permissions) {
      return false;
    }
    return typeof user.permissions["link"] !== "undefined";
  };

  const platforms = [
    {
      key: "pc",
      title: "电脑端首页",
      description: "管理PC端首页的页面装修",
      icon: <DesktopOutlined style={{ fontSize: 48, color: "#1890ff" }} />,
      path: "/decoration/pc/pages",
    },
    {
      key: "h5",
      title: "手机端首页",
      description: "管理H5手机端首页的页面装修",
      icon: <MobileOutlined style={{ fontSize: 48, color: "#52c41a" }} />,
      path: "/decoration/h5/pages",
    },
    {
      key: "nav",
      title: "导航管理",
      description: "管理PC端全局导航菜单",
      icon: <MenuOutlined style={{ fontSize: 48, color: "#fa8c16" }} />,
      path: "/decoration/nav",
    },
    {
      key: "links",
      title: "友情链接",
      description: "管理PC端友情链接",
      icon: <LinkOutlined style={{ fontSize: 48, color: "#722ed1" }} />,
      path: "/decoration/links",
    },
  ];

  return (
    <div className="meedu-main-body">
      <div className="float-left">
        <Row gutter={[24, 24]}>
          {platforms.map((platform) => {
            // 如果是电脑端首页或手机端首页卡片，检查 decorationPage 权限
            if ((platform.key === "pc" || platform.key === "h5") && !hasDecorationPagePermission()) {
              return null;
            }

            // 如果是导航管理卡片，检查用户权限
            if (platform.key === "nav" && !hasNavPermission()) {
              return null;
            }

            // 如果是友情链接卡片，检查用户权限
            if (platform.key === "links" && !hasLinkPermission()) {
              return null;
            }

            return (
              <Col xs={24} sm={12} md={8} lg={6} key={platform.key}>
                <Card
                  hoverable
                  className={styles["platform-card"]}
                  onClick={() => navigate(platform.path)}
                >
                  <div className={styles["card-content"]}>
                    <div className={styles["icon-wrapper"]}>{platform.icon}</div>
                    <div className={styles["title"]}>{platform.title}</div>
                    <div className={styles["description"]}>
                      {platform.description}
                    </div>
                  </div>
                </Card>
              </Col>
            );
          })}
        </Row>
      </div>
    </div>
  );
};

export default DecorationIndexPage;
