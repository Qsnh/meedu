import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { message, Modal, Image, QRCode } from "antd";
import { user, login } from "../../../../api/index";
import closeIcon from "../../../../assets/img/commen/icon-close.png";

interface PropInterface {
  open: boolean;
  onCancel: () => void;
  success: () => void;
}

var timer: any = null;
var countTimer: any = null;

export const BindWeixinDialog: React.FC<PropInterface> = ({
  open,
  onCancel,
  success,
}) => {
  const [qrode, setQrode] = useState<string>("");
  const [loading, setLoading] = useState(false);
  const [key, setKey] = useState("");
  const [expired, setExpired] = useState(false);
  const [remainingTime, setRemainingTime] = useState<any>({
    day: 0,
    hr: "00",
    min: "00",
    sec: "00",
  });

  useEffect(() => {
    if (open) {
      setRemainingTime({ day: 0, hr: "00", min: "00", sec: "00" });
      setQrode("");
      getBindQrode();
    }
    return () => {
      timer && clearInterval(timer);
      countTimer && clearInterval(countTimer);
    };
  }, [open]);

  const getBindQrode = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    user.wechatLogin({ action: "bind" }).then((res: any) => {
      setExpired(false);
      setQrode(res.data.url);
      setKey(res.data.key);
      countdown(res.data.expire);
      timer = setInterval(() => checkWechatBind(res.data.key), 3000);
      setLoading(false);
    });
  };

  const checkWechatBind = (value: any) => {
    user.checkWechatLogin({ key: value }).then((res: any) => {
      if (res.data.code && res.data.code !== "0") {
        login.codeBind({ code: res.data.code }).then((res: any) => {
          message.success("绑定成功");
          timer && clearInterval(timer);
          countTimer && clearInterval(countTimer);
          success();
        });
      }
    });
  };

  const countdown = (timestamp: number) => {
    const today: any = new Date();
    const now = Date.parse(today);
    let remaining: number = timestamp - now / 1000;
    if (remaining <= 0) {
      timer && clearInterval(timer);
      countTimer && clearInterval(countTimer);
      setExpired(true);
      return;
    }
    countTimer = setInterval(() => {
      //防止出现负数
      if (remaining > 2) {
        remaining--;
        getRemainingTime(remaining);
      } else if (remaining <= 2 && remaining > 0) {
        remaining--;
        timer && clearInterval(timer);
        getRemainingTime(remaining);
      } else {
        timer && clearInterval(timer);
        countTimer && clearInterval(countTimer);
        setExpired(true);
      }
    }, 1000);
  };

  const getRemainingTime = (remaining: number) => {
    const day = Math.floor(remaining / 3600 / 24);
    const hour = Math.floor((remaining / 3600) % 24);
    const minute = Math.floor((remaining / 60) % 60);
    const second = Math.floor(remaining % 60);

    setRemainingTime({
      day: day,
      hr: hour < 10 ? "0" + hour : hour,
      min: minute < 10 ? "0" + minute : minute,
      sec: second < 10 ? "0" + second : second,
    });
  };

  return (
    <>
      {open ? (
        <Modal
          title=""
          centered
          forceRender
          open={true}
          width={500}
          footer={null}
          onCancel={() => {
            timer && clearInterval(timer);
            countTimer && clearInterval(countTimer);
            onCancel();
          }}
          maskClosable={false}
          closable={false}
        >
          <div className={styles["tabs"]}>
            <div className={styles["tab-active-item"]}>绑定微信</div>
            <img
              className={styles["btn-close"]}
              onClick={() => {
                timer && clearInterval(timer);
                onCancel();
              }}
              src={closeIcon}
            />
          </div>
          <div className={styles["box"]}>
            {!loading && !expired && qrode !== "" && (
              <div className={styles["time"]}>
                有效期：
                {remainingTime.day !== 0 && (
                  <span>
                    {remainingTime.day}天{remainingTime.hr}时{remainingTime.min}
                    分{remainingTime.sec}秒
                  </span>
                )}
                {remainingTime.day === 0 && remainingTime.hr !== "00" && (
                  <span>
                    {remainingTime.hr}时{remainingTime.min}分{remainingTime.sec}
                    秒
                  </span>
                )}
                {remainingTime.day === 0 && remainingTime.hr === "00" && (
                  <span>
                    {remainingTime.min}分{remainingTime.sec}秒
                  </span>
                )}
              </div>
            )}
            {qrode !== "" && (
              <>
                {expired ? (
                  <QRCode
                    value={qrode}
                    size={300}
                    status="expired"
                    onRefresh={() => {
                      setRemainingTime({
                        day: 0,
                        hr: "00",
                        min: "00",
                        sec: "00",
                      });
                      setQrode("");
                      getBindQrode();
                    }}
                  />
                ) : (
                  <QRCode
                    value={qrode}
                    size={300}
                    status={loading ? "loading" : "active"}
                  />
                )}
              </>
            )}
          </div>
        </Modal>
      ) : null}
    </>
  );
};
