import { useState } from "react";
import styles from "./mobileVerify.module.scss";
import { useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { CaptchaDialog, ConfirmLogin } from "../../components";
import { Newmobile } from "./components/newmobile";
import { user as member, system } from "../../api/index";
import { isChinaMobilePhone } from "../../utils";
import icon from "../../assets/img/icon-back.png";
import { Toast } from "antd-mobile";

const MemberMobileVerifyPage = () => {
  document.title = "验证原手机号";
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [openmask, setOpenmask] = useState(false);
  const [confirmDialog, setConfirmDialog] = useState(false);
  const [verify, setVerify] = useState(false);
  const [reCaptcha, setReCaptcha] = useState(false);
  const [sign, setSign] = useState<any>(null);
  const [content, setContent] = useState("");
  const [captcha, setCaptcha] = useState<any>({ key: null, img: null });
  const user = useSelector((state: any) => state.loginUser.value.user);

  const openDialog = () => {
    if (!isChinaMobilePhone(user.mobile)) {
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
        mobile: user.mobile,
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
      .MobileVerify({
        mobile: user.mobile,
        mobile_code: val,
      })
      .then((res: any) => {
        setConfirmDialog(false);
        setLoading(false);
        setSign(res.data.sign);
        Toast.show("成功");
        setTimeout(() => {
          setVerify(true);
        }, 500);
      })
      .catch((e) => {
        setConfirmDialog(false);
        setLoading(false);
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
      <div className="navheader borderbox" style={{ borderBottom: "none" }}>
        <img
          className="back"
          onClick={() => {
            if (window.history.length <= 2) {
              navigate("/");
            } else {
              navigate(-1);
            }
          }}
          src={icon}
        />
      </div>
      {!verify && !confirmDialog && (
        <>
          <div className={styles["group-form-box"]}>
            <div className={styles["group-title"]}>验证原手机号</div>
            <div className={styles["item"]}>
              <div className={styles["mobile"]}>
                <span className={styles["tit"]}>原手机号</span>
                {user.mobile}
              </div>
            </div>
          </div>

          <div className="box pl-60 pr-60">
            <div
              className={`${styles["btn-confirm"]} ${styles["active"]}`}
              onClick={() => openDialog()}
            >
              获取短信验证码
            </div>
          </div>
        </>
      )}
      {!verify && confirmDialog && (
        <ConfirmLogin
          text="绑定"
          scene="mobile_bind"
          status={confirmDialog}
          mobile={user.mobile}
          change={(sms) => submit(sms)}
        />
      )}
      {verify && <Newmobile sign={sign} />}
    </div>
  );
};

export default MemberMobileVerifyPage;
