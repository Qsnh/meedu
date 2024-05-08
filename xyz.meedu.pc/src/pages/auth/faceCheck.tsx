import React, { useState, useEffect } from "react";
import { useDispatch } from "react-redux";
import styles from "./faceCheck.module.scss";
import { useNavigate } from "react-router-dom";
import { QRCode, message } from "antd";
import { user } from "../../api/index";
import { loginAction } from "../../store/user/loginUserSlice";
import { clearFaceCheckKey } from "../../utils/index";

var timer: any = null;
const TencentFaceCheckPage = () => {
  const navigate = useNavigate();
  const dispatch = useDispatch();
  const [verifyLoading, setVerifyLoading] = useState<boolean>(false);
  const [qrode, setQrode] = useState("loading");
  const [ruleId, setRuleId] = useState("");
  const [bizToken, setBizToken] = useState("");

  useEffect(() => {
    getQrode();
    document.title = "实名认证";
    return () => {
      timer && clearInterval(timer);
    };
  }, []);

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
          clearFaceCheckKey();
          getUser();
        }
      });
  };

  const getUser = () => {
    user.detail().then((res: any) => {
      let loginData = res.data;
      dispatch(loginAction(loginData));
      navigate("/", { replace: true });
    });
  };

  return (
    <div>
      <div className={styles["box"]}>
        <QRCode
          size={300}
          value={qrode}
          status={verifyLoading ? "loading" : "active"}
        />
      </div>
      <p className={styles["tip"]}>请使用微信扫码完成实名认证</p>
    </div>
  );
};

export default TencentFaceCheckPage;
