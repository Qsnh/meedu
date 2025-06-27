import { useState, useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import type { RootState } from "../../store";
import type { SystemConfig, NavItem } from "../../store/system/systemConfigSlice";
import { useNavigate, Outlet, useSearchParams } from "react-router-dom";
import { loginAction } from "../../store/user/loginUserSlice";
import {
  saveConfigAction,
  saveConfigFuncAction,
} from "../../store/system/systemConfigSlice";
import { saveNavsAction } from "../../store/nav-menu/navMenuConfigSlice";
import { BackTop, CodeLoginBindMobileDialog } from "../../components";
import { user, login } from "../../api";
import {
  saveMsv,
  getMsv,
  clearMsv,
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
import { Spin } from "antd";

interface Props {
  config: SystemConfig;
  configFunc: {
    vip: boolean;
    live: boolean;
    book: boolean;
    topic: boolean;
    paper: boolean;
    practice: boolean;
    mockPaper: boolean;
    wrongBook: boolean;
    wenda: boolean;
    share: boolean;
    codeExchanger: boolean;
    snapshort: boolean;
    ke: boolean;
    promoCode: boolean;
    daySignIn: boolean;
    credit1Mall: boolean;
    tuangou: boolean;
    miaosha: boolean;
    cert: boolean;
  };
  navsData: NavItem[];
}

export const InitPage = (props: Props) => {
  const navigate = useNavigate();
  const dispatch = useDispatch();

  // ------ store变量 ------
  const isLogin = useSelector((state: RootState) => state.loginUser.value.isLogin);

  // ------ URL变量 ------
  const [searchParams] = useSearchParams();
  const urlMsv = searchParams.get("msv");
  const urlLoginCode = searchParams.get("login_code");
  const urlAction = searchParams.get("action");
  const urlRedirectUrl = decodeURIComponent(
    searchParams.get("redirect") || "/"
  );

  // ------ 本地变量 ------
  const loginToken = getToken();
  const [backTopStatus, setBackTopStatus] = useState(false);
  const [codebindmobileVisible, setCodebindmobileVisible] = useState(false);

  // 滚动条监听
  useEffect(() => {
    const getHeight = () => {
      let scrollTop =
        document.documentElement.scrollTop || document.body.scrollTop;
      setBackTopStatus(scrollTop >= 2000);
    };
    window.addEventListener("scroll", getHeight, true);
    return () => {
      window.removeEventListener("scroll", getHeight, true);
    };
  }, []);

  // msv(分销识别符)的保存
  useEffect(() => {
    urlMsv && saveMsv(urlMsv);
  }, [urlMsv]);

  useEffect(() => {
    if (urlLoginCode && urlAction === "login") {
      codeLogin(urlLoginCode, urlRedirectUrl);
    }
  }, [urlLoginCode, urlAction, urlRedirectUrl]);

  // 使用code登录系统
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
        user.detail().then((res: any) => {
          let loginData = res.data;
          // 将学员数据存储到store
          dispatch(loginAction(loginData));
          // 登录成功之后的跳转
          if (window.location.pathname === "/login/callback") {
            // 社交登录回调指定的跳转地址
            navigate(redirectUrl, { replace: true });
          } else {
            // 直接reload当前登录表单所在页面
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

  const msvBind = () => {
    let msv = getMsv();
    if (!msv) {
      return;
    }
  };

  useEffect(() => {
    // 存在token-做自动登录
    loginToken &&
      user
        .detail()
        .then((res: any) => {
          let resUser = res.data as UserDetailInterface;
          // 强制绑定手机号
          if (
            resUser.is_bind_mobile === 0 &&
            props.config.member.enabled_mobile_bind_alert === 1
          ) {
            setBindMobileKey();
          } else {
            clearBindMobileKey();
          }

          //强制实名认证
          if (
            resUser.is_face_verify === false &&
            props.config.member.enabled_face_verify === true
          ) {
            setFaceCheckKey();
          } else {
            clearFaceCheckKey();
          }

          // 自动登录
          dispatch(loginAction(resUser));

          msvBind();
        })
        .catch((e) => {});
  }, [loginToken]);

  if (props.config) {
    dispatch(saveConfigAction(props.config));

    // 手机设备访问PC站点 && 配置了H5站点的地址
    if (isMobile() && props.config.h5_url) {
      let url = props.config.h5_url;
      let curPathname = window.location.pathname;
      let curSearch = window.location.search || "";

      if (curPathname.indexOf("/topic/detail") !== -1) {
        let id = curPathname.slice(14);
        if (curSearch === "") {
          url += "/#/pages/webview/webview?course_type=topic&id=" + id;
        } else {
          url +=
            "/#/pages/webview/webview" +
            curSearch +
            "&course_type=topic&id=" +
            id;
        }
      } else if (curPathname.indexOf("/courses/detail") !== -1) {
        let id = curPathname.slice(16);
        if (curSearch === "") {
          url += "/#/pages/course/show?id=" + id;
        } else {
          url += "/#/pages/course/show" + curSearch + "&id=" + id;
        }
      } else if (curPathname.indexOf("/courses/video") !== -1) {
        let id = curPathname.slice(15);
        if (curSearch === "") {
          url += "/#/pages/course/video?id=" + id;
        } else {
          url += "/#/pages/course/video" + curSearch + "&id=" + id;
        }
      } else if (curPathname.indexOf("/live/detail") !== -1) {
        let id = curPathname.slice(13);
        if (curSearch === "") {
          url += "/#/packageA/live/show?id=" + id;
        } else {
          url += "/#/packageA/live/show" + curSearch + "&id=" + id;
        }
      } else if (curPathname.indexOf("/live/video") !== -1) {
        let id = curPathname.slice(12);
        if (curSearch === "") {
          url += "/#/packageA/live/video?id=" + id;
        } else {
          url += "/#/packageA/live/video" + curSearch + "&id=" + id;
        }
      } else if (curPathname.indexOf("/book/detail") !== -1) {
        let id = curPathname.slice(13);
        if (curSearch === "") {
          url += "/#/packageA/book/show?id=" + id;
        } else {
          url += "/#/packageA/book/show" + curSearch + "&id=" + id;
        }
      } else if (curPathname.indexOf("/book/read") !== -1) {
        let id = curPathname.slice(11);
        if (curSearch === "") {
          url += "/#/pages/webview/webview?course_type=book&id=" + id;
        } else {
          url +=
            "/#/pages/webview/webview" +
            curSearch +
            "&course_type=book&id=" +
            id;
        }
      } else if (curPathname.indexOf("/learnPath/detail") !== -1) {
        let id = curPathname.slice(18);
        if (curSearch === "") {
          url += "/#/packageA/learnPath/show?id=" + id;
        } else {
          url += "/#/packageA/learnPath/show" + curSearch + "&id=" + id;
        }
      } else if (curPathname.indexOf("/exam/papers/detail") !== -1) {
        let id = curPathname.slice(20);
        if (curSearch === "") {
          url += "/#/pages/webview/webview?course_type=paperRead&id=" + id;
        } else {
          url +=
            "/#/pages/webview/webview" +
            curSearch +
            "&course_type=paperRead&id=" +
            id;
        }
      } else if (curPathname.indexOf("/exam/practice/detail") !== -1) {
        let id = curPathname.slice(22);
        if (curSearch === "") {
          url += "/#/pages/webview/webview?course_type=practiceRead&id=" + id;
        } else {
          url +=
            "/#/pages/webview/webview" +
            curSearch +
            "&course_type=practiceRead&id=" +
            id;
        }
      } else if (curPathname.indexOf("/exam/mockpaper/detail") !== -1) {
        let id = curPathname.slice(23);
        if (curSearch === "") {
          url += "/#/pages/webview/webview?course_type=mockRead&id=" + id;
        } else {
          url +=
            "/#/pages/webview/webview" +
            curSearch +
            "&course_type=mockRead&id=" +
            id;
        }
      }

      // 如果存在msv的话则携带上msv(邀请学员的id)
      if (urlMsv) {
        url = SPAUrlAppend(props.config.h5_url, "msv=" + urlMsv);
      }

      // 跳转到手机访问地址
      window.location.href = url;
    }
  }

  if (props.configFunc) {
    dispatch(saveConfigFuncAction(props.configFunc));
  }

  if (props.navsData) {
    dispatch(saveNavsAction(props.navsData));
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

      <div style={{ minHeight: 800 }}>
        <Outlet />
      </div>

      {backTopStatus ? <BackTop></BackTop> : null}
    </>
  );
};
