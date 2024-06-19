import { useState, useEffect } from "react";
import { Spin, Form, Input, message, Button, Select } from "antd";
import { useNavigate, useLocation } from "react-router-dom";
import { useDispatch } from "react-redux";
import { titleAction } from "../../../store/user/loginUserSlice";
import { system } from "../../../api/index";
import { BackBartment } from "../../../components";

const SystemMessageConfigPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [form] = Form.useForm();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState<boolean>(true);
  const [sms, setSms] = useState("");
  const selects = [
    {
      value: "aliyun",
      label: "阿里云",
    },
    {
      value: "tencent",
      label: "腾讯云",
    },
    {
      value: "yunpian",
      label: "云片",
    },
  ];

  const regions = [
    {
      value: "ap-beijing",
      label: "华北地区（北京）",
    },
    {
      value: "ap-guangzhou",
      label: "华南地区（广州）",
    },
    {
      value: "ap-nanjing",
      label: "华东地区（南京）",
    },
  ];

  useEffect(() => {
    document.title = "短信";
    dispatch(titleAction("短信"));
    getDetail();
  }, []);

  const getDetail = () => {
    system
      .setting()
      .then((res: any) => {
        let configData = res.data["短信"];
        for (let index in configData) {
          if (configData[index].key === "meedu.system.sms") {
            form.setFieldsValue({
              "meedu.system.sms": configData[index].value,
            });
            setSms(configData[index].value);
          } else if (
            configData[index].key === "sms.gateways.aliyun.access_key_id"
          ) {
            form.setFieldsValue({
              "sms.gateways.aliyun.access_key_id": configData[index].value,
            });
          } else if (
            configData[index].key === "sms.gateways.aliyun.access_key_secret"
          ) {
            form.setFieldsValue({
              "sms.gateways.aliyun.access_key_secret": configData[index].value,
            });
          } else if (
            configData[index].key === "sms.gateways.aliyun.sign_name"
          ) {
            form.setFieldsValue({
              "sms.gateways.aliyun.sign_name": configData[index].value,
            });
          } else if (
            configData[index].key ===
            "sms.gateways.aliyun.template.password_reset"
          ) {
            form.setFieldsValue({
              "sms.gateways.aliyun.template.password_reset":
                configData[index].value,
            });
          } else if (
            configData[index].key === "sms.gateways.aliyun.template.register"
          ) {
            form.setFieldsValue({
              "sms.gateways.aliyun.template.register": configData[index].value,
            });
          } else if (
            configData[index].key === "sms.gateways.aliyun.template.mobile_bind"
          ) {
            form.setFieldsValue({
              "sms.gateways.aliyun.template.mobile_bind":
                configData[index].value,
            });
          } else if (
            configData[index].key === "sms.gateways.aliyun.template.login"
          ) {
            form.setFieldsValue({
              "sms.gateways.aliyun.template.login": configData[index].value,
            });
          } else if (
            configData[index].key === "sms.gateways.tencent.sdk_app_id"
          ) {
            form.setFieldsValue({
              "sms.gateways.tencent.sdk_app_id": configData[index].value,
            });
          } else if (configData[index].key === "sms.gateways.tencent.region") {
            form.setFieldsValue({
              "sms.gateways.tencent.region": configData[index].value,
            });
          } else if (
            configData[index].key === "sms.gateways.tencent.secret_id"
          ) {
            form.setFieldsValue({
              "sms.gateways.tencent.secret_id": configData[index].value,
            });
          } else if (
            configData[index].key === "sms.gateways.tencent.secret_key"
          ) {
            form.setFieldsValue({
              "sms.gateways.tencent.secret_key": configData[index].value,
            });
          } else if (
            configData[index].key === "sms.gateways.tencent.sign_name"
          ) {
            form.setFieldsValue({
              "sms.gateways.tencent.sign_name": configData[index].value,
            });
          } else if (
            configData[index].key ===
            "sms.gateways.tencent.template.password_reset"
          ) {
            form.setFieldsValue({
              "sms.gateways.tencent.template.password_reset":
                configData[index].value,
            });
          } else if (
            configData[index].key === "sms.gateways.tencent.template.register"
          ) {
            form.setFieldsValue({
              "sms.gateways.tencent.template.register": configData[index].value,
            });
          } else if (
            configData[index].key ===
            "sms.gateways.tencent.template.mobile_bind"
          ) {
            form.setFieldsValue({
              "sms.gateways.tencent.template.mobile_bind":
                configData[index].value,
            });
          } else if (
            configData[index].key === "sms.gateways.tencent.template.login"
          ) {
            form.setFieldsValue({
              "sms.gateways.tencent.template.login": configData[index].value,
            });
          } else if (configData[index].key === "sms.gateways.yunpian.api_key") {
            form.setFieldsValue({
              "sms.gateways.yunpian.api_key": configData[index].value,
            });
          } else if (
            configData[index].key ===
            "sms.gateways.yunpian.template.password_reset"
          ) {
            form.setFieldsValue({
              "sms.gateways.yunpian.template.password_reset":
                configData[index].value,
            });
          } else if (
            configData[index].key === "sms.gateways.yunpian.template.register"
          ) {
            form.setFieldsValue({
              "sms.gateways.yunpian.template.register": configData[index].value,
            });
          } else if (
            configData[index].key ===
            "sms.gateways.yunpian.template.mobile_bind"
          ) {
            form.setFieldsValue({
              "sms.gateways.yunpian.template.mobile_bind":
                configData[index].value,
            });
          } else if (
            configData[index].key === "sms.gateways.yunpian.template.login"
          ) {
            form.setFieldsValue({
              "sms.gateways.yunpian.template.login": configData[index].value,
            });
          }
        }
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .saveSetting({
        config: values,
      })
      .then((res: any) => {
        setLoading(false);
        message.success("成功！");
        getDetail();
        navigate(-1);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="短信"></BackBartment>
      {loading && (
        <div
          style={{
            width: "100%",
            textAlign: "center",
            paddingTop: 50,
            paddingBottom: 30,
            boxSizing: "border-box",
          }}
        >
          <Spin />
        </div>
      )}
      {!loading && (
        <div className="float-left">
          <Form
            form={form}
            name="system-message-config"
            labelCol={{ span: 3 }}
            wrapperCol={{ span: 21 }}
            initialValues={{ remember: true }}
            onFinish={onFinish}
            onFinishFailed={onFinishFailed}
            autoComplete="off"
          >
            <div className="from-title mt-30">短信服务商配置</div>
            <Form.Item label="短信服务商" name="meedu.system.sms">
              <Select
                style={{ width: 300 }}
                onChange={(e) => {
                  setSms(e);
                }}
                allowClear
                options={selects}
              />
            </Form.Item>
            {sms === "aliyun" && (
              <>
                <Form.Item
                  label="阿里云 AccessKeyId"
                  name="sms.gateways.aliyun.access_key_id"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="阿里云 AccessKeySecret"
                  name="sms.gateways.aliyun.access_key_secret"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="阿里云 短信签名"
                  name="sms.gateways.aliyun.sign_name"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="阿里云 密码重置模板ID"
                  name="sms.gateways.aliyun.template.password_reset"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="阿里云 注册模板ID"
                  name="sms.gateways.aliyun.template.register"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="阿里云 手机号绑定模板ID"
                  name="sms.gateways.aliyun.template.mobile_bind"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="阿里云 手机号登录模板ID"
                  name="sms.gateways.aliyun.template.login"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
              </>
            )}
            {sms === "tencent" && (
              <>
                <Form.Item
                  label="腾讯云短信 SdkAppId"
                  name="sms.gateways.tencent.sdk_app_id"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="腾讯云短信 Region"
                  name="sms.gateways.tencent.region"
                >
                  <Select style={{ width: 300 }} allowClear options={regions} />
                </Form.Item>
                <Form.Item
                  label="腾讯云短信 SecretId"
                  name="sms.gateways.tencent.secret_id"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="腾讯云短信 SecretKey"
                  name="sms.gateways.tencent.secret_key"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="腾讯云短信 SignName"
                  name="sms.gateways.tencent.sign_name"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="腾讯云 密码重置模板ID"
                  name="sms.gateways.tencent.template.password_reset"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="腾讯云 注册模板ID"
                  name="sms.gateways.tencent.template.register"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="腾讯云 手机号绑定模板ID"
                  name="sms.gateways.tencent.template.mobile_bind"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="腾讯云 手机号登录模板ID"
                  name="sms.gateways.tencent.template.login"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
              </>
            )}
            {sms === "yunpian" && (
              <>
                <Form.Item
                  label="云片ApiKey"
                  name="sms.gateways.yunpian.api_key"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="云片密码重置模板"
                  name="sms.gateways.yunpian.template.password_reset"
                >
                  <Form.Item name="sms.gateways.yunpian.template.password_reset">
                    <Input.TextArea
                      rows={3}
                      style={{ width: 300, resize: "none" }}
                      allowClear
                    />
                  </Form.Item>
                  <div className="form-helper-text">
                    <span>注意：云片短信不是填写模板ID，而是填写模板内容</span>
                  </div>
                </Form.Item>
                <Form.Item
                  label="云片注册模板"
                  name="sms.gateways.yunpian.template.register"
                >
                  <Input.TextArea
                    rows={3}
                    style={{ width: 300, resize: "none" }}
                    allowClear
                  />
                </Form.Item>
                <Form.Item
                  label="云片手机号绑定模板"
                  name="sms.gateways.yunpian.template.mobile_bind"
                >
                  <Input.TextArea
                    rows={3}
                    style={{ width: 300, resize: "none" }}
                    allowClear
                  />
                </Form.Item>
                <Form.Item
                  label="云片手机号登陆模板"
                  name="sms.gateways.yunpian.template.login"
                >
                  <Input.TextArea
                    rows={3}
                    style={{ width: 300, resize: "none" }}
                    allowClear
                  />
                </Form.Item>
              </>
            )}
          </Form>
        </div>
      )}
      <div className="bottom-menus">
        <div className="bottom-menus-box">
          <div>
            <Button
              loading={loading}
              type="primary"
              onClick={() => form.submit()}
            >
              保存
            </Button>
          </div>
          <div className="ml-24">
            <Button type="default" onClick={() => navigate(-1)}>
              取消
            </Button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default SystemMessageConfigPage;
