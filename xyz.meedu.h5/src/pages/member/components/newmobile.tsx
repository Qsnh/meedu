import React, { useState, useEffect } from "react";
import styles from "./newmobile.module.scss";
import { useNavigate } from "react-router-dom";
import { system, user as member } from "../../../api";
import { Toast, Input, SpinLoading, Button } from "antd-mobile";
import { isChinaMobilePhone } from "../../../utils";
import closeIcon from "../../../assets/img/new/close.png";

interface PropInterface {
  sign: any;
}

var interval: any = null;

export const Newmobile: React.FC<PropInterface> = ({ sign }) => {
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [captcha, setCaptcha] = useState<any>({ key: null, img: null });
  const [content, setContent] = useState("");
  const [mobile, setMobile] = useState("");
  const [sms, setSms] = useState("");
  const [current, setCurrent] = useState<number>(0);
  const [smsLoading, setSmsLoading] = useState<boolean>(false);
  const [smsLoading2, setSmsLoading2] = useState<boolean>(false);

  useEffect(() => {
    setMobile("");
    setContent("");
    setSms("");
    setSmsLoading(false);
    setCurrent(120);

    getCaptcha();

    return () => {
      clearSmsInterval();
    };
  }, []);

  const clearSmsInterval = () => {
    interval && clearInterval(interval);
  };

  const submit = () => {
    if (!mobile || !sms) {
      return;
    }
    if (!isChinaMobilePhone(mobile)) {
      Toast.show("请输入正确的手机号");
      return;
    }
    setLoading(true);
    member
      .MobileChange({
        mobile: mobile,
        mobile_code: sms,
        sign: sign,
      })
      .then(() => {
        setLoading(false);
        Toast.show("成功");
        setTimeout(() => {
          navigate(-1);
        }, 500);
      })
      .catch(() => {
        setLoading(false);
      });
  };

  const getCaptcha = () => {
    system.imageCaptcha().then((res: any) => {
      setCaptcha(res.data);
    });
  };

  const sendSms = () => {
    if (smsLoading || smsLoading2) {
      return;
    }
    if (!mobile) {
      Toast.show("请输入新手机号");
      return;
    }
    if (!isChinaMobilePhone(mobile)) {
      Toast.show("请输入正确的手机号");
      return;
    }
    if (!content) {
      Toast.show("请输入图形验证码");
      return;
    }
    setSmsLoading(true);
    setSmsLoading2(true);
    system
      .sendSms({
        mobile: mobile,
        image_key: captcha.key,
        image_captcha: content,
        scene: "mobile_bind",
      })
      .then(() => {
        setSmsLoading2(false);
        let time = 120;
        interval = setInterval(() => {
          time--;
          setCurrent(time);
          if (time === 0) {
            clearSmsInterval();
            setCurrent(120);
            setSmsLoading(false);
          }
        }, 1000);
      })
      .catch((e: any) => {
        setSmsLoading2(false);
        setContent("");
        getCaptcha();
        clearSmsInterval();
        setCurrent(120);
        setSmsLoading(false);
      });
  };

  return (
    <div className={styles["box"]}>
      <div className={styles["group-form-box"]}>
        <div className={styles["group-title"]}>换绑手机号</div>
        <div className={styles["item"]}>
          <div className={styles["name"]}>新手机号</div>
          <div className={styles["value"]}>
            <Input
              className={styles["input"]}
              placeholder="请输入新的手机号码"
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
        <div className={styles["item"]}>
          <div className={styles["name"]}>验证码</div>
          <div className={styles["value"]}>
            <Input
              className={styles["input"]}
              placeholder="请输入图形验证码"
              value={content}
              onChange={(e: any) => {
                setContent(e);
              }}
            />
            <div className={styles["captcha"]} onClick={() => getCaptcha()}>
              {captcha.img && <img width={100} height={36} src={captcha.img} />}
            </div>
          </div>
        </div>
        <div className={styles["item"]}>
          <div className={styles["name"]}>验证码</div>
          <div className={styles["value"]}>
            <Input
              className={styles["input"]}
              placeholder="请输入短信验证码"
              value={sms}
              onChange={(e: any) => {
                setSms(e);
              }}
            />
            <div className={styles["buttons"]}>
              {smsLoading2 && (
                <div style={{ width: 90, textAlign: "center" }}>
                  <SpinLoading color="primary" />
                </div>
              )}
              {!smsLoading2 && smsLoading && (
                <span className={styles["send-sms-button"]}>{current}s</span>
              )}
              {!smsLoading && !smsLoading2 && (
                <span
                  className={styles["send-sms-button"]}
                  onClick={() => sendSms()}
                >
                  获取验证码
                </span>
              )}
            </div>
          </div>
        </div>
        <div className="box pl-60 pr-60">
          <Button
            className={
              content && sms && mobile
                ? `${styles["btn-confirm"]} ${styles["active"]}`
                : styles["btn-confirm"]
            }
            onClick={() => submit()}
            loading={loading}
          >
            立即绑定码
          </Button>
        </div>
      </div>
    </div>
  );
};
