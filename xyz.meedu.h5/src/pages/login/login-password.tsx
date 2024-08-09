import { useState, useEffect } from "react";
import { Toast, Input, Button } from "antd-mobile";
import styles from "./login-password.module.scss";
import { useDispatch, useSelector } from "react-redux";
import { useLocation, useNavigate } from "react-router-dom";
import { login, system, user } from "../../api/index";
import {
  setToken,
  isChinaMobilePhone,
  getHost,
  clearToken,
  saveBizToken,
  saveRuleId,
  clearBizToken,
  clearRuleId,
} from "../../utils/index";
import { ShowModel } from "../../components";
import NavHeader from "../../components/nav-header";
import { loginAction, logoutAction } from "../../store/user/loginUserSlice";
import { saveConfigAction } from "../../store/system/systemConfigSlice";
import closeIcon from "../../assets/img/new/close.png";

const LoginPasswordPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState(false);
  const [mobile, setMobile] = useState("");
  const [password, setPassword] = useState("");
  const [modelTitle, setModelTitle] = useState("");
  const [modelText, setModelText] = useState("");
  const [confirmText, setConfirmText] = useState("");
  const [visible, setVisible] = useState(false);
  const [redirect, setRedirect] = useState(result.get("redirect") || "");
  const config = useSelector((state: any) => state.systemConfig.value);

  useEffect(() => {
    document.title = "密码登录";
  }, []);

  const passwordLoginHandler = () => {
    if (!mobile) {
      return;
    }
    if (!isChinaMobilePhone(mobile)) {
      Toast.show("请输入正确的手机号");
      return;
    }
    if (!password) {
      return;
    }
    setLoading(true);
    login
      .PasswordLogin({
        mobile: mobile,
        password: password,
      })
      .then((res: any) => {
        // 写入token
        handler(res.data.token);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const handler = async (token: string) => {
    setToken(token);
    await getSystemConfig();
    await getUser();
  };

  const getUser = async () => {
    try {
      let res: any = await user.detail();
      dispatch(loginAction(res.data));
      if (
        config.member.enabled_mobile_bind_alert === 1 &&
        res.data.is_bind_mobile !== 1
      ) {
        setModelTitle("绑定手机号");
        setModelText("登录前请绑定手机号");
        setConfirmText("立即绑定");
        setVisible(true);
      } else if (
        res.data.is_face_verify === false &&
        config.member.enabled_face_verify === true
      ) {
        setModelTitle("实名认证");
        setModelText("登录前请完成实名认证");
        setConfirmText("立即认证");
        setVisible(true);
      } else {
        clearBizToken();
        clearRuleId();
        // 跳转到之前的页面
        setTimeout(() => {
          if (redirect) {
            window.location.href = getHost() + decodeURIComponent(redirect);
          } else {
            navigate(-2);
          }
        }, 500);
      }
      setLoading(false);
    } catch (e: any) {
      if (e.code === 401) {
        clearToken();
        setLoading(false);
        window.location.href = getHost() + decodeURIComponent(redirect);
      }
    }
  };

  const getSystemConfig = async () => {
    let configRes: any = await system.config();
    if (configRes.data) {
      dispatch(saveConfigAction(configRes.data));
    }
  };

  const cancelModel = () => {
    dispatch(logoutAction());
    setVisible(false);
    navigate("/member", { replace: true });
  };

  const confirmModel = () => {
    setVisible(false);
    if (modelTitle === "实名认证") {
      goFaceVerify();
    } else if (modelTitle === "绑定手机号") {
      navigate("/bind-mobile");
    }
  };

  const goFaceVerify = () => {
    let redirect = getHost() + "/auth/faceSuccess";
    user
      .TecentFaceVerify({
        s_url: redirect,
      })
      .then((res: any) => {
        saveBizToken(res.data.biz_token);
        saveRuleId(res.data.rule_id);
        window.location.href = res.data.url;
      })
      .catch((e) => {
        Toast.show(e.message || "无法发起实名认证");
      });
  };

  return (
    <div className={styles["container"]}>
      <NavHeader text="" noBorder />
      <div className={styles["password-login-form"]}>
        <div className={styles["password-login-title"]}>登录</div>
        <div className={styles["item"]}>
          <div className={styles["name"]}>手机号</div>
          <div className={styles["input"]}>
            <Input
              className={styles["input-text"]}
              placeholder="请输入手机号码"
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
          <div className={styles["name"]}>密码</div>
          <div className={styles["input"]}>
            <Input
              className={styles["input-text"]}
              type="password"
              placeholder="请输入密码"
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
      <div className="box border-box mt-15 pl-60 pr-60">
        <Button
          className={
            mobile && password
              ? `${styles["btn-confirm"]} ${styles["active"]}`
              : styles["btn-confirm"]
          }
          onClick={() => passwordLoginHandler()}
          loading={loading}
        >
          登录
        </Button>
      </div>
      {visible && (
        <ShowModel
          title={modelTitle}
          text={modelText}
          confirmText={confirmText}
          cancel={() => cancelModel()}
          change={() => confirmModel()}
        />
      )}
    </div>
  );
};

export default LoginPasswordPage;
