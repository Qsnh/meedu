import { useEffect } from "react";
import styles from "./setting.module.scss";
import { useSelector } from "react-redux";
import NavHeader from "../../components/nav-header";
import { Copyright } from "../../components";
import { RootState } from "../../store";
import { AppConfigInterface } from "../../store/system/systemConfigSlice";

const MemberSettingPage = () => {
  const config: AppConfigInterface = useSelector(
    (state: RootState) => state.systemConfig.value
  );

  useEffect(() => {
    document.title = "关于平台";
  }, []);

  const openPage = (url: string) => {
    window.open(url);
  };

  return (
    <div className={styles["container"]}>
      <NavHeader text="关于平台" />
      <div className={styles["group-box"]}>
        <div
          className={styles["group-item"]}
          onClick={() => openPage(config.user_protocol)}
        >
          <div className={styles["name"]}>用户协议</div>
        </div>
        <div
          className={styles["group-item"]}
          onClick={() => openPage(config.user_private_protocol)}
        >
          <div className={styles["name"]}>隐私政策</div>
        </div>
        <div
          className={styles["group-item"]}
          onClick={() => openPage(config.vip_protocol)}
        >
          <div className={styles["name"]}>会员服务协议</div>
        </div>
        <div
          className={styles["group-item"]}
          onClick={() => openPage(config.aboutus)}
        >
          <div className={styles["name"]}>关于我们</div>
        </div>
      </div>
      <Copyright />
    </div>
  );
};

export default MemberSettingPage;
