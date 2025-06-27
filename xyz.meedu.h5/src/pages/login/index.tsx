import { useState, useEffect } from "react";
import { Toast, Input } from "antd-mobile";
import styles from "./index.module.scss";
import { useDispatch, useSelector } from "react-redux";
import { useLocation, useNavigate } from "react-router-dom";
import { login, system, user } from "../../api/index";
import {
  setToken,
  isChinaMobilePhone,
  isWechat,
  removeTokenParams,
  getHost,
  clearToken,
  saveBizToken,
  saveRuleId,
  clearBizToken,
  clearRuleId,
} from "../../utils/index";
import {
  ConfirmLogin,
  CaptchaDialog,
  Protocol,
  ShowModel,
} from "../../components";
import NavHeader from "../../components/nav-header";
import { loginAction, logoutAction } from "../../store/user/loginUserSlice";
import { saveConfigAction } from "../../store/system/systemConfigSlice";
import closeIcon from "../../assets/img/new/close.png";
import qqIcon from "../../assets/img/icon-qq.png";
import wechatIcon from "../../assets/img/wechat.png";
import { RootState } from "../../store";
import { AppConfigInterface } from "../../store/system/systemConfigSlice";

const LoginPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState(false);
  const [visible, setVisible] = useState(false);
  const [openmask, setOpenmask] = useState(false);
  const [confirmDialog, setConfirmDialog] = useState(false);
  const [mobile, setMobile] = useState("");
  const [agreeProtocol, setAgreeProtocol] = useState(false);
  const [content, setContent] = useState("");
  const [reCaptcha, setReCaptcha] = useState(false);
  const [captcha, setCaptcha] = useState<any>({ key: null, img: null });
  const [modelTitle, setModelTitle] = useState("");
  const [modelText, setModelText] = useState("");
  const [confirmText, setConfirmText] = useState("");
  const [redirect, setRedirect] = useState(result.get("redirect") || "");
  const config: AppConfigInterface = useSelector(
    (state: RootState) => state.systemConfig.value
  );

  useEffect(() => {
    document.title = "快捷登录/注册";
  }, []);

  const openDialog = () => {
    if (!mobile) {
      return;
    }
    if (!isChinaMobilePhone(mobile)) {
      Toast.show("请输入正确的手机号");
      return;
    }
    if (agreeProtocol === false) {
      Toast.show("请同意协议");
      return;
    }
    setContent("");
    setOpenmask(true);
  };

  const qx = () => {
    setOpenmask(false);
  };

  const protocolAgree = (bool: boolean) => {
    setAgreeProtocol(bool);
  };

  const cancelModel = () => {
    dispatch(logoutAction());
    setVisible(false);
    navigate("/member", { replace: true });
  };

  const handler = async (token: string) => {
    setToken(token);
    await getSystemConfig();
    await getUser();
  };

  const loginHandler = (val: string) => {
    if (loading) {
      return;
    }
    setLoading(true);
    login
      .SmsLogin({
        mobile: mobile,
        mobile_code: val,
        msv: "",
      })
      .then((res: any) => {
        setLoading(false);
        handler(res.data.token);
      })
      .catch((e) => {
        setReCaptcha(!reCaptcha);
        setLoading(false);
      });
  };

  const getUser = async () => {
    try {
      let res: any = await user.detail();
      dispatch(loginAction(res.data));
      if (
        config.member.enabled_mobile_bind_alert === 1 &&
        res.data.is_bind_mobile !== 1
      ) {
        setModelTitle("绑定手机号");
        setModelText("登录前请绑定手机号");
        setConfirmText("立即绑定");
        setVisible(true);
        setConfirmDialog(false);
      } else if (
        res.data.is_face_verify === false &&
        config.member.enabled_face_verify === true
      ) {
        setModelTitle("实名认证");
        setModelText("登录前请完成实名认证");
        setConfirmText("立即认证");
        setVisible(true);
        setConfirmDialog(false);
      } else {
        clearBizToken();
        clearRuleId();
        // 跳转到之前的页面
        setTimeout(() => {
          if (redirect) {
            window.location.href = getHost() + decodeURIComponent(redirect);
          } else {
            navigate(-1);
          }
        }, 500);
      }
    } catch (e: any) {
      if (e.code === 401) {
        clearToken();
        window.location.href = getHost() + decodeURIComponent(redirect);
      }
    }
  };

  const getSystemConfig = async () => {
    let configRes: any = await system.config();
    if (configRes.data) {
      dispatch(saveConfigAction(configRes.data));
    }
  };

  const sendSms = (val: string, cap: any) => {
    if (loading) {
      return;
    }
    setContent(val);
    setCaptcha(cap);
    setLoading(true);
    system
      .sendSms({
        mobile: mobile,
        image_key: cap.key,
        image_captcha: val,
        scene: "login",
      })
      .then((res) => {
        // 发送成功
        setLoading(false);
        setOpenmask(false);
        setConfirmDialog(true);
      })
      .catch((e) => {
        setLoading(false);
        setReCaptcha(!reCaptcha);
      });
  };

  const goLoginPasswordPage = () => {
    let host = decodeURIComponent(redirect);
    navigate("/login-password?redirect=" + encodeURIComponent(host));
  };

  const socialiteLogin = (app: string) => {
    if (!agreeProtocol) {
      Toast.show("请先同意协议");
      return;
    }
    let host = getHost() + decodeURIComponent(redirect);
    if (decodeURIComponent(redirect) === "/login") {
      host = getHost() + "/member";
    }
    let redirecUrl = encodeURIComponent(removeTokenParams(host));
    let failUrl = encodeURIComponent(getHost() + "/login-error");
    window.location.href =
      config.url +
      "/api/v3/auth/login/socialite/" +
      app +
      "?s_url=" +
      redirecUrl +
      "&f_url=" +
      failUrl +
      "&action=login";
  };

  const h5WorkWeixinLogin = () => {
    if (!agreeProtocol) {
      Toast.show("请先同意协议");
      return;
    }
    let host = getHost() + decodeURIComponent(redirect);
    if (decodeURIComponent(redirect) === "/login") {
      host = getHost() + "/member";
    }
    let redirecUrl = encodeURIComponent(removeTokenParams(host));
    let failUrl = encodeURIComponent(getHost() + "/login-error");
    window.location.href =
      config.url +
      "/api/v3/auth/login/wechat/oauth?s_url=" +
      redirecUrl +
      "&f_url=" +
      failUrl +
      "&action=login";
  };

  const confirmModel = () => {
    setVisible(false);
    if (modelTitle === "实名认证") {
      goFaceVerify();
    } else if (modelTitle === "绑定手机号") {
      navigate("/bind-mobile");
    }
  };

  const goFaceVerify = () => {
    let redirect = getHost() + "/auth/faceSuccess";
    user
      .TecentFaceVerify({
        s_url: redirect,
      })
      .then((res: any) => {
        saveBizToken(res.data.biz_token);
        saveRuleId(res.data.rule_id);
        window.location.href = res.data.url;
      })
      .catch((e) => {
        Toast.show(e.message || "无法发起实名认证");
      });
  };

  return (
    <div className={styles["container"]}>
      <CaptchaDialog
        status={openmask}
        reStatus={reCaptcha}
        change={(val, cap) => sendSms(val, cap)}
        cancel={() => qx()}
      />
      <NavHeader text="" noBorder />
      {!confirmDialog && (
        <>
          <div className={styles["sms-login-form"]}>
            <div className={styles["sms-login-title"]}>登录/注册</div>
            <div className={styles["item"]}>
              <div className={styles["name"]}>手机号</div>
              <div className={styles["input"]}>
                <Input
                  className={styles["input-text"]}
                  placeholder="请输入手机号码"
                  value={mobile}
                  onChange={(e: any) => {
                    setMobile(e);
                  }}
                />
                {mobile && (
                  <img
                    src={closeIcon}
                    width={16}
                    height={16}
                    onClick={() => setMobile("")}
                  />
                )}
              </div>
            </div>
          </div>
          <div className="box border-box mt-15 pl-60 pr-60">
            <div
              className={
                mobile
                  ? `${styles["btn-confirm"]} ${styles["active"]}`
                  : styles["btn-confirm"]
              }
              onClick={() => openDialog()}
            >
              获取短信验证码
            </div>
          </div>
          <div className={styles["login-button-box"]}>
            <span
              className={styles["login-password-way"]}
              onClick={() => goLoginPasswordPage()}
            >
              使用密码登录
            </span>
          </div>
          <Protocol type="" agree={(bool) => protocolAgree(bool)} />
          <div className={styles["login-other-way"]}>
            <div className={styles["socialite-box"]}>
              {!isWechat() && config.socialites.qq === 1 && (
                <div
                  className={styles["socialite-login-item"]}
                  onClick={() => socialiteLogin("qq")}
                >
                  <img src={qqIcon} />
                </div>
              )}
              {isWechat() && config.socialites.wechat_oauth === 1 && (
                <div
                  className={styles["socialite-login-item"]}
                  onClick={() => h5WorkWeixinLogin()}
                >
                  <img src={wechatIcon} />
                </div>
              )}
            </div>
          </div>
        </>
      )}
      {confirmDialog && (
        <ConfirmLogin
          text="登录/注册"
          scene="login"
          status={confirmDialog}
          reStatus={reCaptcha}
          mobile={mobile}
          change={(sms) => loginHandler(sms)}
        />
      )}
      {visible && (
        <ShowModel
          title={modelTitle}
          text={modelText}
          confirmText={confirmText}
          cancel={() => cancelModel()}
          change={() => confirmModel()}
        />
      )}
    </div>
  );
};

export default LoginPage;
