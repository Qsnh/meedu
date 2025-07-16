import { useState, useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Outlet, useLocation, useNavigate } from "react-router-dom";
import { loginAction } from "../../store/user/loginUserSlice";
import { RootState } from "../../store";
import { ShowModel, AgreementDialog } from "../../components";
import {
  isMobile,
  getHost,
  saveBizToken,
  saveRuleId,
  getToken,
  clearToken,
  setToken,
  saveTmpToken,
  getSessionLoginCode,
  saveSessionLoginCode,
  saveLoginCode,
  clearBizToken,
  clearRuleId,
} from "../../utils";
import { user, login } from "../../api/index";
import { logoutAction } from "../../store/user/loginUserSlice";

export const InitPage = () => {
  const navigate = useNavigate();
  const dispatch = useDispatch();
  const [init, setInit] = useState<boolean>(false);

  const configData = useSelector(
    (state: RootState) => state.systemConfig.value
  );

  const [loginData, setLoginData] = useState<any>(null);
  const [userDataLoaded, setUserDataLoaded] = useState<boolean>(false);

  const [visible, setVisible] = useState(false);
  const [visible2, setVisible2] = useState(false);
  const [modelTitle, setModelTitle] = useState("");
  const [modelText, setModelText] = useState("");
  const [confirmText, setConfirmText] = useState("");
  const [verifyLoading, setVerifyLoading] = useState(false);
  const [agreementVisible, setAgreementVisible] = useState(false);
  const urlSearchParams = new URLSearchParams(useLocation().search);

  useEffect(() => {
    const fetchUserData = async () => {
      const token = getToken();
      if (token) {
        try {
          const userRes: any = await user.detail();
          setLoginData(userRes.data);
        } catch (error) {
          console.error("用户信息获取失败", error);
          // 可选：清除无效的 token
          clearToken();
        }
      }
      setUserDataLoaded(true);
    };

    fetchUserData();
  }, []);

  // 修改现有的 useEffect
  useEffect(() => {
    if (!userDataLoaded) return;

    if (loginData && configData) {
      // 获取当前路径
      const currentPath = window.location.pathname;
      
      // 检查用户协议同意状态 - 最高优先级
      // 但在登录页面不弹出协议弹窗
      if (
        loginData.agreement_status && 
        (!loginData.agreement_status.user_agreement_agreed || 
         !loginData.agreement_status.privacy_policy_agreed) &&
        currentPath !== "/login" &&
        currentPath !== "/login-password"
      ) {
        setAgreementVisible(true);
        return;
      }

      //检测是否开启强制绑定手机号
      if (
        loginData.is_bind_mobile === 0 && //未绑定手机号
        configData.member.enabled_mobile_bind_alert === 1 //已开启强制绑定手机号
      ) {
        setModelTitle("绑定手机号");
        setModelText("登录前请绑定手机号");
        setConfirmText("立即绑定");
        setVisible(true);
        return;
      }
      dispatch(loginAction(loginData));
      //检测是否开启强制实名认证+未进行实名认证
      let pathname = window.location.pathname;
      if (
        pathname !== "/auth/faceSuccess" && //非实名认证结果查询页面
        loginData.is_face_verify === false && //未完成实名认证
        configData.member.enabled_face_verify === true //已开启强制实名认证
      ) {
        setModelTitle("实名认证");
        setModelText("登录前请完成实名认证");
        setConfirmText("立即认证");
        setVisible(true);
      } else {
        clearBizToken();
        clearRuleId();
      }
    }

    // 检查是否需要重定向到 PC 端
    if (configData && !isMobile()) {
      if (configData.pc_url !== "") {
        window.location.href = configData.pc_url;
      }
    }

    setInit(true);
  }, [loginData, configData, userDataLoaded, dispatch]);

  useEffect(() => {
    if (urlSearchParams.get("login_code") && urlSearchParams.get("action") === "login") {
      CodeLogin(String(urlSearchParams.get("login_code")));
    }
  }, [urlSearchParams.get("action"), urlSearchParams.get("login_code")]);

  const cancelModel = () => {
    dispatch(logoutAction());
    setVisible(false);
    setVisible2(false);
    setInit(true);
    navigate("/member", { replace: true });
  };

  const confirmModel = () => {
    setVisible(false);
    setInit(true);
    if (modelTitle === "实名认证") {
      goFaceVerify();
    } else if (modelTitle === "绑定手机号") {
      let token = getToken();
      saveTmpToken(token);
      clearToken();
      navigate("/bind-mobile");
    }
  };

  const goFaceVerify = () => {
    if (verifyLoading) {
      return;
    }
    setVerifyLoading(true);
    let redirect = getHost() + "/auth/faceSuccess";
    user
      .TecentFaceVerify({
        s_url: redirect,
      })
      .then((res: any) => {
        saveBizToken(res.data.biz_token);
        saveRuleId(res.data.rule_id);
        setVerifyLoading(false);
        window.location.href = res.data.url;
      });
  };

  const CodeLogin = (code: string) => {
    if (getSessionLoginCode(code)) {
      return;
    }
    saveSessionLoginCode(code);
    login.CodeLogin({ code: code }).then((res: any) => {
      if (res.data.success === 1) {
        setToken(res.data.token);
        window.location.reload();
      } else {
        if (res.data.action === "bind_mobile") {
          saveLoginCode(code);
          setModelTitle("绑定手机号");
          setModelText("登录前请绑定手机号");
          setConfirmText("立即绑定");
          setVisible2(true);
        }
      }
    });
  };

  const confirmModel2 = () => {
    setVisible2(false);
    setInit(true);
    navigate("/code-bind-mobile");
  };

  const cancelAgreement = () => {
    dispatch(logoutAction());
    setAgreementVisible(false);
    setInit(true);
    navigate("/member", { replace: true });
  };

  const confirmAgreement = () => {
    setAgreementVisible(false);
    // 重新获取用户数据以更新协议状态
    const fetchUserData = async () => {
      try {
        const userRes: any = await user.detail();
        setLoginData(userRes.data);
      } catch (error) {
        console.error("用户信息获取失败", error);
      }
    };
    fetchUserData();
  };

  return (
    <>
      {init && <Outlet />}
      {agreementVisible && (
        <AgreementDialog
          title="用户协议与隐私政策提示"
          confirmText="同意"
          cancel={cancelAgreement}
          change={confirmAgreement}
          agreementStatus={loginData.agreement_status}
        />
      )}
      {visible && (
        <ShowModel
          title={modelTitle}
          text={modelText}
          confirmText={confirmText}
          cancel={() => cancelModel()}
          change={() => confirmModel()}
        />
      )}
      {visible2 && (
        <ShowModel
          title={modelTitle}
          text={modelText}
          confirmText={confirmText}
          cancel={() => cancelModel()}
          change={() => confirmModel2()}
        />
      )}
    </>
  );
};
