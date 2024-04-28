import { useEffect, useState } from "react";
import styles from "./profile.module.scss";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useLocation } from "react-router-dom";
import NavHeader from "../../components/nav-header";
import { loginAction, logoutAction } from "../../store/user/loginUserSlice";
import { user as member, login } from "../../api/index";
import {
  isWechat,
  getHost,
  saveRuleId,
  saveBizToken,
  getSessionLoginCode,
  saveSessionLoginCode,
} from "../../utils";
import { Input, Toast } from "antd-mobile";
import arrIcon from "../../assets/img/new/back@2x.png";
import closeIcon from "../../assets/img/close.png";

const MemberProfilePage = () => {
  document.title = "个人资料";
  const navigate = useNavigate();
  const dispatch = useDispatch();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState(false);
  const [openmask, setOpenmask] = useState(false);
  const [changeNick, setChangeNick] = useState(false);
  const [logoutDialog, setLogoutDialog] = useState(false);
  const [dialog, setDialog] = useState(false);
  const [destroyDialog, setDestroyDialog] = useState(false);
  const [resource, setResource] = useState("");
  const [content, setContent] = useState("");
  const [verifyLoading, setVerifyLoading] = useState(false);
  const user = useSelector((state: any) => state.loginUser.value.user);
  const config = useSelector((state: any) => state.systemConfig.value);

  useEffect(() => {
    getData();
  }, []);

  useEffect(() => {
    // 社交绑定回调处理
    if (result.get("login_code") && result.get("action") === "bind") {
      codeBind(String(result.get("login_code")));
    }
    if (result.get("login_err_msg")) {
      Toast.show(String(result.get("login_err_msg")));
    }
    if (result.get("error")) {
      Toast.show(String(result.get("error")));
    }
  }, [result]);

  const cancel = () => {
    setOpenmask(false);
    setChangeNick(false);
    setLogoutDialog(false);
    setDialog(false);
    setDestroyDialog(false);
    setResource("");
  };

  const codeBind = (code: string) => {
    if (getSessionLoginCode(code)) {
      return;
    }
    saveSessionLoginCode(code);
    login.CodeBind({ code: code }).then((res) => {
      Toast.show("绑定成功");
      cancel();
      getData();
    });
  };

  const uploadAvatar = (e: any) => {
    let files = e.target.files;
    if (!files[0].type.match(/.jpg|.png|.jpeg/i)) {
      Toast.show("图片格式错误,请上传png/jpg/jpeg格式的图片");
      return;
    }
    if (files[0].size > 2048000) {
      Toast.show("图片大小不超过2M");
      return;
    }
    let formData = new FormData();
    formData.append("file", files[0]);
    member.UploadAvatar(formData).then((res: any) => {
      if (res.code === 0) {
        Toast.show("上传头像成功");
        getData();
      } else {
        Toast.show(res.data.message);
      }
    });
  };

  const getData = () => {
    member.detail().then((res: any) => {
      dispatch(loginAction(res.data));
    });
  };

  const changeNickname = () => {
    if (user.is_set_nickname === 1) {
      Toast.show("您已经设置过昵称了哦");
      return;
    }
    setChangeNick(true);
    setOpenmask(true);
  };

  const bindWechat = () => {
    let host = window.location.href;
    let redirect = encodeURIComponent(host);
    window.location.href =
      config.url +
      "/api/v3/auth/login/wechat/oauth?s_url=" +
      redirect +
      "&f_url=" +
      redirect +
      "&action=bind";
  };

  const cancelBindWechat = () => {
    setDialog(true);
    setOpenmask(true);
    setResource("wechat");
  };

  const bindQQ = () => {
    let host = window.location.href;
    let redirect = encodeURIComponent(host);
    window.location.href =
      config.url +
      "/api/v3/auth/login/socialite/qq?s_url=" +
      redirect +
      "&f_url=" +
      redirect +
      "&action=bind";
  };

  const cancelBindQQ = () => {
    setDialog(true);
    setOpenmask(true);
    setResource("qq");
  };

  const cancelBind = () => {
    member.CancelBind(resource).then((res: any) => {
      Toast.show("解绑成功");
      cancel();
      getData();
    });
  };

  const bindMobile = () => {
    navigate("/member/mobile");
  };

  const changeMobile = () => {
    navigate("/member/mobileVerify");
  };

  const goFaceVerify = () => {
    if (verifyLoading) {
      return;
    }
    let redirect = getHost() + "/auth/faceSuccess";
    setVerifyLoading(true);
    member
      .TecentFaceVerify({
        s_url: redirect,
      })
      .then((res: any) => {
        saveBizToken(res.data.biz_token);
        saveRuleId(res.data.rule_id);
        setVerifyLoading(false);
        window.location.href = res.data.url;
      })
      .catch((e) => {
        Toast.show(e.message || "无法发起实名认证");
      });
  };

  const goLocalFaceCheck = () => {
    navigate("/auth/faceSuccess");
  };

  const changePassword = () => {
    if (user.is_bind_mobile !== 1) {
      Toast.show("请绑定手机号");
      return;
    }
    navigate("/member/password");
  };

  const destroyUser = () => {
    setDestroyDialog(true);
    setOpenmask(true);
  };

  const destroyUserValidate = () => {
    login.DestroyUser({}).then((res: any) => {
      Toast.show("注销成功");
      cancel();
      dispatch(logoutAction());
      navigate("/member");
    });
  };

  const openLogoutDialog = () => {
    setLogoutDialog(true);
    setOpenmask(true);
  };

  const goLogout = () => {
    Toast.show("已安全退出");
    cancel();
    dispatch(logoutAction());
    navigate("/member");
  };

  const submitHandle = () => {
    if (loading) {
      return;
    }
    if (!content) {
      Toast.show("请输入昵称");
      return;
    }
    setLoading(true);
    member
      .NicknameChange({
        nick_name: content,
      })
      .then(() => {
        setLoading(false);
        Toast.show("修改成功");
        setContent("");
        cancel();
        setTimeout(() => {
          getData();
        }, 500);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <div className={styles["container"]}>
      <NavHeader text="个人中心" />
      {openmask && (
        <div className={styles["mask"]}>
          {changeNick && (
            <div className={styles["popup"]}>
              <div className={styles["cancel"]} onClick={() => cancel()}>
                <img src={closeIcon} />
              </div>
              <div className={styles["input-box"]}>
                <Input
                  className={styles["input-item"]}
                  placeholder="请输入昵称"
                  value={content}
                  onChange={(e: any) => {
                    setContent(e);
                  }}
                />
              </div>
              <div className={styles["confirm"]} onClick={() => submitHandle()}>
                确认
              </div>
            </div>
          )}
          {dialog && (
            <div className={styles["popup"]}>
              <div className={styles["cancel"]} onClick={() => cancel()}>
                <img src={closeIcon} />
              </div>
              {resource === "qq" ? (
                <div className={styles["text"]}>是否解除绑定QQ？</div>
              ) : (
                <div className={styles["text"]}>是否解除绑定微信？</div>
              )}
              <div className={styles["confirm"]} onClick={() => cancelBind()}>
                确认
              </div>
            </div>
          )}
          {destroyDialog && (
            <div className={styles["popup"]}>
              <div className={styles["cancel"]} onClick={() => cancel()}>
                <img src={closeIcon} />
              </div>
              <div className={styles["text"]}>
                确认注销账号？确认之后账号将在7天后自动注销，期间内登录账号将会自动取消账号注销。
              </div>
              <div
                className={styles["confirm"]}
                onClick={() => destroyUserValidate()}
              >
                确认
              </div>
            </div>
          )}
          {logoutDialog && (
            <div className={styles["popup"]}>
              <div className={styles["cancel"]} onClick={() => cancel()}>
                <img src={closeIcon} />
              </div>
              <div className={styles["text"]}>确认安全退出登录？</div>
              <div className={styles["confirm"]} onClick={() => goLogout()}>
                确认
              </div>
            </div>
          )}
        </div>
      )}
      <div className={styles["user-avatar"]}>
        <div className={styles["value"]}>
          <img src={user.avatar} />
          <input
            className={styles["input-avatar"]}
            type="file"
            accept="image/*"
            onChange={(e: any) => uploadAvatar(e)}
          />
        </div>
        <div className={styles["name"]}>点击更换头像</div>
      </div>
      <div className={styles["form-box"]}>
        <div className={styles["tit"]}>账户信息</div>
        <div className={styles["group-item"]} onClick={() => changeNickname()}>
          <div className={styles["name"]}>昵称</div>
          <div className={styles["value"]}>
            <span>{user.nick_name}</span>
            <img src={arrIcon} className={styles["arrow"]} />
          </div>
        </div>
        {config && config.socialites.wechat_oauth === 1 && isWechat() && (
          <div className={styles["group-item"]}>
            <div className={styles["name"]}>绑定微信</div>
            <div className={styles["value"]}>
              {user.is_bind_wechat === 1 ? (
                <span onClick={() => cancelBindWechat()}>已绑定</span>
              ) : (
                <span className={styles["un"]} onClick={() => bindWechat()}>
                  点击绑定
                </span>
              )}
              <img src={arrIcon} className={styles["arrow"]} />
            </div>
          </div>
        )}
        {config && config.socialites.qq === 1 && !isWechat() && (
          <div className={styles["group-item"]}>
            <div className={styles["name"]}>绑定QQ</div>
            <div className={styles["value"]}>
              {user.is_bind_qq === 1 ? (
                <span onClick={() => cancelBindQQ()}>已绑定</span>
              ) : (
                <span className={styles["un"]} onClick={() => bindQQ()}>
                  点击绑定
                </span>
              )}
              <img src={arrIcon} className={styles["arrow"]} />
            </div>
          </div>
        )}
        <div className={styles["group-item"]}>
          <div className={styles["name"]}>绑定手机号</div>
          <div className={styles["value"]}>
            {user.is_bind_mobile === 1 ? (
              <span onClick={() => changeMobile()}>
                {user.mobile.substr(0, 3) + "****" + user.mobile.substr(7)}
              </span>
            ) : (
              <span className={styles["un"]} onClick={() => bindMobile()}>
                点击绑定
              </span>
            )}
            <img src={arrIcon} className={styles["arrow"]} />
          </div>
        </div>
        <div className={styles["group-item"]}>
          <div className={styles["name"]}>实名认证</div>
          <div className={styles["value"]}>
            {user.is_face_verify === true ? (
              <span onClick={() => goLocalFaceCheck()}>已认证</span>
            ) : (
              <span className={styles["un"]} onClick={() => goFaceVerify()}>
                未认证
              </span>
            )}
            <img src={arrIcon} className={styles["arrow"]} />
          </div>
        </div>
        <div className={styles["group-item"]} onClick={() => changePassword()}>
          <div className={styles["name"]}>修改密码</div>
          <div className={styles["value"]}>
            {user.is_password_set === 1 ? (
              <span>已设置</span>
            ) : (
              <span className={styles["un"]}>设置密码</span>
            )}
            <img src={arrIcon} className={styles["arrow"]} />
          </div>
        </div>
        <div className={styles["group-item"]} onClick={() => destroyUser()}>
          <div className={styles["name"]}>账号注销</div>
          <div className={styles["value"]}>
            <img src={arrIcon} className={styles["arrow"]} />
          </div>
        </div>
        <div
          className={styles["group-item"]}
          onClick={() => openLogoutDialog()}
        >
          <div className={styles["name"]}>退出登录</div>
          <div className={styles["value"]}>
            <img src={arrIcon} className={styles["arrow"]} />
          </div>
        </div>
      </div>
    </div>
  );
};

export default MemberProfilePage;
