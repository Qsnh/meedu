import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { useNavigate } from "react-router-dom";
import { Spin, Input, Button, message } from "antd";
import { useDispatch } from "react-redux";
import { login as loginApi, system } from "../../api/index";
import { loginAction } from "../../store/user/loginUserSlice";
import { setEnabledAddonsAction } from "../../store/enabledAddons/enabledAddonsConfigSlice";
import {
  saveConfigAction,
  SystemConfigStoreInterface,
} from "../../store/system/systemConfigSlice";
import { setToken, getToken, clearToken, setPreToken } from "../../utils/index";

const LoginPage = () => {
  document.title = "登录";
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);
  const [image, setImage] = useState<string>("");
  const [email, setEmail] = useState<string>("");
  const [password, setPassword] = useState<string>("");
  const [captchaVal, setCaptchaVal] = useState<string>("");
  const [captchaKey, setCaptchaKey] = useState<string>("");
  const [captchaLoading, setCaptchaLoading] = useState(true);

  useEffect(() => {
    fetchImageCaptcha();
  }, []);

  const fetchImageCaptcha = () => {
    setCaptchaVal("");
    setCaptchaLoading(true);

    system.getImageCaptcha().then((res: any) => {
      setImage(res.data.img);
      setCaptchaKey(res.data.key);
      setCaptchaLoading(false);
    });
  };

  const keyUp = (e: any) => {
    if (e.keyCode === 13) {
      loginSubmit();
    }
  };

  const loginSubmit = async () => {
    if (!email) {
      message.error("请输入管理员账号");
      return;
    }
    if (!password) {
      message.error("请输入账户密码");
      return;
    }
    if (!captchaVal) {
      message.error("请输入图形验证码");
      return;
    }
    await handleSubmit();
  };

  const handleSubmit = async () => {
    if (loading) {
      return;
    }
    setLoading(true);
    try {
      let res: any = await loginApi.login({
        username: email,
        password: password,
        image_key: captchaKey,
        image_captcha: captchaVal,
      });
      setToken(res.data.token); //将token写入本地
      getSystemConfig(); //获取系统配置并写入store
    } catch (e) {
      console.error("错误信息", e);
      setLoading(false);
      fetchImageCaptcha(); //刷新图形验证码
    }
  };

  const getUser = async () => {
    let res: any = await loginApi.getUser();
    dispatch(loginAction(res.data));
  };

  const getAddons = async () => {
    let addonsRes: any = await system.addonsList();
    let enabledAddons: any = {};
    let count = 0;
    for (let i = 0; i < addonsRes.data.length; i++) {
      if (addonsRes.data[i].enabled) {
        count += 1;
        enabledAddons[addonsRes.data[i].sign] = 1;
      }
    }
    dispatch(setEnabledAddonsAction({ addons: enabledAddons, count: count }));
  };

  const getSystemConfig = async () => {
    let res: any = await system.getSystemConfig();
    let config: SystemConfigStoreInterface = {
      system: {
        logo: res.data.system.logo,
        url: {
          api: res.data.system.url.api,
          h5: res.data.system.url.h5,
          pc: res.data.system.url.pc,
        },
      },
      video: {
        default_service: res.data.video.default_service,
      },
    };
    dispatch(saveConfigAction(config));
    if (
      !res.data.system.url.api ||
      !res.data.system.url.h5 ||
      !res.data.system.url.pc
    ) {
      let token = getToken();
      setPreToken(token);
      clearToken();
      navigate("/edit-config");
      return;
    }
    await getUser(); //获取登录用户的信息并写入store
    await getAddons(); //获取权限

    navigate("/", { replace: true });
  };

  return (
    <div className={styles["login-container"]}>
      <div className={styles["left_content"]}></div>
      <div className={styles["right_content"]}>
        <div className={styles["title"]}>登录后台</div>
        <div className={styles["login-box"]}>
          <Input
            value={email}
            onChange={(e) => {
              setEmail(e.target.value);
            }}
            style={{
              width: 400,
              height: 48,
              borderRadius: 4,
              border: "1px solid #e5e5e5",
            }}
            placeholder="请输入管理员账号"
            onKeyUp={(e) => keyUp(e)}
            allowClear
          />
        </div>
        <div className="login-box d-flex mt-50">
          <Input.Password
            value={password}
            onChange={(e) => {
              setPassword(e.target.value);
            }}
            allowClear
            style={{
              width: 400,
              height: 48,
              borderRadius: 4,
              border: "1px solid #e5e5e5",
            }}
            placeholder="请输入账户密码"
          />
        </div>
        <div className="d-flex mt-50">
          <Input
            value={captchaVal}
            style={{
              width: 250,
              height: 48,
              borderRadius: 4,
              border: "1px solid #e5e5e5",
            }}
            placeholder="请输入图形验证码"
            onChange={(e) => {
              setCaptchaVal(e.target.value);
            }}
            allowClear
            onKeyUp={(e) => keyUp(e)}
          />
          <div className={styles["captcha-box"]}>
            {captchaLoading && (
              <div className={styles["catpcha-loading-box"]}>
                <Spin size="small" />
              </div>
            )}

            {!captchaLoading && (
              <img
                className={styles["captcha"]}
                onClick={fetchImageCaptcha}
                src={image}
              />
            )}
          </div>
        </div>
        <div className="login-box d-flex mt-50">
          <Button
            style={{ width: 400, height: 54 }}
            type="primary"
            onClick={loginSubmit}
            loading={loading}
          >
            立即登录
          </Button>
        </div>
      </div>
    </div>
  );
};

export default LoginPage;
