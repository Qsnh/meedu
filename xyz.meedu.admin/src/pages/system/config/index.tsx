import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { titleAction } from "../../../store/user/loginUserSlice";
import systemIcon from "../../../assets/images/config/system.png";
import paymentIocn from "../../../assets/images/config/payment.png";
import roleIcon from "../../../assets/images/config/role.png";
import loginIcon from "../../../assets/images/config/login.png";
import wechatIcon from "../../../assets/images/config/wechat.png";
import messageIcon from "../../../assets/images/config/message.png";
import videoIocn from "../../../assets/images/config/video.png";
import picIcon from "../../../assets/images/config/pic.png";
import aliIcon from "../../../assets/images/config/ali.png";
import cameraIcon from "../../../assets/images/config/camera.png";
import k12Icon from "../../../assets/images/config/k12.png";
import searchIcon from "../../../assets/images/config/search.png";
import importIcon from "../../../assets/images/config/import.png";
import h5Icon from "../../../assets/images/config/h5.png";
import weixinIcon from "../../../assets/images/config/weixin.png";
import playerIcon from "../../../assets/images/config/player.png";
import liveIcon from "../../../assets/images/config/live.png";
import bookIcon from "../../../assets/images/config/book.png";
import topicIcon from "../../../assets/images/config/topic.png";
import wendaIcon from "../../../assets/images/config/wenda.png";
import sendvipIcon from "../../../assets/images/config/sendvip.png";
import multishareIcon from "../../../assets/images/config/multishare.png";
import tgIcon from "../../../assets/images/config/tg.png";
import credictIcon from "../../../assets/images/config/credict.png";

const SystemConfigPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const enabledAddons = useSelector(
    (state: any) => state.enabledAddonsConfig.value.enabledAddons
  );
  const groups = [
    {
      name: "网站信息",
      value: "系统",
      images: systemIcon,
      sign: "",
    },
    {
      name: "支付配置",
      value: "支付",
      images: paymentIocn,
      sign: "",
    },
    {
      name: "用户注册",
      value: "会员",
      images: roleIcon,
      sign: "",
    },
    {
      name: "登录控制",
      value: "登录",
      images: loginIcon,
      sign: "",
    },
    {
      name: "微信公众号",
      value: "微信公众号",
      images: wechatIcon,
      sign: "",
    },
    {
      name: "短信服务",
      value: "短信",
      images: messageIcon,
      sign: "",
    },
    {
      name: "视频存储",
      value: "视频",
      images: videoIocn,
      sign: "",
    },
    {
      name: "图片存储",
      value: "图片存储",
      images: picIcon,
      sign: "",
    },
    {
      name: "全局搜索",
      value: "全文搜索",
      images: searchIcon,
      sign: "",
    },
    {
      name: "插件配置",
      value: "插件配置",
      images: importIcon,
      sign: "",
    },
    {
      name: "实名认证",
      value: "微信实名认证",
      images: roleIcon,
      sign: "",
    },
  ];
  const courses = [
    {
      name: "播放器配置",
      value: "播放器配置",
      images: playerIcon,
      sign: "",
    },
  ];
  const market = [
    {
      name: "注册送会员",
      value: "注册送VIP",
      images: sendvipIcon,
      sign: "",
    },
    {
      name: "积分配置",
      value: "积分",
      images: credictIcon,
      sign: "",
    },
  ];

  useEffect(() => {
    document.title = "系统配置";
    dispatch(titleAction("系统配置"));
  }, []);

  const check = (sign: string) => {
    if (
      sign === "视频加密" &&
      (enabledAddons["AliyunHls"] === 1 ||
        enabledAddons["TencentCloudHls"] === 1)
    ) {
      return true;
    } else if (enabledAddons[sign] === 1 || sign === "") {
      return true;
    } else {
      return false;
    }
  };

  const goConfig = (value: string) => {
    if (value === "播放器配置") {
      navigate("/system/playerConfig");
    } else if (value === "积分") {
      navigate("/system/creditSignConfig");
    } else if (value === "短信") {
      navigate("/system/messageConfig");
    } else if (value === "图片存储") {
      navigate("/system/saveImagesConfig");
    } else if (value === "微信公众号") {
      navigate("/system/mp_wechatConfig");
    } else if (value === "支付") {
      navigate("/system/paymentConfig");
    } else if (value === "视频") {
      navigate("/system/videoSaveConfig");
    } else {
      navigate("/system/config?key=" + value);
    }
  };

  return (
    <div className={styles["config-box"]}>
      <div className={styles["options"]}>
        <div className={styles["title"]}>基本配置</div>
        <div className={styles["body"]}>
          {groups.map((item: any, index: number) => {
            return (
              check(item.sign) && (
                <div
                  key={index}
                  className={styles["item"]}
                  onClick={() => goConfig(item.value)}
                >
                  <img src={item.images} />
                  <span>{item.name}</span>
                </div>
              )
            );
          })}
        </div>
      </div>
      <div className={styles["options"]}>
        <div className={styles["title"]}>课程配置</div>
        <div className={styles["body"]}>
          {courses.map((item: any, index: number) => {
            return (
              (enabledAddons[item.sign] === 1 || item.sign === "") && (
                <div
                  key={index}
                  className={styles["item"]}
                  onClick={() => goConfig(item.value)}
                >
                  <img src={item.images} />
                  <span>{item.name}</span>
                </div>
              )
            );
          })}
        </div>
      </div>
      <div className={styles["options"]}>
        <div className={styles["title"]}>营销配置</div>
        <div className={styles["body"]}>
          {market.map((item: any, index: number) => {
            return (
              (enabledAddons[item.sign] === 1 || item.sign === "") && (
                <div
                  key={index}
                  className={styles["item"]}
                  onClick={() => goConfig(item.value)}
                >
                  <img src={item.images} />
                  <span>{item.name}</span>
                </div>
              )
            );
          })}
        </div>
      </div>
    </div>
  );
};

export default SystemConfigPage;
