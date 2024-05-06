import { useEffect, useState } from "react";
import { Image } from "antd-mobile";
import { useNavigate } from "react-router-dom";
import { user as member } from "../../api/index";
import { TechSupport } from "../../components";
import styles from "./index.module.scss";
import { useSelector } from "react-redux";
import backIcon from "../../assets/img/new/back.png";
import defaultAvatar from "../../assets/img/default_avatar.png";
import settingIcon from "../../assets/img/new/setting.png";
import mesIcon from "../../assets/img/new/message.png";
import orderIcon from "../../assets/img/new/order.png";
import vipIcon from "../../assets/img/new/VIP.png";
import bannerIcon from "../../assets/img/new/banner.png";

const MemberPage = () => {
  const navigate = useNavigate();
  const [newStatus, setNewStatus] = useState(false);
  const [loading, setLoading] = useState(false);
  const user = useSelector((state: any) => state.loginUser.value.user);
  const isLogin = useSelector((state: any) => state.loginUser.value.isLogin);

  const goLogin = () => {
    navigate(
      "/login?redirect=" +
        encodeURIComponent(window.location.pathname + window.location.search)
    );
  };

  useEffect(() => {
    if (isLogin) {
      getUnread();
    }
  }, [isLogin]);

  const getUnread = () => {
    member.UnReadNum().then((res: any) => {
      let num = res.data;
      if (num === 0) {
        setNewStatus(false);
      } else {
        setNewStatus(true);
      }
    });
  };

  const goRole = () => {
    if (!isLogin) {
      goLogin();
      return;
    }
    navigate("/role");
  };

  return (
    <div id="content" className={styles["container"]}>
      <div className={styles["user-icon"]}></div>
      {isLogin ? (
        <div
          className={styles["user-info-box"]}
          onClick={() => navigate("/member/profile")}
        >
          <div className={styles["user-avatar-box"]}>
            <Image
              height={64}
              width={64}
              style={{ borderRadius: "50%" }}
              src={user.avatar || defaultAvatar}
            />
          </div>
          <div className={styles["user-body"]}>
            <div className={styles["user-nickname"]}>{user.nick_name}</div>
            <div className={styles["role-name"]}>
              {user.role ? user.role.name : "免费会员"}
            </div>
          </div>
          <div className={styles["user-back"]}>
            <img src={backIcon} style={{ width: 15, height: 15 }} />
          </div>
        </div>
      ) : (
        <div className={styles["user-info-box"]} onClick={() => goLogin()}>
          <div className={styles["user-avatar-box"]}>
            <img src={defaultAvatar} />
          </div>
          <div className={styles["user-body"]}>
            <div className={styles["login-button"]}>请登录</div>
          </div>
          <div className={styles["user-back"]}>
            <img src={backIcon} style={{ width: 15, height: 15 }} />
          </div>
        </div>
      )}
      <div className={styles["vip-banner-box"]}>
        <div className={styles["banner"]} onClick={() => goRole()}>
          <img className={styles["icon"]} src={vipIcon} />
          <img className={styles["back"]} src={bannerIcon} />
          <div className={styles["info"]}>海量课程免费学！</div>
          <div className={styles["btn"]}>会员中心</div>
        </div>
      </div>
      <div className={styles["user-banner-item"]}>
        <div className={styles["banner-body"]}>
          {isLogin ? (
            <>
              <div
                className={styles["item"]}
                onClick={() => navigate("/member/order")}
              >
                <div className={styles["icon"]}>
                  <div className={styles["icon-img"]}>
                    <img src={orderIcon} />
                  </div>
                  <div className={styles["name"]}>我的订单</div>
                </div>
                <div className={styles["arrow-icon"]}>
                  <img src={backIcon} />
                </div>
              </div>
              <div
                className={styles["item"]}
                onClick={() => navigate("/messages")}
              >
                <div className={styles["icon"]}>
                  <div className={styles["icon-img"]}>
                    <img src={mesIcon} />
                  </div>
                  <div className={styles["name"]}>我的消息</div>
                </div>
                {newStatus && <i className={styles["count"]}></i>}
                <div className={styles["arrow-icon"]}>
                  <img src={backIcon} />
                </div>
              </div>
            </>
          ) : (
            <>
              <div className={styles["item"]} onClick={() => goLogin()}>
                <div className={styles["icon"]}>
                  <div className={styles["icon-img"]}>
                    <img src={orderIcon} />
                  </div>
                  <div className={styles["name"]}>我的订单</div>
                </div>
                <div className={styles["arrow-icon"]}>
                  <img src={backIcon} />
                </div>
              </div>
              <div className={styles["item"]} onClick={() => goLogin()}>
                <div className={styles["icon"]}>
                  <div className={styles["icon-img"]}>
                    <img src={mesIcon} />
                  </div>
                  <div className={styles["name"]}>我的消息</div>
                </div>
                <div className={styles["arrow-icon"]}>
                  <img src={backIcon} />
                </div>
              </div>
            </>
          )}
          <div
            className={styles["item"]}
            onClick={() => navigate("/member/setting")}
          >
            <div className={styles["icon"]}>
              <div className={styles["icon-img"]}>
                <img src={settingIcon} />
              </div>
              <div className={styles["name"]}>关于平台</div>
            </div>
            <div className={styles["arrow-icon"]}>
              <img src={backIcon} />
            </div>
          </div>
        </div>
      </div>
      <TechSupport />
    </div>
  );
};

export default MemberPage;
