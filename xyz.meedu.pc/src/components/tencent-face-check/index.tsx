import React, { useState, useEffect } from "react";
import { useDispatch } from "react-redux";
import styles from "./index.module.scss";
import { QRCode, Modal, message } from "antd";
import { user, login } from "../../api/index";
import { logoutAction } from "../../store/user/loginUserSlice";
import closeIcon from "../../assets/img/commen/icon-close.png";

interface PropInterface {
  open: boolean;
  active: boolean;
  onCancel: () => void;
  success: () => void;
}

var timer: any = null;

export const TencentFaceCheck: React.FC<PropInterface> = ({
  open,
  active,
  onCancel,
  success,
}) => {
  const dispatch = useDispatch();
  const [loading, setLoading] = useState<boolean>(false);
  const [verifyLoading, setVerifyLoading] = useState<boolean>(false);
  const [qrode, setQrode] = useState<string>("");
  const [ruleId, setRuleId] = useState<string>("");
  const [bizToken, setBizToken] = useState<string>("");

  useEffect(() => {
    if (open) {
      getQrode();
    }
    return () => {
      timer && clearInterval(timer);
    };
  }, [open]);

  const getQrode = () => {
    if (verifyLoading) {
      return;
    }
    setVerifyLoading(true);
    user
      .tecentFaceVerify({
        s_url: "PC",
      })
      .then((res: any) => {
        setVerifyLoading(false);
        setQrode(res.data.url);
        setRuleId(res.data.rule_id);
        setBizToken(res.data.biz_token);
        timer = setInterval(
          () => checkFaceVerify(res.data.rule_id, res.data.biz_token),
          2500
        );
      })
      .catch((e) => {
        setVerifyLoading(false);
        timer && clearInterval(timer);
        onCancel();
        message.error(e.message || "无法发起实名认证");
      });
  };

  const checkFaceVerify = (id: any, token: any) => {
    user
      .tecentFaceVerifyQuery({ rule_id: id, biz_token: token })
      .then((res: any) => {
        if (res.data.status === 9) {
          message.success("实名认证成功");
          timer && clearInterval(timer);
          success();
        }
      });
  };

  const goLogout = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    login
      .logout()
      .then((res) => {
        setLoading(false);
        timer && clearInterval(timer);
        dispatch(logoutAction());
        location.reload();
      })
      .catch((e) => {
        setLoading(false);
        message.error("网络错误");
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
            onCancel();
          }}
          maskClosable={false}
          closable={false}
        >
          <div className={styles["tabs"]}>
            <div className={styles["tab-active-item"]}></div>
            {!active && (
              <a
                className={styles["linkTab"]}
                onClick={() => {
                  timer && clearInterval(timer);
                  goLogout();
                }}
              >
                退出登录&gt;&gt;
              </a>
            )}
            {active && (
              <img
                className={styles["btn-close"]}
                onClick={() => {
                  timer && clearInterval(timer);
                  onCancel();
                }}
                src={closeIcon}
              />
            )}
          </div>
          <div className={styles["box"]}>
            {qrode !== "" && (
              <QRCode
                size={250}
                value={qrode}
                status={verifyLoading ? "loading" : "active"}
              />
            )}
          </div>
          <p className={styles["tip"]}>请使用微信扫码完成实名认证</p>
        </Modal>
      ) : null}
    </>
  );
};
