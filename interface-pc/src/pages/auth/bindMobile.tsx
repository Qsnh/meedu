import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import styles from "./bindMobile.module.scss";
import { Form, Input, message, Spin, Button, Space, Image } from "antd";
import { user, system } from "../../api/index";
import { loginAction } from "../../store/user/loginUserSlice";
import {
  clearBindMobileKey,
  getFaceCheckKey,
  setFaceCheckKey,
  clearFaceCheckKey,
} from "../../utils/index";

var interval: any = null;
const BindNewMobilePage = () => {
  const [form] = Form.useForm();
  const navigate = useNavigate();
  const dispatch = useDispatch();
  const [loading, setLoading] = useState<boolean>(false);
  const [captcha, setCaptcha] = useState<any>({ key: null, img: null });
  const [current, setCurrent] = useState<number>(0);
  const [smsLoading, setSmsLoading] = useState<boolean>(false);
  const [smsLoading2, setSmsLoading2] = useState<boolean>(false);
  const config = useSelector((state: any) => state.systemConfig.value.config);

  useEffect(() => {
    document.title = "绑定新手机号";
    form.setFieldsValue({
      mobile: "",
      captcha: "",
      sms: "",
    });
    setSmsLoading(false);
    setCurrent(120);
    getCaptcha();

    return () => {
      interval && clearInterval(interval);
    };
  }, []);

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
        scene: "mobile_bind",
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
    user
      .newMobile({
        mobile: values.mobile,
        mobile_code: values.sms,
      })
      .then((res: any) => {
        setLoading(false);
        message.success("绑定成功");
        clearBindMobileKey();
        if (getFaceCheckKey() === "ok") {
          navigate("/face-check");
        } else {
          getUser();
        }
      })
      .catch((e: any) => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const getUser = () => {
    user.detail().then((res: any) => {
      let loginData = res.data;
      dispatch(loginAction(loginData));
      //强制实名认证
      if (
        loginData.is_face_verify === false &&
        config.member.enabled_face_verify === true
      ) {
        setFaceCheckKey();
        navigate("/face-check", { replace: true });
      } else {
        clearFaceCheckKey();
        navigate("/", { replace: true });
      }
    });
  };

  return (
    <div>
      <div className={styles["box"]}>
        <div className={styles["title"]}>请绑定手机号</div>
        <Form
          form={form}
          name="bind-new-mobile-page"
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
            rules={[{ required: true, message: "请输入手机号" }]}
          >
            <Input
              style={{ width: 440, height: 54 }}
              autoComplete="off"
              placeholder="请输入手机号"
            />
          </Form.Item>
          <Form.Item>
            <Space align="baseline" style={{ height: 54 }}>
              <Form.Item
                name="captcha"
                rules={[{ required: true, message: "请输入图形验证码" }]}
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
                rules={[{ required: true, message: "请输入短信验证码" }]}
              >
                <Input
                  style={{ width: 310, height: 54, marginRight: 30 }}
                  autoComplete="off"
                  placeholder="请输入短信验证码"
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
      </div>
    </div>
  );
};

export default BindNewMobilePage;
