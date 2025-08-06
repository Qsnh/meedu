import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Button, Image } from "antd";
import {
  LoginDialog,
  WeixinLoginDialog,
  WexinBindMobileDialog,
  ForgetPasswordDialog,
} from "../../components";
import { useLocation } from "react-router-dom";
import banner from "../../assets/img/commen/login-banner.png";

const LoginPage = () => {
  const [visiale, setVisiale] = useState<boolean>(false);
  const [weixinVisiale, setWeixinVisiale] = useState<boolean>(false);
  const [weixinBindMobileVisiale, setWeixinBindMobileVisiale] =
    useState<boolean>(false);
  const [loading, setLoading] = useState<boolean>(false);
  const [forgetVisiale, setForgetVisiale] = useState<boolean>(false);


  const goForget = () => {
    setForgetVisiale(true);
  };

  const goWeixinLogin = () => {
    setWeixinVisiale(true);
  };

  const bindMobile = () => {
    setWeixinBindMobileVisiale(true);
  };

  return (
    <div className={styles["content"]}>
      <LoginDialog
        open={visiale}
        onCancel={() => {
          setVisiale(false);
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
      <Image src={banner} width={300} height={300} preview={false} />
      <Button
        type="primary"
        style={{ width: 440, height: 54, borderRadius: 4, marginTop: 50 }}
        onClick={() => setVisiale(true)}
      >
        登录后查看
      </Button>
    </div>
  );
};

export default LoginPage;
