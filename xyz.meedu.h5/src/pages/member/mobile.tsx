import { useState } from "react";
import styles from "./mobile.module.scss";
import { useNavigate } from "react-router-dom";
import { CaptchaDialog, ConfirmLogin } from "../../components";
import { user as member, system } from "../../api/index";
import { isChinaMobilePhone } from "../../utils";
import NavHeader from "../../components/nav-header";
import { Input, Toast } from "antd-mobile";
import closeIcon from "../../assets/img/new/close.png";

const MemberMobilePage = () => {
  document.title = "绑定手机号";
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [openmask, setOpenmask] = useState(false);
  const [confirmDialog, setConfirmDialog] = useState(false);
  const [reCaptcha, setReCaptcha] = useState(false);
  const [content, setContent] = useState("");
  const [mobile, setMobile] = useState("");
  const [captcha, setCaptcha] = useState<any>({ key: null, img: null });

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
      .NewMobile({
        mobile: mobile,
        mobile_code: val,
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
          change={(sms) => submit(sms)}
        />
      )}
    </div>
  );
};

export default MemberMobilePage;
