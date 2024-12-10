import { useState, useEffect } from "react";
import { Spin, Form, Input, message, Button, Select } from "antd";
import { useNavigate, useLocation } from "react-router-dom";
import { useDispatch } from "react-redux";
import { titleAction } from "../../../store/user/loginUserSlice";
import { system } from "../../../api/index";
import { BackBartment } from "../../../components";

const SystemImagesSaveConfigPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [form] = Form.useForm();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState<boolean>(true);

  useEffect(() => {
    document.title = "文件存储";
    dispatch(titleAction("文件存储"));
    getDetail();
  }, []);

  const getDetail = () => {
    system
      .setting()
      .then((res: any) => {
        let configData = res.data["公共文件存储"];
        for (let index in configData) {
          if (configData[index].key === "s3.public.key_id") {
            form.setFieldsValue({
              "s3.public.key_id": configData[index].value,
            });
          } else if (configData[index].key === "s3.public.key_secret") {
            form.setFieldsValue({
              "s3.public.key_secret": configData[index].value,
            });
          } else if (configData[index].key === "s3.public.region") {
            form.setFieldsValue({
              "s3.public.region": configData[index].value,
            });
          } else if (configData[index].key === "s3.public.bucket") {
            form.setFieldsValue({
              "s3.public.bucket": configData[index].value,
            });
          } else if (configData[index].key === "s3.public.endpoint.internal") {
            form.setFieldsValue({
              "s3.public.endpoint.internal": configData[index].value,
            });
          } else if (configData[index].key === "s3.public.endpoint.external") {
            form.setFieldsValue({
              "s3.public.endpoint.external": configData[index].value,
            });
          } else if (configData[index].key === "s3.public.domain") {
            form.setFieldsValue({
              "s3.public.domain": configData[index].value,
            });
          } else if (configData[index].key === "s3.public.cdn.domain") {
            form.setFieldsValue({
              "s3.public.cdn.domain": configData[index].value,
            });
          }
        }
        let configData2 = res.data["私有文件存储"];
        for (let index in configData2) {
          if (configData2[index].key === "s3.private.key_id") {
            form.setFieldsValue({
              "s3.private.key_id": configData2[index].value,
            });
          } else if (configData2[index].key === "s3.private.key_secret") {
            form.setFieldsValue({
              "s3.private.key_secret": configData2[index].value,
            });
          } else if (configData2[index].key === "s3.private.region") {
            form.setFieldsValue({
              "s3.private.region": configData2[index].value,
            });
          } else if (configData2[index].key === "s3.private.bucket") {
            form.setFieldsValue({
              "s3.private.bucket": configData2[index].value,
            });
          } else if (
            configData2[index].key === "s3.private.endpoint.internal"
          ) {
            form.setFieldsValue({
              "s3.private.endpoint.internal": configData2[index].value,
            });
          } else if (
            configData2[index].key === "s3.private.endpoint.external"
          ) {
            form.setFieldsValue({
              "s3.private.endpoint.external": configData2[index].value,
            });
          } else if (configData2[index].key === "s3.private.domain") {
            form.setFieldsValue({
              "s3.private.domain": configData2[index].value,
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
      <BackBartment title="文件存储"></BackBartment>
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
        <div className="float-left mt-30">
          <Form
            form={form}
            name="system-imagesSave-config"
            labelCol={{ span: 3 }}
            wrapperCol={{ span: 21 }}
            initialValues={{ remember: true }}
            onFinish={onFinish}
            onFinishFailed={onFinishFailed}
            autoComplete="off"
          >
            <div className="from-title mt-30">公共文件存储</div>
            <Form.Item label="AccessKeyId" name="s3.public.key_id">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="AccessKeySecret" name="s3.public.key_secret">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="Region" name="s3.public.region">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="Bucket" name="s3.public.bucket">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="内网端口" name="s3.public.endpoint.internal">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="外网端口" name="s3.public.endpoint.external">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="CDN加速域名" name="s3.public.cdn.domain">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <div className="from-title mt-30">私有文件存储</div>
            <Form.Item label="AccessKeyId" name="s3.private.key_id">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="AccessKeySecret" name="s3.private.key_secret">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="Region" name="s3.private.region">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="Bucket" name="s3.private.bucket">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="内网端口" name="s3.private.endpoint.internal">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="外网端口" name="s3.private.endpoint.external">
              <Input style={{ width: 300 }} allowClear />
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

export default SystemImagesSaveConfigPage;
