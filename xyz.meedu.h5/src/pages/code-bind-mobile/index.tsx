import { useState } from "react";
import styles from "./index.module.scss";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { CaptchaDialog, ConfirmLogin, ShowModel } from "../../components";
import { user as member, system } from "../../api/index";
import {
  isChinaMobilePhone,
  getHost,
  saveBizToken,
  saveRuleId,
  setToken,
  getLoginCode,
  clearLoginCode,
} from "../../utils";
import NavHeader from "../../components/nav-header";
import { Input, Toast } from "antd-mobile";
import closeIcon from "../../assets/img/new/close.png";
import { loginAction, logoutAction } from "../../store/user/loginUserSlice";

const CodeBindMobilePage = () => {
  document.title = "绑定手机号";
  const navigate = useNavigate();
  const dispatch = useDispatch();
  const [loading, setLoading] = useState(false);
  const [openmask, setOpenmask] = useState(false);
  const [confirmDialog, setConfirmDialog] = useState(false);
  const [reCaptcha, setReCaptcha] = useState(false);
  const [content, setContent] = useState("");
  const [mobile, setMobile] = useState("");
  const [captcha, setCaptcha] = useState<any>({ key: null, img: null });
  const [visible, setVisible] = useState(false);
  const [modelTitle, setModelTitle] = useState("");
  const [modelText, setModelText] = useState("");
  const [confirmText, setConfirmText] = useState("");
  const config = useSelector((state: any) => state.systemConfig.value);

  const openDialog = () => {
    if (!mobile) {
      return;
    }
    if (!isChinaMobilePhone(mobile)) {
      Toast.show("请输入正确的手机号");
      return;
    }
    setContent("");
    setOpenmask(true);
  };

  const qx = () => {
    setOpenmask(false);
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
        scene: "mobile_bind",
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

  const submit = (val: string) => {
    if (loading) {
      return;
    }
    setLoading(true);
    member
      .CodeBindMobile({
        mobile: mobile,
        mobile_code: val,
        code: getLoginCode(),
      })
      .then((res: any) => {
        setConfirmDialog(false);
        setLoading(false);
        Toast.show("成功");
        clearLoginCode();
        setToken(res.data.token);
        getUser();
      })
      .catch((e) => {
        setReCaptcha(!reCaptcha);
        setLoading(false);
      });
  };

  const getUser = async () => {
    try {
      let res: any = await member.detail();
      dispatch(loginAction(res.data));
      if (
        res.data.is_face_verify === false &&
        config.member.enabled_face_verify === true
      ) {
        setModelTitle("实名认证");
        setModelText("登录前请完成实名认证");
        setConfirmText("立即认证");
        setVisible(true);
      } else {
        // 跳转到之前的页面
        setTimeout(() => {
          navigate("/");
        }, 500);
      }
    } catch (e: any) {}
  };

  const cancelModel = () => {
    dispatch(logoutAction());
    setVisible(false);
    navigate("/member", { replace: true });
  };

  const confirmModel = () => {
    setVisible(false);
    if (modelTitle === "实名认证") {
      goFaceVerify();
    }
  };

  const goFaceVerify = () => {
    let redirect = getHost() + "/auth/faceSuccess";
    member
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
          <div className={styles["group-form-box"]}>
            <div className={styles["group-title"]}>绑定手机号</div>
            <div className={styles["group-item"]}>
              <div className={styles["name"]}>手机号</div>
              <div className={styles["value"]}>
                <Input
                  className={styles["input-text"]}
                  placeholder="请输入您的手机号"
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

          <div className="box pl-60 pr-60">
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
        </>
      )}
      {confirmDialog && (
        <ConfirmLogin
          text="绑定"
          scene="mobile_bind"
          status={confirmDialog}
          mobile={mobile}
          reStatus={reCaptcha}
          change={(sms) => submit(sms)}
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

export default CodeBindMobilePage;
