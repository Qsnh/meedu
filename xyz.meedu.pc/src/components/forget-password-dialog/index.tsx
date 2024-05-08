import React, { useState, useEffect } from "react";
import { Modal, Form, Input, message, Spin, Button, Space, Image } from "antd";
import styles from "./index.module.scss";
import { login, system } from "../../api/index";
import closeIcon from "../../assets/img/commen/icon-close.png";

interface PropInterface {
  open: boolean;
  onCancel: () => void;
  changeLogin: () => void;
}

var interval: any = null;

export const ForgetPasswordDialog: React.FC<PropInterface> = ({
  open,
  onCancel,
  changeLogin,
}) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);
  const [tabKey, setTabKey] = useState(1);
  const [captcha, setCaptcha] = useState<any>({ key: null, img: null });
  const [current, setCurrent] = useState<number>(0);
  const [smsLoading, setSmsLoading] = useState<boolean>(false);
  const [smsLoading2, setSmsLoading2] = useState<boolean>(false);

  useEffect(() => {
    form.setFieldsValue({
      mobile: "",
      password: "",
      captcha: "",
      sms: "",
    });
    setTabKey(1);
    setSmsLoading(false);
    setCurrent(120);
    if (open) {
      getCaptcha();
    }
    return () => {
      interval && clearInterval(interval);
    };
  }, [form, open]);

  const getCaptcha = () => {
    system.imageCaptcha().then((res: any) => {
      setCaptcha(res.data);
    });
  };

  const sendSms = () => {
    if (smsLoading) {
      return;
    }
    if (smsLoading2) {
      return;
    }
    if (!form.getFieldValue("captcha")) {
      message.error("请输入图形验证码");
      return;
    }
    setSmsLoading(true);
    setSmsLoading2(true);
    system
      .sendSms({
        mobile: form.getFieldValue("mobile"),
        image_key: captcha.key,
        image_captcha: form.getFieldValue("captcha"),
        scene: "login",
      })
      .then((res: any) => {
        setSmsLoading2(false);
        let time = 120;
        interval = setInterval(() => {
          time--;
          setCurrent(time);
          if (time === 0) {
            interval && clearInterval(interval);
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
        interval && clearInterval(interval);
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
      .noLoginPasswordForget({
        mobile: values.mobile,
        mobile_code: values.sms,
        password: values.password,
      })
      .then((res: any) => {
        setLoading(false);
        interval && clearInterval(interval);
        message.success("密码重置成功");
        onCancel();
      })
      .catch((e: any) => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const items = [
    {
      key: 1,
      label: `忘记密码`,
    },
  ];

  const onChange = (key: number) => {
    setTabKey(key);
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
            interval && clearInterval(interval);
            onCancel();
          }}
          maskClosable={false}
          closable={false}
        >
          <div className={styles["tabs"]}>
            {items.map((item: any) => (
              <div
                key={item.key}
                className={
                  item.key === tabKey
                    ? styles["tab-active-item"]
                    : styles["tab-item"]
                }
                onClick={() => {
                  onChange(item.key);
                }}
              >
                <div className={styles["tit"]}>{item.label}</div>
                {item.key === tabKey && (
                  <div className={styles["actline"]}></div>
                )}
              </div>
            ))}
            <a
              className={styles["linkTab"]}
              onClick={() => {
                interval && clearInterval(interval);
                changeLogin();
              }}
            >
              返回登录&gt;&gt;
            </a>
            <img
              className={styles["btn-close"]}
              onClick={() => {
                interval && clearInterval(interval);
                onCancel();
              }}
              src={closeIcon}
            />
          </div>
          <Form
            form={form}
            name="password-login-dialog"
            labelCol={{ span: 0 }}
            wrapperCol={{ span: 24 }}
            initialValues={{ remember: true }}
            onFinish={onFinish}
            onFinishFailed={onFinishFailed}
            autoComplete="off"
            style={{ marginTop: 30 }}
          >
            <Form.Item
              name="mobile"
              rules={[{ required: true, message: "请输入手机号!" }]}
            >
              <Input
                style={{ width: 440, height: 54, fontSize: 16 }}
                autoComplete="off"
                placeholder="请输入手机号"
              />
            </Form.Item>

            <Form.Item>
              <Space align="baseline" style={{ height: 54 }}>
                <Form.Item
                  name="captcha"
                  rules={[{ required: true, message: "请输入图形验证码!" }]}
                >
                  <Input
                    style={{
                      width: 310,
                      height: 54,
                      marginRight: 10,
                      fontSize: 16,
                    }}
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
                    style={{
                      width: 310,
                      height: 54,
                      marginRight: 30,
                      fontSize: 16,
                    }}
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

            <Form.Item
              name="password"
              rules={[{ required: true, message: "请设置账号密码!" }]}
            >
              <Input.Password
                style={{ width: 440, height: 54, fontSize: 16 }}
                autoComplete="off"
                placeholder="请设置账号密码"
              />
            </Form.Item>

            <Form.Item>
              <Button
                style={{
                  width: 440,
                  height: 54,
                  outline: "none",
                  fontSize: 16,
                }}
                type="primary"
                onClick={() => form.submit()}
                loading={loading}
              >
                重置密码
              </Button>
            </Form.Item>
          </Form>
        </Modal>
      ) : null}
    </>
  );
};
