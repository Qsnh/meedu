import React, { useState, useEffect } from "react";
import { useSelector } from "react-redux";
import {
  Modal,
  Form,
  Input,
  message,
  Button,
  Space,
  Image,
  Spin,
  Checkbox,
} from "antd";
import type { CheckboxChangeEvent } from "antd/es/checkbox";
import styles from "./index.module.scss";
import { login, system } from "../../api/index";
import { getMsv } from "../../utils/index";
import closeIcon from "../../assets/img/commen/icon-close.png";

interface PropInterface {
  open: boolean;
  onCancel: () => void;
  changeLogin: () => void;
}

var interval: any = null;

export const RegisterDialog: React.FC<PropInterface> = ({
  open,
  onCancel,
  changeLogin,
}) => {
  const [form] = Form.useForm();
  const config = useSelector((state: any) => state.systemConfig.value.config);
  const [loading, setLoading] = useState<boolean>(false);
  const [captcha, setCaptcha] = useState<any>({ key: null, img: null });
  const [current, setCurrent] = useState<number>(0);
  const [smsLoading, setSmsLoading] = useState<boolean>(false);
  const [smsLoading2, setSmsLoading2] = useState<boolean>(false);
  const [agreeProtocol, setAgreeProtocol] = useState<boolean>(false);

  useEffect(() => {
    form.setFieldsValue({
      mobile: "",
      password: "",
      captcha: "",
      sms: "",
    });

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
        scene: "register",
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
    if (agreeProtocol !== true) {
      message.error("请同意《用户协议》和《隐私政策》");
      return;
    }
    setLoading(true);
    login
      .smsRegister({
        mobile: values.mobile,
        mobile_code: values.sms,
        password: values.password,
        msv: getMsv(),
      })
      .then((res: any) => {
        message.success("注册成功");
        setLoading(false);
        interval && clearInterval(interval);
        changeLogin();
      })
      .catch((e: any) => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const onChange = (e: CheckboxChangeEvent) => {
    setAgreeProtocol(e.target.checked);
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
            <div className={styles["tab-active-item"]}>用户注册</div>
            <a
              className={styles["linkTab"]}
              onClick={() => {
                interval && clearInterval(interval);
                changeLogin();
              }}
            >
              已有账号，立即登录&gt;&gt;
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
            name="register-dialog"
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
            <div className="mb-50 flex items-center">
              <div className="flex-1 flex items-start">
                <div className="flex items-center h-5">
                  <Checkbox
                    onChange={onChange}
                    defaultChecked={agreeProtocol}
                  />
                </div>
                <div className="ml-10 text-sm">
                  <label className="text-gray-normal">
                    同意
                    <a
                      className="text-blue"
                      href={config.user_protocol}
                      target="_blank"
                    >
                      《用户协议》
                    </a>
                    和
                    <a
                      className="text-blue"
                      href={config.user_private_protocol}
                      target="_blank"
                    >
                      《隐私政策》
                    </a>
                  </label>
                </div>
              </div>
            </div>
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
                立即注册
              </Button>
            </Form.Item>
          </Form>
        </Modal>
      ) : null}
    </>
  );
};
