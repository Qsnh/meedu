import React, { useState, useEffect } from "react";
import { Modal, Form, Input, message, Spin, Button, Space, Image } from "antd";
import { useNavigate, useLocation } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import styles from "./index.module.scss";
import { login, user, system } from "../../api/index";
import { loginAction } from "../../store/user/loginUserSlice";
import {
  getLoginCode,
  getMsv,
  clearLoginCode,
  setToken,
  clearBindMobileKey,
  getFaceCheckKey,
  setFaceCheckKey,
  clearFaceCheckKey,
} from "../../utils/index";

interface PropInterface {
  open: boolean;
  scene: string;
  onCancel: () => void;
  success: () => void;
}

var interval: any = null;

export const CodeLoginBindMobileDialog: React.FC<PropInterface> = ({
  open,
  scene,
  onCancel,
}) => {
  const result = new URLSearchParams(useLocation().search);
  const [form] = Form.useForm();
  const navigate = useNavigate();
  const dispatch = useDispatch();
  const pathname = useLocation().pathname;
  const [loading, setLoading] = useState<boolean>(false);
  const [captcha, setCaptcha] = useState<any>({ key: null, img: null });
  const [current, setCurrent] = useState<number>(0);
  const [smsLoading, setSmsLoading] = useState<boolean>(false);
  const [smsLoading2, setSmsLoading2] = useState<boolean>(false);
  const [redirect, setRedirect] = useState(result.get("redirect"));
  const config = useSelector((state: any) => state.systemConfig.value.config);

  const clearSmsInterval = () => {
    interval && clearInterval(interval);
  };

  useEffect(() => {
    form.setFieldsValue({
      mobile: "",
      captcha: "",
      sms: "",
    });
    setSmsLoading(false);
    setCurrent(120);
    if (open) {
      getCaptcha();
    }

    return () => {
      clearSmsInterval();
    };
  }, [form, open]);

  const getCaptcha = () => {
    system.imageCaptcha().then((res: any) => {
      setCaptcha(res.data);
    });
  };

  const sendSms = () => {
    if (smsLoading || smsLoading2) {
      return;
    }
    let captchaVal = form.getFieldValue("captcha");
    if (!captchaVal) {
      message.error("请输入图形验证码");
      return;
    }
    setSmsLoading(true);
    setSmsLoading2(true);
    system
      .sendSms({
        mobile: form.getFieldValue("mobile"),
        image_key: captcha.key,
        image_captcha: captchaVal,
        scene: scene,
      })
      .then(() => {
        setSmsLoading2(false);
        let time = 120;
        interval = setInterval(() => {
          time--;
          setCurrent(time);
          if (time === 0) {
            clearSmsInterval();
            setCurrent(120);
            setSmsLoading(false);
          }
        }, 1000);
      })
      .catch((e: any) => {
        setSmsLoading2(false);
        form.setFieldsValue({
          captcha: "",
        });
        getCaptcha();
        clearSmsInterval();
        setCurrent(120);
        setSmsLoading(false);
      });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    login
      .codeBindMobile({
        mobile: values.mobile,
        mobile_code: values.sms,
        code: getLoginCode(),
        msv: getMsv(),
      })
      .then((res: any) => {
        setLoading(false);
        message.success("绑定成功");
        clearLoginCode();
        clearBindMobileKey();
        if (getFaceCheckKey() === "ok") {
          navigate("/face-check");
        } else {
          let token = res.data.token;
          setToken(token);
          user.detail().then((res: any) => {
            let loginData = res.data;
            dispatch(loginAction(loginData));
            //强制实名认证
            if (
              loginData.is_face_verify === false &&
              config.member.enabled_face_verify === true
            ) {
              setFaceCheckKey();
              clearSmsInterval();
              onCancel();
              navigate("/face-check", { replace: true });
            } else {
              clearFaceCheckKey();
              redirectHandler();
            }
          });
        }
      })
      .catch((e: any) => {
        setLoading(false);
      });
  };

  const redirectHandler = () => {
    clearSmsInterval();
    onCancel();
    if ((pathname === "/login" || pathname === "/login/callback") && redirect) {
      return navigate(decodeURIComponent(redirect), { replace: true });
    }
    navigate("/", { replace: true });
  };

  return (
    <>
      {open ? (
        <Modal
          title=""
          centered
          forceRender
          open={true}
          width={500}
          footer={null}
          onCancel={() => {
            clearSmsInterval();
            onCancel();
          }}
          maskClosable={false}
          closable={false}
        >
          <div className={styles["tabs"]}>
            <div className={styles["tab-active-item"]}>请绑定手机号</div>
            <a
              className={styles["linkTab"]}
              onClick={() => {
                clearSmsInterval();
                onCancel();
              }}
            >
              取消绑定&gt;&gt;
            </a>
          </div>
          <Form
            form={form}
            name="code-bind-new-mobile-dialog"
            labelCol={{ span: 0 }}
            wrapperCol={{ span: 24 }}
            initialValues={{ remember: true }}
            onFinish={onFinish}
            autoComplete="off"
            style={{ marginTop: 30 }}
          >
            <Form.Item
              name="mobile"
              rules={[{ required: true, message: "请输入手机号码!" }]}
            >
              <Input
                style={{ width: 440, height: 54 }}
                autoComplete="off"
                placeholder="请输入手机号码"
              />
            </Form.Item>
            <Form.Item>
              <Space align="baseline" style={{ height: 54 }}>
                <Form.Item
                  name="captcha"
                  rules={[{ required: true, message: "请输入图形验证码!" }]}
                >
                  <Input
                    style={{ width: 310, height: 54, marginRight: 10 }}
                    autoComplete="off"
                    placeholder="请输入图形验证码"
                  />
                </Form.Item>
                <Image
                  onClick={() => getCaptcha()}
                  src={captcha.img}
                  width={110}
                  height={39}
                  preview={false}
                  style={{ cursor: "pointer" }}
                />
              </Space>
            </Form.Item>

            <Form.Item>
              <Space align="baseline" style={{ height: 54 }}>
                <Form.Item
                  name="sms"
                  rules={[{ required: true, message: "请输入手机验证码!" }]}
                >
                  <Input
                    style={{ width: 310, height: 54, marginRight: 30 }}
                    autoComplete="off"
                    placeholder="请输入手机验证码"
                  />
                </Form.Item>
                <div className={styles["buttons"]}>
                  {smsLoading2 && (
                    <div style={{ width: 90, textAlign: "center" }}>
                      <Spin size="small" />
                    </div>
                  )}
                  {!smsLoading2 && smsLoading && (
                    <div className={styles["send-sms-button"]}>{current}s</div>
                  )}
                  {!smsLoading && !smsLoading2 && (
                    <div
                      className={styles["send-sms-button"]}
                      onClick={() => sendSms()}
                    >
                      获取验证码
                    </div>
                  )}
                </div>
              </Space>
            </Form.Item>
            <Form.Item>
              <Button
                style={{ width: 440, height: 54, outline: "none" }}
                type="primary"
                onClick={() => form.submit()}
                loading={loading}
              >
                立即绑定
              </Button>
            </Form.Item>
          </Form>
        </Modal>
      ) : null}
    </>
  );
};
