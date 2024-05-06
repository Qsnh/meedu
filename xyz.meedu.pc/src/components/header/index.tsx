import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Skeleton, Input, Button, Dropdown, message, Menu } from "antd";
import type { MenuProps } from "antd";
import { Link, useNavigate, useLocation } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { saveUnread } from "../../store/user/loginUserSlice";
import vipIcon from "../../assets/img/commen/icon-VIP.png";
import studyIcon from "../../assets/img/study/icon-mystudy.png";
import { LoginDialog } from "../login-dailog";
import { RegisterDialog } from "../register-dialog";
import { WeixinLoginDialog } from "../weixin-login-dailog";
import { WexinBindMobileDialog } from "../weixin-bind-mobile-dialog";
import { ForgetPasswordDialog } from "../forget-password-dialog";
import { login, user as member } from "../../api/index";
import searchIcon from "../../assets/img/commen/icon-search.png";
import appConfig from "../../js/config";
import { clearBindMobileKey, clearFaceCheckKey, clearToken } from "../../utils";

export const Header = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [content, setContent] = useState("");
  // 全局状态的user
  const user = useSelector((state: any) => state.loginUser.value.user);
  // 全局状态-是否登录
  const isLogin = useSelector((state: any) => state.loginUser.value.isLogin);
  // 刷新-未读消息数量
  const freshUnread = useSelector(
    (state: any) => state.loginUser.value.freshUnread
  );
  const config = useSelector((state: any) => state.systemConfig.value.config);
  const configFunc = useSelector(
    (state: any) => state.systemConfig.value.configFunc
  );
  const navs = useSelector((state: any) => state.navsConfig.value.navs);
  const pathname = useLocation().pathname;
  const [loading, setLoading] = useState<boolean>(false);
  const [navLoading, setNavLoading] = useState<boolean>(true);
  const [visiale, setVisiale] = useState<boolean>(false);
  const [registerVisiale, setRegisterVisiale] = useState<boolean>(false);
  const [weixinVisiale, setWeixinVisiale] = useState<boolean>(false);
  const [weixinBindMobileVisiale, setWeixinBindMobileVisiale] =
    useState<boolean>(false);
  const [hasMessage, setHasMessage] = useState<boolean>(false);
  const [forgetVisiale, setForgetVisiale] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [current, setCurrent] = useState(pathname);

  useEffect(() => {
    if (pathname.indexOf("/courses/") !== -1) {
      setCurrent("/courses");
    } else if (pathname.indexOf("/live/") !== -1) {
      setCurrent("/live");
    } else if (pathname.indexOf("/topic/") !== -1) {
      setCurrent("/topic");
    } else if (pathname.indexOf("/book/") !== -1) {
      setCurrent("/book");
    } else if (pathname.indexOf("/learnPath/") !== -1) {
      setCurrent("/learnPath");
    } else if (pathname.indexOf("/wenda/") !== -1) {
      setCurrent("/wenda");
    } else if (pathname.indexOf("/exam/papers/") !== -1) {
      setCurrent("/exam/papers");
    } else if (pathname.indexOf("/exam/mockpaper/") !== -1) {
      setCurrent("/exam/mockpaper");
    } else if (pathname.indexOf("/exam/practice/") !== -1) {
      setCurrent("/exam/practice");
    } else {
      setCurrent(pathname);
    }
  }, [pathname]);

  useEffect(() => {
    if (isLogin && freshUnread) {
      getUnread();
    }
  }, [freshUnread, isLogin]);

  useEffect(() => {
    const arr: any = [];
    navs.map((item: any) => {
      if (
        item.url !== "/" &&
        pathname !== "/" &&
        pathname.indexOf(item.url) !== -1
      ) {
        setCurrent(item.url);
      }

      if (item.children.length > 0) {
        arr.push({
          label: (
            <span onClick={() => onMenuClick(item.url, item.blank)}>
              {item.name}
            </span>
          ),
          key: item.url,
          blank: item.blank,
          children: checkArr(item.children),
        });
      } else {
        arr.push({
          label: item.name,
          key: item.url,
          blank: item.blank,
        });
      }
    });
    setList(arr);
    setNavLoading(false);
  }, [navs]);

  const checkArr = (children: any) => {
    const arr: any = [];
    children.map((item: any) => {
      arr.push({
        label: item.name,
        key: item.url,
        blank: item.blank,
      });
    });
    return arr;
  };

  const getUnread = () => {
    member.unReadNum().then((res: any) => {
      let num = res.data;
      if (num === 0) {
        setHasMessage(false);
        dispatch(saveUnread(false));
      } else {
        setHasMessage(true);
      }
    });
  };

  const onSearch = (value: string) => {
    if (!value) {
      message.error("请输入关键字后再搜索");
      return;
    }
    setContent("");
    navigate(`/search?keywords=${value}`);
  };

  const onClick: MenuProps["onClick"] = ({ key }) => {
    if (key === "login_out") {
      if (loading) {
        return;
      }
      setLoading(true);
      login.logout().then(() => {
        message.success("已安全退出");
        clearToken();
        clearFaceCheckKey();
        clearBindMobileKey();
        setTimeout(() => {
          window.location.href = "/";
        }, 500);
      });
    } else if (key === "user_info") {
      navigate(`/member`);
    } else if (key === "user_messsage") {
      navigate(`/member/messages`);
    }
  };

  const items: MenuProps["items"] = [
    {
      label: "用户中心",
      key: "user_info",
    },
    {
      label: "我的消息",
      key: "user_messsage",
      icon: hasMessage ? <i className="messagePoint"></i> : "",
    },
    {
      label: "安全退出",
      key: "login_out",
    },
  ];

  const goStudy = () => {
    if (!isLogin) {
      goLogin();
      return;
    }
    navigate(`/study-center`);
  };

  const goLogin = () => {
    setVisiale(true);
  };

  const goRegister = () => {
    setRegisterVisiale(true);
  };

  const goForget = () => {
    setForgetVisiale(true);
  };

  const goWeixinLogin = () => {
    setWeixinVisiale(true);
  };

  const bindMobile = () => {
    setWeixinBindMobileVisiale(true);
  };

  const checkNav: MenuProps["onClick"] = (e: any) => {
    let blank = e.item.props.blank;
    if (e.key.match("https:") || e.key.match("http:")) {
      if (blank === 0) {
        window.location.href = e.key;
      } else {
        window.open(e.key);
      }
      return;
    }
    setCurrent(e.key);
    navigate(e.key);
  };

  const onMenuClick = (e: any, blank: number) => {
    if (e.match("https:") || e.match("http:")) {
      if (blank === 0) {
        window.location.href = e;
      } else {
        window.open(e);
      }
      return;
    }
    setCurrent(e);
    navigate(e);
  };

  return (
    <div className={styles["app-header"]}>
      <LoginDialog
        open={visiale}
        onCancel={() => {
          setVisiale(false);
        }}
        changeRegister={() => {
          setVisiale(false);
          goRegister();
        }}
        changeForget={() => {
          setVisiale(false);
          goForget();
        }}
        changeWeixin={() => {
          setVisiale(false);
          goWeixinLogin();
        }}
      />
      <RegisterDialog
        open={registerVisiale}
        onCancel={() => {
          setRegisterVisiale(false);
        }}
        changeLogin={() => {
          setRegisterVisiale(false);
          setVisiale(true);
        }}
      />
      <WeixinLoginDialog
        open={weixinVisiale}
        onCancel={() => {
          setWeixinVisiale(false);
        }}
        changeLogin={() => {
          setWeixinVisiale(false);
          setVisiale(true);
        }}
        bindMobile={() => {
          setWeixinVisiale(false);
          bindMobile();
        }}
      />
      <WexinBindMobileDialog
        open={weixinBindMobileVisiale}
        onCancel={() => {
          setWeixinBindMobileVisiale(false);
        }}
      />
      <ForgetPasswordDialog
        open={forgetVisiale}
        changeLogin={() => {
          setForgetVisiale(false);
          setVisiale(true);
        }}
        onCancel={() => {
          setForgetVisiale(false);
        }}
      />
      <div className={styles["main-header"]}>
        <div className={styles["top-header"]}>
          <Link to="/" className={styles["App-logo"]}>
            <img src={config.logo.logo} />
          </Link>
          <div className={styles["content-box"]}>
            <div className={styles["search-box"]}>
              <Input
                placeholder="请输入关键字"
                onChange={(e) => {
                  setContent(e.target.value);
                }}
                value={content}
                className={styles["search-input"]}
                onPressEnter={() => onSearch(content)}
              />
              <img
                className={styles["btn-search"]}
                onClick={() => onSearch(content)}
                src={searchIcon}
              />
            </div>
          </div>
          <div className={styles["user-box"]}>
            {configFunc.vip && !appConfig.disable_vip && (
              <Link to="/vip" className={styles["vip-icon"]}>
                <img
                  src={vipIcon}
                  width="20"
                  height="20"
                  style={{ margin: "0 auto" }}
                />
                <div className={styles["text"]}>VIP会员</div>
              </Link>
            )}
            <a onClick={() => goStudy()} className={styles["study-icon"]}>
              <img
                src={studyIcon}
                width="20"
                height="20"
                style={{ margin: "0 auto" }}
              />
              <div className={styles["text"]}>我的学习</div>
            </a>
            {isLogin ? null : (
              <>
                <a
                  onClick={() => goLogin()}
                  className="text-sm py-2 text-gray-500 hover:text-blue-600"
                >
                  登录
                </a>
                <span className="text-gray-300 mx-2">|</span>
                <a
                  onClick={() => goRegister()}
                  className="text-sm py-2 text-gray-500 hover:text-blue-600"
                >
                  注册
                </a>
              </>
            )}
            {isLogin && user ? (
              <Button.Group className={styles["button-group"]}>
                <Dropdown
                  menu={{ items, onClick }}
                  overlayStyle={{ minWidth: 120, textAlign: "center" }}
                  placement="bottomRight"
                >
                  <div className="d-flex" style={{ cursor: "pointer" }}>
                    <img
                      style={{ width: 40, height: 40, borderRadius: "50%" }}
                      src={user.avatar}
                    />
                    <span className="ml-8 c-admin">{user.name}</span>
                  </div>
                </Dropdown>
              </Button.Group>
            ) : null}
          </div>
        </div>
        <div className="header-menu">
          {navLoading ? (
            <Skeleton.Button
              style={{
                width: 600,
                height: 21,
                marginTop: 12,
                marginBottom: 12,
              }}
              active
            />
          ) : (
            <Menu
              onClick={checkNav}
              selectedKeys={[current]}
              mode="horizontal"
              items={list}
            />
          )}
        </div>
      </div>
    </div>
  );
};
