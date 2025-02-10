import { useState, useEffect } from "react";
import { Spin, Form, Input, message, Button, Row, Col, Switch } from "antd";
import { useNavigate, useLocation } from "react-router-dom";
import { useDispatch } from "react-redux";
import { titleAction } from "../../../store/user/loginUserSlice";
import { system } from "../../../api/index";
import { checkUrl } from "../../../utils/index";
import { BackBartment, UploadImageButton } from "../../../components";

const SystemMpWechatConfigPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [form] = Form.useForm();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState<boolean>(true);
  const [appUrl, setAppUrl] = useState<string>("");
  const [webUrl, setWebUrl] = useState<string>("");
  const [thumb, setThumb] = useState<string>("");

  useEffect(() => {
    document.title = "微信公众号";
    dispatch(titleAction("微信公众号"));
    getDetail();
  }, []);

  useEffect(() => {
    if (appUrl) {
      setWebUrl("微信公众号URL：" + appUrl + "api/wechat/serve");
    }
  }, [appUrl]);

  const getDetail = () => {
    system
      .setting()
      .then((res: any) => {
        let configData = res.data["微信公众号"];
        for (let index in configData) {
          if (configData[index].key === "meedu.mp_wechat.app_id") {
            form.setFieldsValue({
              "meedu.mp_wechat.app_id": configData[index].value,
            });
          } else if (configData[index].key === "meedu.mp_wechat.app_secret") {
            form.setFieldsValue({
              "meedu.mp_wechat.app_secret": configData[index].value,
            });
          } else if (configData[index].key === "meedu.mp_wechat.token") {
            form.setFieldsValue({
              "meedu.mp_wechat.token": configData[index].value,
            });
          } else if (
            configData[index].key === "meedu.mp_wechat.enabled_oauth_login"
          ) {
            form.setFieldsValue({
              "meedu.mp_wechat.enabled_oauth_login": Number(
                configData[index].value
              ),
            });
          } else if (
            configData[index].key === "meedu.mp_wechat.share.enabled"
          ) {
            form.setFieldsValue({
              "meedu.mp_wechat.share.enabled": Number(configData[index].value),
            });
          } else if (configData[index].key === "meedu.mp_wechat.share.title") {
            form.setFieldsValue({
              "meedu.mp_wechat.share.title": configData[index].value,
            });
          } else if (configData[index].key === "meedu.mp_wechat.share.desc") {
            form.setFieldsValue({
              "meedu.mp_wechat.share.desc": configData[index].value,
            });
          } else if (configData[index].key === "meedu.mp_wechat.share.imgUrl") {
            form.setFieldsValue({
              "meedu.mp_wechat.share.imgUrl": configData[index].value,
            });
            setThumb(configData[index].value);
          }
        }

        let configSysData = res.data["系统"];
        for (let index in configSysData) {
          if (configSysData[index].key === "app.url") {
            let appUrl = checkUrl(configSysData[index].value);
            setAppUrl(appUrl);
            break;
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

  const oauthLoginChange = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ "meedu.mp_wechat.enabled_oauth_login": 1 });
    } else {
      form.setFieldsValue({ "meedu.mp_wechat.enabled_oauth_login": 0 });
    }
  };

  const wechatShareChange = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ "meedu.mp_wechat.share.enabled": 1 });
    } else {
      form.setFieldsValue({ "meedu.mp_wechat.share.enabled": 0 });
    }
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="微信公众号"></BackBartment>
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
            name="system-mp_wechat-config"
            labelCol={{ span: 3 }}
            wrapperCol={{ span: 21 }}
            initialValues={{ remember: true }}
            onFinish={onFinish}
            onFinishFailed={onFinishFailed}
            autoComplete="off"
          >
            <div className="from-title mt-30">基础配置</div>
            <Form.Item label="AppId" name="meedu.mp_wechat.app_id">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="AppSecret" name="meedu.mp_wechat.app_secret">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="Token" name="meedu.mp_wechat.token">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <div className="from-title mt-30">登录配置</div>
            <Form.Item
              label="启用微信登录"
              name="meedu.mp_wechat.enabled_oauth_login"
              valuePropName="checked"
            >
              <Switch onChange={oauthLoginChange} />
            </Form.Item>
            <div className="from-title mt-30">手机端分享</div>
            <Form.Item
              label="启用微信分享"
              name="meedu.mp_wechat.share.enabled"
              valuePropName="checked"
            >
              <Switch onChange={wechatShareChange} />
            </Form.Item>
            <Form.Item label="微信分享标题" name="meedu.mp_wechat.share.title">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="微信分享描述" name="meedu.mp_wechat.share.desc">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="微信分享图片" name="meedu.mp_wechat.share.imgUrl">
              <UploadImageButton
                text="微信分享图片"
                scene="config"
                onSelected={(url) => {
                  form.setFieldsValue({ "meedu.mp_wechat.share.imgUrl": url });
                  setThumb(url);
                }}
              ></UploadImageButton>
            </Form.Item>
            {thumb && (
              <Row style={{ marginBottom: 22 }}>
                <Col span={3}></Col>
                <Col span={21}>
                  <div className="float-left">
                    <img width={200} src={thumb} />
                  </div>
                </Col>
              </Row>
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

export default SystemMpWechatConfigPage;
