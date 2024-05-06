import React from "react";
import { TabBar } from "antd-mobile";
import styles from "./index.module.scss";
import { useNavigate, useLocation } from "react-router-dom";
import index from "../../assets/img/icon-home-h@2x.png";
import noIndex from "../../assets/img/icon-home-n@2x.png";
import study from "../../assets/img/icon-study-h@2x.png";
import noStudy from "../../assets/img/icon-study-n@2x.png";
import me from "../../assets/img/icon-me-h@2x.png";
import noMe from "../../assets/img/icon-me-n@2x.png";

export const TabBarFooter: React.FC = () => {
  const navigate = useNavigate();
  const location = useLocation();
  const { pathname } = location;

  const tabs = [
    {
      key: "/",
      title: "首页",
      icon: (active: boolean) =>
        active ? (
          <img style={{ width: 28, height: 28 }} src={index} />
        ) : (
          <img style={{ width: 28, height: 28 }} src={noIndex} />
        ),
    },
    {
      key: "/study",
      title: "在学",
      icon: (active: boolean) =>
        active ? (
          <img style={{ width: 28, height: 28 }} src={study} />
        ) : (
          <img style={{ width: 28, height: 28 }} src={noStudy} />
        ),
    },
    {
      key: "/member",
      title: "我的",
      icon: (active: boolean) =>
        active ? (
          <img style={{ width: 28, height: 28 }} src={me} />
        ) : (
          <img style={{ width: 28, height: 28 }} src={noMe} />
        ),
    },
  ];

  return (
    <div className={styles["footer"]}>
      <TabBar
        activeKey={pathname}
        onChange={(value) => navigate(value, { replace: true })}
      >
        {tabs.map((item) => (
          <TabBar.Item key={item.key} icon={item.icon} title={item.title} />
        ))}
      </TabBar>
    </div>
  );
};
