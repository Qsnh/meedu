import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Input, Button } from "antd-mobile";
import { system } from "../../api";

interface PropInterface {
  status: boolean;
  reStatus: boolean;
  cancel: () => void;
  change: (content: string, captcha: any) => void;
}

export const CaptchaDialog: React.FC<PropInterface> = ({
  status,
  reStatus,
  change,
  cancel,
}) => {
  const [captcha, setCaptcha] = useState<any>({ key: null, img: null });
  const [content, setContent] = useState("");
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    setContent("");
    getCaptcha();
    setLoading(false);
  }, [reStatus]);

  useEffect(() => {
    if (!status) {
      setLoading(false);
    }
  }, [status]);

  const getCaptcha = () => {
    system.imageCaptcha().then((res: any) => {
      setCaptcha(res.data);
    });
  };

  return (
    <>
      {status ? (
        <div className={styles["mask"]}>
          <div className={styles["modal"]}>
            <div className={styles["body"]}>
              <div className={styles["top"]}>
                <div className={styles["btn_default"]} onClick={() => cancel()}>
                  取消
                </div>
              </div>
              <div className={styles["item"]}>
                <div className={styles["captcha"]}>
                  <img src={captcha.img} onClick={() => getCaptcha()} />
                </div>
              </div>
              <div className={styles["item"]}>
                <div className={styles["input"]}>
                  <Input
                    className={styles["input-text"]}
                    placeholder="请输入图中字符"
                    value={content}
                    onChange={(e: any) => {
                      setContent(e);
                    }}
                  />
                </div>
              </div>
            </div>
            <div className={styles["bottom"]}>
              <Button
                className={
                  content
                    ? `${styles["btn_primary"]} ${styles["active"]}`
                    : styles["btn_primary"]
                }
                onClick={() => {
                  setLoading(true);
                  change(content, captcha);
                }}
                loading={loading}
              >
                确认
              </Button>
            </div>
          </div>
        </div>
      ) : null}
    </>
  );
};
