import { useState } from "react";
import styles from "./password.module.scss";
import { useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { CaptchaDialog, ConfirmLogin } from "../../components";
import { user as member, system } from "../../api/index";
import { isChinaMobilePhone } from "../../utils";
import NavHeader from "../../components/nav-header";
import { Input, Toast } from "antd-mobile";
import closeIcon from "../../assets/img/new/close.png";

const MemberPasswordPage = () => {
  document.title = "重置密码";
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [openmask, setOpenmask] = useState(false);
  const [reCaptcha, setReCaptcha] = useState(false);
  const [confirmDialog, setConfirmDialog] = useState(false);
  const [password, setPassword] = useState("");
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
        scene: "password_reset",
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
    if (!password) {
      Toast.show("请输入密码");
      return;
    }
    setLoading(true);
    member
      .PasswordChange({
        mobile: user.mobile,
        mobile_code: val,
        password: password,
      })
      .then((res: any) => {
        setConfirmDialog(false);
        setLoading(false);
        Toast.show("成功");
        setTimeout(() => {
          navigate(-1);
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
      <NavHeader text="" noBorder />
      {!confirmDialog && (
        <>
          <div className={styles["group-form-box"]}>
            <div className={styles["group-title"]}>重置密码</div>
            <div className={styles["group-item"]}>
              <div className={styles["mobile"]}>
                <span className={styles["tit"]}>手机号</span>
                {user.mobile}
              </div>
            </div>
            <div className={styles["group-item"]}>
              <div className={styles["name"]}>新密码</div>
              <div className={styles["value"]}>
                <Input
                  type="password"
                  className={styles["input-text"]}
                  placeholder="请输入新密码"
                  value={password}
                  onChange={(e: any) => {
                    setPassword(e);
                  }}
                />
                {password && (
                  <img
                    src={closeIcon}
                    width={16}
                    height={16}
                    onClick={() => setPassword("")}
                  />
                )}
              </div>
            </div>
          </div>

          <div className="box pl-60 pr-60">
            <div
              className={
                password
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
          text="确定"
          scene="password_reset"
          status={confirmDialog}
          mobile={user.mobile}
          reStatus={reCaptcha}
          change={(sms) => submit(sms)}
        />
      )}
    </div>
  );
};

export default MemberPasswordPage;
