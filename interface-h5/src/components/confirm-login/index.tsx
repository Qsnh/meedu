import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Input, Toast, Button } from "antd-mobile";
import { CaptchaDialog } from "../captcha-dialog";
import { system } from "../../api";
import closeIcon from "../../assets/img/new/close.png";

interface PropInterface {
  mobile: string;
  status: boolean;
  text: string;
  scene: string;
  change: (sms: string) => void;
}

var interval: any = null;

export const ConfirmLogin: React.FC<PropInterface> = ({
  mobile,
  status,
  text,
  scene,
  change,
}) => {
  const [loading, setLoading] = useState(false);
  const [openmask, setOpenmask] = useState(false);
  const [reCaptcha, setReCaptcha] = useState(false);
  const [content, setContent] = useState("");
  const [sms, setSms] = useState("");
  const [captcha, setCaptcha] = useState<any>({ key: null, img: null });
  const [current, setCurrent] = useState<number>(0);
  const [smsLoading, setSmsLoading] = useState<boolean>(false);

  useEffect(() => {
    setSmsLoading(true);
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

    return () => {
      clearSmsInterval();
    };
  }, []);

  useEffect(() => {
    if (!status) {
      setLoading(false);
    }
  }, [status]);

  const openDialog = () => {
    if (smsLoading) {
      // 冷却中
      return;
    }
    setContent("");
    setOpenmask(true);
  };

  const qx = () => {
    setOpenmask(false);
  };

  const sendSms = (val: string, cap: any) => {
    setContent(val);
    setCaptcha(cap);
    system
      .sendSms({
        mobile: mobile,
        image_key: cap.key,
        image_captcha: val,
        scene: scene,
      })
      .then((res) => {
        setSmsLoading(true);
        // 发送成功
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
        setOpenmask(false);
      })
      .catch((e) => {
        setReCaptcha(!reCaptcha);
      });
  };

  const clearSmsInterval = () => {
    interval && clearInterval(interval);
  };

  const confirm = () => {
    if (!sms) {
      Toast.show("请输入短信验证码");
      return;
    }
    change(sms);
  };

  return (
    <>
      {status && (
        <div className={styles["box"]}>
          <CaptchaDialog
            status={openmask}
            reStatus={reCaptcha}
            change={(val, cap) => sendSms(val, cap)}
            cancel={() => qx()}
          />
          <div className={styles["sms-login-form"]}>
            <div className={styles["sms-login-title"]}>输入短信验证码</div>
            <div className={styles["item"]}>
              <div className={styles["text"]}>
                验证码已发送至
                <span className={styles["value"]}>{mobile}</span>
              </div>
              <div className={styles["buttons"]}>
                {smsLoading ? (
                  <span className={styles["send-sms-button"]}>{current}s</span>
                ) : (
                  <span
                    className={styles["send-sms-button"]}
                    onClick={() => openDialog()}
                  >
                    重新发送
                  </span>
                )}
              </div>
            </div>
            <div className={styles["item"]}>
              <div className={styles["name"]}>验证码</div>
              <div className={styles["input"]}>
                <Input
                  className={styles["input-text"]}
                  placeholder="请输入短信验证码"
                  value={sms}
                  onChange={(e: any) => {
                    setSms(e);
                  }}
                />
                {sms && (
                  <img
                    src={closeIcon}
                    width={16}
                    height={16}
                    onClick={() => setSms("")}
                  />
                )}
              </div>
            </div>
          </div>
          <div className={styles["login-button-box"]}>
            <Button
              className={
                sms
                  ? `${styles["btn-confirm"]} ${styles["active"]}`
                  : styles["btn-confirm"]
              }
              onClick={() => {
                setLoading(true);
                confirm();
              }}
              loading={loading}
            >
              {text}
            </Button>
          </div>
        </div>
      )}
    </>
  );
};
