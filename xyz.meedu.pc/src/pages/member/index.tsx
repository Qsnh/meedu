import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Input, Modal, message, Upload } from "antd";
import type { UploadProps } from "antd";
import { useDispatch, useSelector } from "react-redux";
import { useSearchParams } from "react-router-dom";
import { system, login, user as member } from "../../api/index";
import { NavMember } from "../../components";
import config from "../../js/config";
import {
  getToken,
  saveSessionLoginCode,
  getSessionLoginCode,
  getShareHost,
} from "../../utils/index";
import { loginAction } from "../../store/user/loginUserSlice";
import { saveConfigAction } from "../../store/system/systemConfigSlice";
import { MobileVerifyDialog } from "./components/mobile-verify-dialog";
import { BindMobileDialog } from "./components/bind-mobile";
import { BindNewMobileDialog } from "./components/bind-new-mobile";
import { ChangePasswordDialog } from "./components/change-password";
import { DestroyUserDialog } from "./components/destroy-user";
import { BindWeixinDialog } from "./components/bind-weixin";
import { ProfileComp } from "./components/profile";
import qqIcon from "../../assets/img/commen/icon-qq.png";
import wxIcon from "../../assets/img/commen/icon-wechat.png";

const { confirm } = Modal;

const MemberPage = () => {
  document.title = "学员中心";
  const dispatch = useDispatch();

  // --------- store变量 ---------
  // 当前登录学员
  const user = useSelector((state: any) => state.loginUser.value.user);
  // 系统配置
  const systemConfig = useSelector(
    (state: any) => state.systemConfig.value.config
  );
  // 系统启用的功能
  const configFunc = useSelector(
    (state: any) => state.systemConfig.value.configFunc
  );

  // --------- URL变量 ---------
  const [searchParams] = useSearchParams();
  const loginCode = searchParams.get("login_code");
  const urlLoginAction = searchParams.get("action");
  const loginErrMsg = searchParams.get("login_err_msg");

  // --------- 页面变量 ---------
  const [loading, setLoading] = useState(false);
  const [editNickStatus, setEditNickStatus] = useState(false);
  const [mobileValidateVisible, setMobileValidateVisible] = useState(false);
  const [bindMobileSign, setBindMobileSign] = useState("");
  const [bindMobileVisible, setBindMobileVisible] = useState(false);
  const [bindNewMobileVisible, setBindNewMobileVisible] = useState(false);
  const [changePasswordVisible, setChangePasswordVisible] = useState(false);
  const [destroyUserVisible, setDestroyUserVisible] = useState(false);
  const [bindWeixinVisible, setBindWeixinVisible] = useState(false);
  const [signStatus, setSignStatus] = useState(false);
  const [app, setApp] = useState("");

  const [currentTab, setCurrentTab] = useState(1);
  const [nickName, setNickName] = useState<string>(user && user.nick_name);
  const tabs = [
    {
      name: "基本信息",
      id: 1,
    },
    {
      name: "实名认证",
      id: 2,
    },
  ];

  useEffect(() => {
    resetData();
  }, []);

  useEffect(() => {
    if (loginCode && urlLoginAction === "bind") {
      codeBind(loginCode);
    }
  }, [loginCode, urlLoginAction]);

  useEffect(() => {
    loginErrMsg && message.error(loginErrMsg);
  }, [loginErrMsg]);

  const codeBind = (code: string) => {
    if (getSessionLoginCode(code)) {
      return;
    }
    saveSessionLoginCode(code);
    login.codeBind({ code: code }).then((res: any) => {
      message.success("绑定成功");
      resetData();
      getConfig();
    });
  };

  const destroyUser = () => {
    setDestroyUserVisible(true);
  };

  const tabChange = (id: number) => {
    setCurrentTab(id);
  };

  const resetData = () => {
    setEditNickStatus(false);
    member.detail().then((res: any) => {
      let loginData = res.data;
      setNickName(loginData.nick_name);
      dispatch(loginAction(loginData));
    });
  };

  const getConfig = () => {
    system.config().then((res: any) => {
      let config = res.data;
      dispatch(saveConfigAction(config));
    });
  };

  const saveEditNick = () => {
    if (!nickName) {
      message.error("请输入昵称");
      return;
    }
    if (loading) {
      return;
    }
    setLoading(true);
    member
      .nicknameChange({ nick_name: nickName })
      .then(() => {
        setLoading(false);
        message.success("修改成功");
        resetData();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const avatarUploadProps: UploadProps = {
    name: "file",
    multiple: false,
    method: "POST",
    action: config.app_url + "/api/v2/member/detail/avatar",
    headers: {
      Accept: "application/json",
      authorization: "Bearer " + getToken(),
    },
    beforeUpload: (file) => {
      const isPNG =
        file.type === "image/png" ||
        file.type === "image/jpg" ||
        file.type === "image/jpeg";
      if (!isPNG) {
        message.error(`${file.name}不是图片文件`);
        return Upload.LIST_IGNORE;
      }

      if (file.size > 2 * 1024 * 1024) {
        message.error("图片大小不超过2M");
        return Upload.LIST_IGNORE;
      }

      return true;
    },
    onChange(info: any) {
      const { status, response } = info.file;
      if (status === "done") {
        if (response.code === 0) {
          message.success("上传头像成功");
          resetData();
          return;
        } else {
          message.error(response.msg);
        }
      } else if (status === "error") {
        message.error(`${info.file.name} 上传失败`);
      }
    },
  };

  const goChangeMobile = () => {
    setMobileValidateVisible(true);
  };

  const successMobileValidate = (sign: string) => {
    setBindMobileSign(sign);
    setMobileValidateVisible(false);
    setBindMobileVisible(true);
  };

  const goBindMobile = () => {
    setBindNewMobileVisible(true);
  };

  const goChangePassword = () => {
    if (user.is_bind_mobile !== 1) {
      message.error("请绑定手机号");
      return;
    }
    setChangePasswordVisible(true);
  };

  const goBindQQ = () => {
    let host = getShareHost() + "member";
    let token = getToken();
    let redirect = encodeURIComponent(host);
    window.location.href =
      systemConfig.url +
      "/api/v3/auth/login/socialite/qq?s_url=" +
      redirect +
      "&f_url=" +
      redirect +
      "&action=bind";
  };

  const cancelBindQQ = () => {
    setApp("qq");
    confirm({
      title: "解绑账号",
      content:
        "解绑账号后请立即绑定其他社交账号，不然可能导致无法找回原账号，确认操作？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        member.cancelBind("qq").then((res: any) => {
          message.success("解绑成功");
          resetData();
          getConfig();
        });
      },
      onCancel() {
        console.log("Cancel");
      },
    });
  };

  const goBindWeixin = () => {
    setBindWeixinVisible(true);
  };

  const cancelBindWeixin = () => {
    setApp("wechat");
    confirm({
      title: "解绑账号",
      content:
        "解绑账号后请立即绑定其他社交账号，不然可能导致无法找回原账号，确认操作？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        member.cancelBind("wechat").then((res: any) => {
          message.success("解绑成功");
          resetData();
          getConfig();
        });
      },
      onCancel() {
        console.log("Cancel");
      },
    });
  };

  return (
    <div className="container">
      <DestroyUserDialog
        open={destroyUserVisible}
        onCancel={() => setDestroyUserVisible(false)}
      ></DestroyUserDialog>
      <ChangePasswordDialog
        scene="password_reset"
        open={changePasswordVisible}
        mobile={user.mobile}
        onCancel={() => setChangePasswordVisible(false)}
        success={() => {
          setChangePasswordVisible(false);
          resetData();
        }}
      ></ChangePasswordDialog>
      <MobileVerifyDialog
        scene="mobile_bind"
        open={mobileValidateVisible}
        mobile={user.mobile}
        onCancel={() => setMobileValidateVisible(false)}
        success={(sign: string) => successMobileValidate(sign)}
      ></MobileVerifyDialog>
      <BindMobileDialog
        scene="mobile_bind"
        open={bindMobileVisible}
        sign={bindMobileSign}
        onCancel={() => setBindMobileVisible(false)}
        success={() => {
          setBindMobileVisible(false);
          resetData();
        }}
      ></BindMobileDialog>
      <BindNewMobileDialog
        scene="mobile_bind"
        open={bindNewMobileVisible}
        active={false}
        onCancel={() => setBindNewMobileVisible(false)}
        success={() => {
          setBindNewMobileVisible(false);
          resetData();
        }}
      ></BindNewMobileDialog>
      <BindWeixinDialog
        open={bindWeixinVisible}
        onCancel={() => setBindWeixinVisible(false)}
        success={() => {
          setBindWeixinVisible(false);
          resetData();
          getConfig();
        }}
      ></BindWeixinDialog>
      <div className={styles["box"]}>
        <NavMember cid={0} refresh={true}></NavMember>
        <div className={styles["project-box"]}>
          <div className={styles["user-box"]}>
            <div className={styles["avatar"]}>
              <img src={user.avatar} />
            </div>
            <div className={styles["user-info"]}>
              <div className={styles["user-top"]}>
                <div className={styles["nickname"]}>{user.nick_name}</div>
                {user.role_id !== 0 && user.role && (
                  <div className={styles["role"]}>VIP</div>
                )}
              </div>
              {user.role_id !== 0 && user.role_expired_at && (
                <div className={styles["expiration-time"]}>
                  会员有效期至{user.role_expired_at}
                </div>
              )}
            </div>
            <div className={styles["value-box"]}>
              <div className={styles["item"]}></div>
              <div className={styles["item"]}></div>
              <div className={styles["item"]}>
                <div className={styles["value"]}>{user.credit1}</div>
                <div className={styles["name"]}>我的积分</div>
              </div>
            </div>
          </div>
          <div className={styles["user-profile"]}>
            <div className={styles["del-user"]} onClick={() => destroyUser()}>
              注销账号
            </div>
            <div className="member-tabs">
              {tabs.map((item: any) => (
                <div
                  key={item.id}
                  className={
                    currentTab === item.id ? "active item-tab" : "item-tab"
                  }
                  onClick={() => tabChange(item.id)}
                >
                  {item.name}
                  {currentTab === item.id && <div className="actline"></div>}
                </div>
              ))}
            </div>
            {currentTab === 1 && (
              <div className={styles["project-content"]}>
                <div className={styles["item-line"]}>
                  <div className={styles["item-left"]}>
                    <div className={styles["item-name"]}>我的头像</div>
                    <div className={styles["item-avatar"]}>
                      <Upload
                        className={styles["avatar"]}
                        {...avatarUploadProps}
                        showUploadList={false}
                      >
                        <img className={styles["avatar"]} src={user.avatar} />
                      </Upload>
                    </div>
                  </div>
                  <div className={styles["item-right"]}>
                    <div className={styles["tip"]}>点击图片修改</div>
                  </div>
                </div>
                <div className={styles["item-line"]}>
                  <div className={styles["item-left"]}>
                    <div className={styles["item-name"]}>我的昵称</div>
                    {editNickStatus && (
                      <div className={styles["item-value"]}>
                        <Input
                          className={styles["input"]}
                          placeholder="昵称"
                          value={nickName}
                          onChange={(e) => {
                            setNickName(e.target.value);
                          }}
                        ></Input>
                      </div>
                    )}
                    {!editNickStatus && (
                      <div className={styles["item-value"]}>
                        {user.nick_name}
                      </div>
                    )}
                  </div>
                  <div className={styles["item-right"]}>
                    {user.is_set_nickname === 0 && editNickStatus && (
                      <div
                        className={styles["act-btn"]}
                        onClick={() => saveEditNick()}
                      >
                        保存
                      </div>
                    )}
                    {user.is_set_nickname === 0 && !editNickStatus && (
                      <div
                        className={styles["btn"]}
                        onClick={() => setEditNickStatus(true)}
                      >
                        修改
                      </div>
                    )}
                    {user.is_set_nickname === 1 && (
                      <div className={styles["btn"]}>已修改</div>
                    )}
                    {user.is_set_nickname === 0 && (
                      <div className={styles["tip"]}>（只可修改一次）</div>
                    )}
                  </div>
                </div>
                <div className={styles["item-line"]}>
                  <div className={styles["item-left"]}>
                    <div className={styles["item-name"]}>手机号码</div>
                    {user.is_bind_mobile === 1 && (
                      <div className={styles["item-value"]}>
                        {user.mobile.substr(0, 3) +
                          "****" +
                          user.mobile.substr(7)}
                      </div>
                    )}
                  </div>
                  <div className={styles["item-right"]}>
                    {user.is_bind_mobile === 1 && (
                      <div
                        className={styles["btn"]}
                        onClick={() => goChangeMobile()}
                      >
                        换绑手机号
                      </div>
                    )}
                    {user.is_bind_mobile !== 1 && (
                      <div
                        className={styles["btn"]}
                        onClick={() => goBindMobile()}
                      >
                        绑定手机号
                      </div>
                    )}
                  </div>
                </div>
                <div className={styles["item-line"]}>
                  <div className={styles["item-left"]}>
                    <div className={styles["item-name"]}>设置(修改)密码</div>
                  </div>
                  <div className={styles["item-right"]}>
                    <div
                      className={styles["btn"]}
                      onClick={() => goChangePassword()}
                    >
                      点击设置（修改）密码
                    </div>
                  </div>
                </div>

                {systemConfig.socialites.qq === 1 && (
                  <div className={styles["item-line"]}>
                    <div className={styles["item-left"]}>
                      <div className={styles["item-name"]}>
                        <img src={qqIcon} />
                        绑定QQ
                      </div>
                      {user.is_bind_qq === 1 && (
                        <div className={styles["item-value"]}>已绑定</div>
                      )}
                      {user.is_bind_qq === 0 && (
                        <div
                          className={styles["sp-btn"]}
                          onClick={() => goBindQQ()}
                        >
                          点击绑定
                        </div>
                      )}
                    </div>
                    <div className={styles["item-right"]}>
                      {user.is_bind_qq === 1 && (
                        <div
                          className={styles["btn"]}
                          onClick={() => cancelBindQQ()}
                        >
                          解绑账号
                        </div>
                      )}
                    </div>
                  </div>
                )}

                {systemConfig.socialites.wechat_oauth === 1 && (
                  <div className={styles["item-line"]}>
                    <div className={styles["item-left"]}>
                      <div className={styles["item-name"]}>
                        <img src={wxIcon} />
                        绑定微信
                      </div>
                      {user.is_bind_wechat === 1 && (
                        <div className={styles["item-value"]}>已绑定</div>
                      )}
                      {user.is_bind_wechat === 0 && (
                        <div
                          className={styles["sp-btn"]}
                          onClick={() => goBindWeixin()}
                        >
                          点击绑定
                        </div>
                      )}
                    </div>
                    <div className={styles["item-right"]}>
                      {user.is_bind_wechat === 1 && (
                        <div
                          className={styles["btn"]}
                          onClick={() => cancelBindWeixin()}
                        >
                          解绑账号
                        </div>
                      )}
                    </div>
                  </div>
                )}
              </div>
            )}

            {currentTab === 2 && (
              <div className={styles["project-content"]}>
                <ProfileComp refresh={() => resetData()}></ProfileComp>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default MemberPage;
