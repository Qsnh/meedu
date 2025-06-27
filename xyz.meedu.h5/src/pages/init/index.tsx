import { useState, useEffect } from "react";
import { useDispatch } from "react-redux";
import { Outlet, useLocation, useNavigate } from "react-router-dom";
import { saveConfigAction } from "../../store/system/systemConfigSlice";
import { loginAction } from "../../store/user/loginUserSlice";
import { ShowModel } from "../../components";
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

interface Props {
  loginData?: any;
  configData?: any;
}

export const InitPage = (props: Props) => {
  const navigate = useNavigate();
  const dispatch = useDispatch();
  const [init, setInit] = useState<boolean>(false);
  const [visible, setVisible] = useState(false);
  const [visible2, setVisible2] = useState(false);
  const [modelTitle, setModelTitle] = useState("");
  const [modelText, setModelText] = useState("");
  const [confirmText, setConfirmText] = useState("");
  const [verifyLoading, setVerifyLoading] = useState(false);
  const result = new URLSearchParams(useLocation().search);

  useEffect(() => {
    if (props.loginData && props.configData) {
      //检测是否开启强制绑定手机号
      if (
        props.loginData.is_bind_mobile === 0 && //未绑定手机号
        props.configData.member.enabled_mobile_bind_alert === 1 //已开启强制绑定手机号
      ) {
        setModelTitle("绑定手机号");
        setModelText("登录前请绑定手机号");
        setConfirmText("立即绑定");
        setVisible(true);
        return;
      }
      dispatch(loginAction(props.loginData));
      //检测是否开启强制实名认证+未进行实名认证
      let pathname = window.location.pathname;
      if (
        pathname !== "/auth/faceSuccess" && //非实名认证结果查询页面
        props.loginData.is_face_verify === false && //未完成实名认证
        props.configData.member.enabled_face_verify === true //已开启强制实名认证
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
    if (props.configData) {
      dispatch(saveConfigAction(props.configData));
      if (!isMobile()) {
        if (props.configData.pc_url !== "") {
          window.location.href = props.configData.pc_url;
        }
      }
    }
    setInit(true);
  }, [props]);

  useEffect(() => {
    if (result.get("login_code") && result.get("action") === "login") {
      CodeLogin(String(result.get("login_code")));
    }
  }, [result.get("action"), result.get("login_code")]);

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

  return (
    <>
      {init && <Outlet />}
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
