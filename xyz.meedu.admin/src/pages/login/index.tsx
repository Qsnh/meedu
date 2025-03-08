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
import { PermissionUtil } from "../../utils/permissionUtil";
import { MIAdministrator } from "../../types/permission";

const LoginPage = () => {
  document.title = "登录";
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [image, setImage] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [captchaVal, setCaptchaVal] = useState("");
  const [captchaKey, setCaptchaKey] = useState("");
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
      // 尝试登录
      const resData: IApiResponse<{ token: string }> = (await loginApi.login({
        username: email,
        password: password,
        image_key: captchaKey,
        image_captcha: captchaVal,
      })) as IApiResponse<{ token: string }>;
      // 登录成功=>保存token
      setToken(resData.data.token);
      // 登录成功后的一系列行文
      loginSuccessHandler();
    } catch (e) {
      console.error("错误信息", e);
      setLoading(false);
      fetchImageCaptcha();
    }
  };

  const getUser = async () => {
    const resData: IApiResponse<MIAdministrator> =
      (await loginApi.getUser()) as IApiResponse<MIAdministrator>;

    // 检查用户是否有任何可用权限
    if (!PermissionUtil.hasAnyPermission(resData.data.permissions)) {
      clearToken();
      throw new Error("计算跳转路径为空,无法继续登录!");
    }

    dispatch(loginAction(resData.data));
    return resData.data;
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

  const loginSuccessHandler = async () => {
    try {
      // 获取系统配置
      const resData: IApiResponse<SystemConfigStoreInterface> =
        (await system.getSystemConfig()) as IApiResponse<SystemConfigStoreInterface>;
      let config: SystemConfigStoreInterface = {
        system: {
          logo: resData.data.system.logo,
          url: {
            api: resData.data.system.url.api,
            h5: resData.data.system.url.h5,
            pc: resData.data.system.url.pc,
          },
        },
        video: {
          default_service: resData.data.video.default_service,
        },
      };
      dispatch(saveConfigAction(config));

      // 如果系统配置不完整，则跳转至编辑配置页面 => 也就是第一次使用系统
      if (
        !resData.data.system.url.api ||
        !resData.data.system.url.h5 ||
        !resData.data.system.url.pc
      ) {
        let token = getToken();
        setPreToken(token);
        clearToken();
        navigate("/edit-config");
        return;
      }

      // 获取系统已启用的插件模块
      await getAddons();

      // 获取当前登录管理员信息
      const userData = await getUser();

      // 根据当前管理员的权限计算登录成功后的跳转路径
      const targetPath = PermissionUtil.getFirstAvailablePath(
        userData.permissions
      );

      if (!targetPath) {
        throw new Error("无法确定跳转路径");
      }

      message.success("登录成功");
      navigate(targetPath, { replace: true });
    } catch (error) {
      clearToken(); // 清除token
      setLoading(false);
      if (error instanceof Error) {
        message.error(error.message);
      } else {
        message.error("登录失败，请重试");
      }
      console.error("Login error:", error);
    }
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
