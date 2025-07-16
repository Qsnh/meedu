import React, { useState, useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useSearchParams, useNavigate } from "react-router-dom";
import { Spin } from "antd";
import type { RootState } from "../../store";
import { system, home, user as userApi, login } from "../../api";
import { loginAction, closeAgreementDialog } from "../../store/user/loginUserSlice";
import {
  saveConfigAction,
  saveConfigFuncAction,
} from "../../store/system/systemConfigSlice";
import { saveNavsAction } from "../../store/nav-menu/navMenuConfigSlice";
import { CodeLoginBindMobileDialog, UserAgreementDialog } from "../index";
import {
  saveMsv,
  getMsv,
  saveSessionLoginCode,
  getSessionLoginCode,
  setToken,
  saveLoginCode,
  isMobile,
  SPAUrlAppend,
  getToken,
  setBindMobileKey,
  clearBindMobileKey,
  setFaceCheckKey,
  clearFaceCheckKey,
} from "../../utils/index";

const defaultConfigFunc: AppFeatureInterface = {
  vip: true,
  live: false,
  book: false,
  topic: false,
  paper: false,
  practice: false,
  mockPaper: false,
  wrongBook: false,
  wenda: false,
  share: false,
  codeExchanger: false,
  snapshort: false,
  ke: false,
  promoCode: false,
  daySignIn: false,
  credit1Mall: false,
  tuangou: false,
  miaosha: false,
  cert: false,
};

interface ConfigLoaderProps {
  children: React.ReactNode;
}

export const ConfigLoader: React.FC<ConfigLoaderProps> = ({ children }) => {
  const navigate = useNavigate();
  const dispatch = useDispatch();

  // Store状态
  const isLogin = useSelector(
    (state: RootState) => state.loginUser.value.isLogin
  );
  const user = useSelector(
    (state: RootState) => state.loginUser.value.user
  );
  const systemConfig = useSelector(
    (state: RootState) => state.systemConfig.value.config
  );
  const showAgreementDialog = useSelector(
    (state: RootState) => state.loginUser.value.showAgreementDialog
  );

  // URL参数
  const [searchParams] = useSearchParams();
  const urlLoginCode = searchParams.get("login_code");
  const urlAction = searchParams.get("action");
  const urlRedirectUrl = decodeURIComponent(
    searchParams.get("redirect") || "/"
  );

  // 本地状态
  const [isConfigLoaded, setIsConfigLoaded] = useState(false);
  const [isConfigLoading, setIsConfigLoading] = useState(true);
  const [codebindmobileVisible, setCodebindmobileVisible] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const loginToken = getToken();

  const loadSystemConfig = async () => {
    try {
      setIsConfigLoading(true);
      setError(null);

      // 并行获取系统配置和导航数据
      const [configRes, navsRes] = await Promise.all([
        system.config(),
        home.headerNav(),
      ]);

      const systemConfigData = (configRes as ResponseInterface)
        .data as AppConfigInterface;
      const navsData = (navsRes as ResponseInterface).data;

      // 写入store
      dispatch(saveConfigAction(systemConfigData));
      dispatch(saveConfigFuncAction(defaultConfigFunc));
      dispatch(saveNavsAction(navsData));

      // 处理移动端重定向
      handleMobileRedirect(systemConfigData);

      setIsConfigLoaded(true);
    } catch (err) {
      console.error("系统配置加载失败", err);
      setError("系统配置加载失败，请刷新重试");
    } finally {
      setIsConfigLoading(false);
    }
  };

  const handleMobileRedirect = (config: AppConfigInterface) => {
    // 手机设备访问PC站点 && 配置了H5站点的地址
    if (isMobile() && config.h5_url) {
      window.location.href = config.h5_url;
    }
  };

  const handleAgreementAgree = async () => {
    try {
      // 关闭弹窗
      dispatch(closeAgreementDialog());
      
      // 重新获取用户信息
      const res = await userApi.detail();
      let resUser = (res as ResponseInterface).data as UserDetailInterface;
      dispatch(loginAction(resUser));
    } catch (error) {
      console.error("更新协议状态失败", error);
    }
  };

  const codeLogin = (code: string, redirectUrl: string) => {
    // 防止code重复请求登录
    if (getSessionLoginCode(code)) {
      return;
    }
    saveSessionLoginCode(code);

    // 请求登录接口
    login.codeLogin({ code: code, msv: getMsv() }).then((res: any) => {
      if (res.data.success === 1) {
        setToken(res.data.token);
        userApi.detail().then((res: any) => {
          let loginData = res.data;
          dispatch(loginAction(loginData));

          // 登录成功之后的跳转
          if (window.location.pathname === "/login/callback") {
            navigate(redirectUrl, { replace: true });
          } else {
            let path = window.location.pathname + window.location.search;
            navigate(path, { replace: true });
          }
        });
      } else {
        if (res.data.action === "bind_mobile") {
          saveLoginCode(code);
          setCodebindmobileVisible(true);
        }
      }
    });
  };

  const handleAutoLogin = async () => {
    if (!loginToken || !systemConfig) return;

    try {
      const res = await userApi.detail();
      let resUser = (res as ResponseInterface).data as UserDetailInterface;

      // 强制绑定手机号
      if (
        resUser.is_bind_mobile === 0 &&
        systemConfig.member.enabled_mobile_bind_alert === 1
      ) {
        setBindMobileKey();
      } else {
        clearBindMobileKey();
      }

      // 强制实名认证
      if (
        resUser.is_face_verify === false &&
        systemConfig.member.enabled_face_verify === true
      ) {
        setFaceCheckKey();
      } else {
        clearFaceCheckKey();
      }

      // 自动登录
      dispatch(loginAction(resUser));
    } catch (e) {
      console.error("自动登录失败", e);
    }
  };

  // 初始化加载系统配置
  useEffect(() => {
    loadSystemConfig();
  }, []);

  useEffect(() => {
    if (urlLoginCode && urlAction === "login") {
      codeLogin(urlLoginCode, urlRedirectUrl);
    }
  }, [urlLoginCode, urlAction, urlRedirectUrl]);

  useEffect(() => {
    if (isConfigLoaded && systemConfig) {
      handleAutoLogin();
    }
  }, [isConfigLoaded, systemConfig, loginToken]);

  // 配置加载中
  if (isConfigLoading) {
    return (
      <div
        style={{
          width: "100vw",
          height: "100vh",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
        }}
      >
        <Spin size="large" />
      </div>
    );
  }

  // 配置加载失败
  if (error) {
    return (
      <div
        style={{
          width: "100vw",
          height: "100vh",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
          flexDirection: "column",
        }}
      >
        <p>{error}</p>
        <button onClick={loadSystemConfig}>重新加载</button>
      </div>
    );
  }

  if (loginToken && isLogin === false) {
    return (
      <div
        style={{
          width: "100vw",
          height: "100vh",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
        }}
      >
        <Spin size="large" />
      </div>
    );
  }

  return (
    <>
      <CodeLoginBindMobileDialog
        scene="mobile_bind"
        open={codebindmobileVisible}
        onCancel={() => setCodebindmobileVisible(false)}
        success={() => {
          setCodebindmobileVisible(false);
        }}
      />
      
      {/* 用户协议弹窗 */}
      <UserAgreementDialog
        open={showAgreementDialog}
        onAgree={handleAgreementAgree}
        userAgreementAgreed={user?.agreement_status?.user_agreement_agreed || false}
        privacyPolicyAgreed={user?.agreement_status?.privacy_policy_agreed || false}
      />
      
      {children}
    </>
  );
};

export default ConfigLoader;
