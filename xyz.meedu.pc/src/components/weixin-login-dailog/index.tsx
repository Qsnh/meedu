import React, { useState, useEffect } from "react";
import { useDispatch } from "react-redux";
import { useParams, useNavigate, useLocation } from "react-router-dom";
import styles from "./index.module.scss";
import { Modal, QRCode } from "antd";
import { user, login } from "../../api/index";
import { setToken, saveLoginCode, getMsv } from "../../utils/index";
import { loginAction } from "../../store/user/loginUserSlice";

interface PropInterface {
  open: boolean;
  onCancel: () => void;
  changeLogin: () => void;
  bindMobile: () => void;
}

var timer: any = null;
var countTimer: any = null;

export const WeixinLoginDialog: React.FC<PropInterface> = ({
  open,
  onCancel,
  changeLogin,
  bindMobile,
}) => {
  const result = new URLSearchParams(useLocation().search);
  const params = useParams();
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const pathname = useLocation().pathname;
  const [loading, setLoading] = useState(false);
  const [qrode, setQrode] = useState("");
  const [key, setKey] = useState("");
  const [expired, setExpired] = useState(false);
  const [remainingTime, setRemainingTime] = useState<any>({
    day: 0,
    hr: "00",
    min: "00",
    sec: "00",
  });
  const [redirect, setRedirect] = useState(result.get("redirect"));

  useEffect(() => {
    if (open) {
      setRemainingTime({ day: 0, hr: "00", min: "00", sec: "00" });
      setQrode("");
      getQrode();
    }
    return () => {
      timer && clearInterval(timer);
      countTimer && clearInterval(countTimer);
    };
  }, [open]);

  const getQrode = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    user.wechatLogin({ action: "login" }).then((res: any) => {
      setExpired(false);
      setQrode(res.data.url);
      setKey(res.data.key);
      countdown(res.data.expire);
      timer = setInterval(() => checkWechatLogin(res.data.key), 1000);
      setLoading(false);
    });
  };

  const checkWechatLogin = (value: any) => {
    user.checkWechatLogin({ key: value }).then((res: any) => {
      if (res.data.code && res.data.code !== "0") {
        login
          .codeLogin({ code: res.data.code, msv: getMsv() })
          .then((res: any) => {
            if (res.data.success === 1) {
              setToken(res.data.token);
              user.detail().then((res: any) => {
                let loginData = res.data;
                // 将学员数据存储到store
                dispatch(loginAction(loginData));
                // 登录成功之后的跳转
                redirectHandler();
              });
            } else {
              if (res.data.action === "bind_mobile") {
                timer && clearInterval(timer);
                countTimer && clearInterval(countTimer);
                saveLoginCode(res.data.code);
                bindMobile();
              }
            }
          });
      }
    });
  };

  const redirectHandler = () => {
    timer && clearInterval(timer);
    countTimer && clearInterval(countTimer);
    onCancel();
    if (pathname === "/login") {
      if (redirect) {
        navigate(decodeURIComponent(redirect), { replace: true });
      } else {
        navigate("/", { replace: true });
      }
    } else {
      location.reload();
    }
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
        >
          <div className={styles["tabs"]}>
            <div className={styles["tab-active-item"]}>微信扫码登录</div>
            <a
              className={styles["linkTab"]}
              onClick={() => {
                timer && clearInterval(timer);
                changeLogin();
              }}
            >
              其他方式登录&gt;&gt;
            </a>
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
                      getQrode();
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
