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
  const [code, setCode] = useState("");
  const [key, setKey] = useState("");
  const [redirect, setRedirect] = useState(result.get("redirect"));

  useEffect(() => {
    if (open) {
      getQrode();
    }
    return () => {
      timer && clearInterval(timer);
    };
  }, [open]);

  const getQrode = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    user.wechatLogin({ action: "login" }).then((res: any) => {
      setQrode(res.data.url);
      setKey(res.data.key);
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
            {qrode !== "" && (
              <QRCode
                value={qrode}
                size={300}
                status={loading ? "loading" : "active"}
              />
            )}
          </div>
        </Modal>
      ) : null}
    </>
  );
};
