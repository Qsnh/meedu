import { useState, useEffect } from "react";
import {
  Spin,
  Form,
  Input,
  message,
  Button,
  Space,
  Switch,
  Upload,
} from "antd";
import { useNavigate, useLocation } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { titleAction } from "../../../store/user/loginUserSlice";
import { system } from "../../../api/index";
import { BackBartment, QuillEditor } from "../../../components";

const SystemPaymentConfigPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [form] = Form.useForm();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState(true);
  const enabledAddons = useSelector(
    (state: any) => state.enabledAddonsConfig.value.enabledAddons
  );
  const [defautValue, setDefautValue] = useState<string>("");
  const [upLoading, setUpLoading] = useState(false);

  useEffect(() => {
    document.title = "支付配置";
    dispatch(titleAction("支付配置"));
    getDetail();
  }, []);

  const getDetail = () => {
    system
      .setting()
      .then((res: any) => {
        let configData = res.data["支付"];
        for (let index in configData) {
          if (configData[index].key === "meedu.payment.alipay.enabled") {
            form.setFieldsValue({
              "meedu.payment.alipay.enabled": Number(configData[index].value),
            });
          } else if (configData[index].key === "pay.alipay.app_id") {
            form.setFieldsValue({
              "pay.alipay.app_id": configData[index].value,
            });
          } else if (configData[index].key === "pay.alipay.ali_public_key") {
            form.setFieldsValue({
              "pay.alipay.ali_public_key": configData[index].value,
            });
          } else if (configData[index].key === "pay.alipay.alipay_root_cert") {
            form.setFieldsValue({
              "pay.alipay.alipay_root_cert": configData[index].value,
            });
          } else if (
            configData[index].key === "pay.alipay.app_cert_public_key"
          ) {
            form.setFieldsValue({
              "pay.alipay.app_cert_public_key": configData[index].value,
            });
          } else if (configData[index].key === "pay.alipay.private_key") {
            form.setFieldsValue({
              "pay.alipay.private_key": configData[index].value,
            });
          } else if (configData[index].key === "meedu.payment.wechat.enabled") {
            form.setFieldsValue({
              "meedu.payment.wechat.enabled": Number(configData[index].value),
            });
          } else if (configData[index].key === "pay.wechat.app_id") {
            form.setFieldsValue({
              "pay.wechat.app_id": configData[index].value,
            });
          } else if (configData[index].key === "pay.wechat.appid") {
            form.setFieldsValue({
              "pay.wechat.appid": configData[index].value,
            });
          } else if (configData[index].key === "pay.wechat.mch_id") {
            form.setFieldsValue({
              "pay.wechat.mch_id": configData[index].value,
            });
          } else if (configData[index].key === "pay.wechat.key") {
            form.setFieldsValue({
              "pay.wechat.key": configData[index].value,
            });
          } else if (
            configData[index].key === "meedu.payment.handPay.enabled"
          ) {
            form.setFieldsValue({
              "meedu.payment.handPay.enabled": Number(configData[index].value),
            });
          } else if (
            configData[index].key === "meedu.payment.handPay.introduction"
          ) {
            form.setFieldsValue({
              "meedu.payment.handPay.introduction": configData[index].value,
            });
            setDefautValue(configData[index].value);
          } else if (configData[index].key === "pay.wechat.cert_key") {
            form.setFieldsValue({
              "pay.wechat.cert_key": configData[index].value,
            });
          } else if (configData[index].key === "pay.wechat.cert_client") {
            form.setFieldsValue({
              "pay.wechat.cert_client": configData[index].value,
            });
          } else if (
            configData[index].key === "meedu.payment.wechat-jsapi.enabled"
          ) {
            form.setFieldsValue({
              "meedu.payment.wechat-jsapi.enabled": Number(
                configData[index].value
              ),
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

  const aliPayChange = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ "meedu.payment.alipay.enabled": 1 });
    } else {
      form.setFieldsValue({ "meedu.payment.alipay.enabled": 0 });
    }
  };

  const wechatChange = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ "meedu.payment.wechat.enabled": 1 });
    } else {
      form.setFieldsValue({ "meedu.payment.wechat.enabled": 0 });
    }
  };

  const wechatJsapiChange = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ "meedu.payment.wechat-jsapi.enabled": 1 });
    } else {
      form.setFieldsValue({ "meedu.payment.wechat-jsapi.enabled": 0 });
    }
  };

  const handPayChange = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ "meedu.payment.handPay.enabled": 1 });
    } else {
      form.setFieldsValue({ "meedu.payment.handPay.enabled": 0 });
    }
  };

  const uploadCertClientProps = {
    accept: ".pem",
    beforeUpload: (file: any) => {
      if (upLoading) {
        return;
      }
      setUpLoading(true);
      const f = file;
      const reader = new FileReader();
      reader.onload = (e: any) => {
        let data = e.target.result;
        form.setFieldsValue({ "pay.wechat.cert_client": data });
        setUpLoading(false);
      };
      reader.readAsBinaryString(f);
      return false;
    },
  };

  const uploadKeyClientProps = {
    accept: ".pem",
    beforeUpload: (file: any) => {
      if (upLoading) {
        return;
      }
      setUpLoading(true);
      const f = file;
      const reader = new FileReader();
      reader.onload = (e: any) => {
        let data = e.target.result;
        form.setFieldsValue({ "pay.wechat.cert_key": data });
        setUpLoading(false);
      };
      reader.readAsBinaryString(f);
      return false;
    },
  };

  const uploadAliPublicProps = {
    accept: ".crt",
    beforeUpload: (file: any) => {
      if (upLoading) {
        return;
      }
      setUpLoading(true);
      const f = file;
      const reader = new FileReader();
      reader.onload = (e: any) => {
        let data = e.target.result;
        form.setFieldsValue({ "pay.alipay.ali_public_key": data });
        setUpLoading(false);
      };
      reader.readAsBinaryString(f);
      return false;
    },
  };

  const uploadAliCertPublicProps = {
    accept: ".crt",
    beforeUpload: (file: any) => {
      if (upLoading) {
        return;
      }
      setUpLoading(true);
      const f = file;
      const reader = new FileReader();
      reader.onload = (e: any) => {
        let data = e.target.result;
        form.setFieldsValue({ "pay.alipay.app_cert_public_key": data });
        setUpLoading(false);
      };
      reader.readAsBinaryString(f);
      return false;
    },
  };

  const uploadAliRootCertProps = {
    accept: ".crt",
    beforeUpload: (file: any) => {
      if (upLoading) {
        return;
      }
      setUpLoading(true);
      const f = file;
      const reader = new FileReader();
      reader.onload = (e: any) => {
        let data = e.target.result;
        form.setFieldsValue({ "pay.alipay.alipay_root_cert": data });
        setUpLoading(false);
      };
      reader.readAsBinaryString(f);
      return false;
    },
  };

  const uploadAliCertPrivateProps = {
    accept: ".txt",
    beforeUpload: (file: any) => {
      if (upLoading) {
        return;
      }
      setUpLoading(true);
      const f = file;
      const reader = new FileReader();
      reader.onload = (e: any) => {
        let data = e.target.result;
        form.setFieldsValue({ "pay.alipay.private_key": data });
        setUpLoading(false);
      };
      reader.readAsBinaryString(f);
      return false;
    },
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="支付配置"></BackBartment>
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
            name="system-payment-config"
            labelCol={{ span: 3 }}
            wrapperCol={{ span: 21 }}
            initialValues={{ remember: true }}
            onFinish={onFinish}
            onFinishFailed={onFinishFailed}
            autoComplete="off"
          >
            <div className="from-title mt-30">支付宝支付</div>
            <Form.Item
              label="支付宝支付"
              name="meedu.payment.alipay.enabled"
              valuePropName="checked"
            >
              <Switch onChange={aliPayChange} />
            </Form.Item>
            <Form.Item label="支付宝AppId" name="pay.alipay.app_id">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>

            <Form.Item label="支付宝公钥" name="pay.alipay.ali_public_key">
              <Space align="baseline" style={{ height: 100 }}>
                <Form.Item name="pay.alipay.ali_public_key">
                  <Input.TextArea rows={3} style={{ width: 300 }} allowClear />
                </Form.Item>
                <div className="d-flex ml-10">
                  <Upload {...uploadAliPublicProps} showUploadList={false}>
                    <Button loading={loading} type="primary">
                      选择crt文件
                    </Button>
                  </Upload>
                </div>
              </Space>
            </Form.Item>

            <Form.Item label="应用私钥" name="pay.alipay.private_key">
              <Space align="baseline" style={{ height: 100 }}>
                <Form.Item name="pay.alipay.private_key">
                  <Input.TextArea rows={3} style={{ width: 300 }} allowClear />
                </Form.Item>
                <div className="d-flex ml-10">
                  <Upload {...uploadAliCertPrivateProps} showUploadList={false}>
                    <Button loading={loading} type="primary">
                      选择TXT
                    </Button>
                  </Upload>
                </div>
              </Space>
            </Form.Item>
            <Form.Item label="支付宝根证书" name="pay.alipay.alipay_root_cert">
              <Space align="baseline" style={{ height: 100 }}>
                <Form.Item name="pay.alipay.alipay_root_cert">
                  <Input.TextArea rows={3} style={{ width: 300 }} allowClear />
                </Form.Item>
                <div className="d-flex ml-10">
                  <Upload {...uploadAliRootCertProps} showUploadList={false}>
                    <Button loading={loading} type="primary">
                      选择crt文件
                    </Button>
                  </Upload>
                </div>
              </Space>
            </Form.Item>
            <Form.Item
              label="应用公钥证书"
              name="pay.alipay.app_cert_public_key"
            >
              <Space align="baseline" style={{ height: 100 }}>
                <Form.Item name="pay.alipay.app_cert_public_key">
                  <Input.TextArea rows={3} style={{ width: 300 }} allowClear />
                </Form.Item>
                <div className="d-flex ml-10">
                  <Upload {...uploadAliCertPublicProps} showUploadList={false}>
                    <Button loading={loading} type="primary">
                      选择crt文件
                    </Button>
                  </Upload>
                </div>
              </Space>
            </Form.Item>

            <div className="from-title mt-30">微信支付</div>
            <Form.Item
              label="微信扫码支付"
              name="meedu.payment.wechat.enabled"
              valuePropName="checked"
            >
              <Switch onChange={wechatChange} />
            </Form.Item>
            <Form.Item
              label="微信JSAPI支付"
              name="meedu.payment.wechat-jsapi.enabled"
              valuePropName="checked"
            >
              <Switch onChange={wechatJsapiChange} />
            </Form.Item>
            <Form.Item label="微信支付公众号AppId" name="pay.wechat.app_id">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            {enabledAddons["TemplateOne"] && (
              <Form.Item label="微信支付手机应用AppId" name="pay.wechat.appid">
                <Input style={{ width: 300 }} allowClear />
              </Form.Item>
            )}
            <Form.Item label="微信支付MchId" name="pay.wechat.mch_id">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="微信支付Key" name="pay.wechat.key">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="微信证书Client" name="pay.wechat.cert_client">
              <Space align="baseline" style={{ height: 100 }}>
                <Form.Item name="pay.wechat.cert_client">
                  <Input.TextArea rows={3} style={{ width: 300 }} allowClear />
                </Form.Item>
                <div className="d-flex ml-10">
                  <Upload {...uploadCertClientProps} showUploadList={false}>
                    <Button loading={loading} type="primary">
                      选择证书
                    </Button>
                  </Upload>
                </div>
              </Space>
            </Form.Item>
            <Form.Item label="微信证书Key" name="pay.wechat.cert_key">
              <Space align="baseline" style={{ height: 100 }}>
                <Form.Item name="pay.wechat.cert_key">
                  <Input.TextArea rows={3} style={{ width: 300 }} allowClear />
                </Form.Item>
                <div className="d-flex ml-10">
                  <Upload {...uploadKeyClientProps} showUploadList={false}>
                    <Button loading={loading} type="primary">
                      选择证书
                    </Button>
                  </Upload>
                </div>
              </Space>
            </Form.Item>
            <div className="from-title mt-30">手动支付</div>
            <Form.Item
              label="手动打款"
              name="meedu.payment.handPay.enabled"
              valuePropName="checked"
            >
              <Switch onChange={handPayChange} />
            </Form.Item>
            <Form.Item
              label="手动打款说明"
              name="meedu.payment.handPay.introduction"
              style={{ height: 440 }}
            >
              <div className="w-800px">
                <QuillEditor
                  mode=""
                  height={400}
                  defautValue={defautValue}
                  isFormula={false}
                  setContent={(value: string) => {
                    form.setFieldsValue({
                      "meedu.payment.handPay.introduction": value,
                    });
                  }}
                ></QuillEditor>
              </div>
            </Form.Item>
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

export default SystemPaymentConfigPage;
