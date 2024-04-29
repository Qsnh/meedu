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
  const [disk, setDisk] = useState("");
  const selects = [
    {
      value: "public",
      label: "本地",
    },
    {
      value: "oss",
      label: "阿里云OSS",
    },
    {
      value: "cos",
      label: "腾讯云COS",
    },
    {
      value: "qiniu",
      label: "七牛云",
    },
  ];

  useEffect(() => {
    document.title = "图片存储";
    dispatch(titleAction("图片存储"));
    getDetail();
  }, []);

  const getDetail = () => {
    system
      .setting()
      .then((res: any) => {
        let configData = res.data["图片存储"];
        for (let index in configData) {
          if (configData[index].key === "meedu.upload.image.disk") {
            form.setFieldsValue({
              "meedu.upload.image.disk": configData[index].value,
            });
            setDisk(configData[index].value);
          } else if (
            configData[index].key === "filesystems.disks.qiniu.domains.default"
          ) {
            form.setFieldsValue({
              "filesystems.disks.qiniu.domains.default":
                configData[index].value,
            });
          } else if (
            configData[index].key === "filesystems.disks.qiniu.domains.https"
          ) {
            form.setFieldsValue({
              "filesystems.disks.qiniu.domains.https": configData[index].value,
            });
          } else if (
            configData[index].key === "filesystems.disks.qiniu.access_key"
          ) {
            form.setFieldsValue({
              "filesystems.disks.qiniu.access_key": configData[index].value,
            });
          } else if (
            configData[index].key === "filesystems.disks.qiniu.secret_key"
          ) {
            form.setFieldsValue({
              "filesystems.disks.qiniu.secret_key": configData[index].value,
            });
          } else if (
            configData[index].key === "filesystems.disks.qiniu.bucket"
          ) {
            form.setFieldsValue({
              "filesystems.disks.qiniu.bucket": configData[index].value,
            });
          } else if (
            configData[index].key === "filesystems.disks.oss.access_id"
          ) {
            form.setFieldsValue({
              "filesystems.disks.oss.access_id": configData[index].value,
            });
          } else if (
            configData[index].key === "filesystems.disks.oss.access_key"
          ) {
            form.setFieldsValue({
              "filesystems.disks.oss.access_key": configData[index].value,
            });
          } else if (configData[index].key === "filesystems.disks.oss.bucket") {
            form.setFieldsValue({
              "filesystems.disks.oss.bucket": configData[index].value,
            });
          } else if (
            configData[index].key === "filesystems.disks.oss.endpoint"
          ) {
            form.setFieldsValue({
              "filesystems.disks.oss.endpoint": configData[index].value,
            });
          } else if (
            configData[index].key === "filesystems.disks.oss.cdnDomain"
          ) {
            form.setFieldsValue({
              "filesystems.disks.oss.cdnDomain": configData[index].value,
            });
          } else if (configData[index].key === "filesystems.disks.cos.region") {
            form.setFieldsValue({
              "filesystems.disks.cos.region": configData[index].value,
            });
          } else if (
            configData[index].key === "filesystems.disks.cos.credentials.appId"
          ) {
            form.setFieldsValue({
              "filesystems.disks.cos.credentials.appId":
                configData[index].value,
            });
          } else if (
            configData[index].key ===
            "filesystems.disks.cos.credentials.secretId"
          ) {
            form.setFieldsValue({
              "filesystems.disks.cos.credentials.secretId":
                configData[index].value,
            });
          } else if (
            configData[index].key ===
            "filesystems.disks.cos.credentials.secretKey"
          ) {
            form.setFieldsValue({
              "filesystems.disks.cos.credentials.secretKey":
                configData[index].value,
            });
          } else if (configData[index].key === "filesystems.disks.cos.bucket") {
            form.setFieldsValue({
              "filesystems.disks.cos.bucket": configData[index].value,
            });
          } else if (configData[index].key === "filesystems.disks.cos.cdn") {
            form.setFieldsValue({
              "filesystems.disks.cos.cdn": configData[index].value,
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
      <BackBartment title="图片存储"></BackBartment>
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
            <Form.Item label="图片存储驱动" name="meedu.upload.image.disk">
              <Select
                style={{ width: 300 }}
                onChange={(e) => {
                  setDisk(e);
                }}
                allowClear
                options={selects}
              />
            </Form.Item>
            {disk === "oss" && (
              <>
                <Form.Item
                  label="阿里云OSS AccessKeyId"
                  name="filesystems.disks.oss.access_id"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="阿里云OSS AccessKeySecret"
                  name="filesystems.disks.oss.access_key"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="阿里云OSS Bucket"
                  name="filesystems.disks.oss.bucket"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="阿里云OSS Endpoint"
                  name="filesystems.disks.oss.endpoint"
                >
                  <Form.Item name="filesystems.disks.oss.endpoint">
                    <Input style={{ width: 300 }} allowClear />
                  </Form.Item>
                  <div className="form-helper-text">
                    <span>必须配置，否则无法上传图片</span>
                  </div>
                </Form.Item>
                <Form.Item
                  label="阿里云OSS CDN加速域名"
                  name="filesystems.disks.oss.cdnDomain"
                >
                  <Form.Item name="filesystems.disks.oss.cdnDomain">
                    <Input style={{ width: 300 }} allowClear />
                  </Form.Item>
                  <div className="form-helper-text">
                    <span>必须配置，否则无法上传图片</span>
                  </div>
                </Form.Item>
              </>
            )}
            {disk === "cos" && (
              <>
                <Form.Item
                  label="腾讯云COS Region"
                  name="filesystems.disks.cos.region"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="腾讯云COS AppId"
                  name="filesystems.disks.cos.credentials.appId"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="腾讯云COS SecretId"
                  name="filesystems.disks.cos.credentials.secretId"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="腾讯云COS SecretKey"
                  name="filesystems.disks.cos.credentials.secretKey"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="腾讯云COS Bucket"
                  name="filesystems.disks.cos.bucket"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="腾讯云COS CDN域名"
                  name="filesystems.disks.cos.cdn"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
              </>
            )}
            {disk === "qiniu" && (
              <>
                <Form.Item
                  label="七牛访问域名"
                  name="filesystems.disks.qiniu.domains.default"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="七牛访问域名(https)"
                  name="filesystems.disks.qiniu.domains.https"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="七牛AccessKey"
                  name="filesystems.disks.qiniu.access_key"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="七牛SecretKey"
                  name="filesystems.disks.qiniu.secret_key"
                >
                  <Input style={{ width: 300 }} allowClear />
                </Form.Item>
                <Form.Item
                  label="七牛Bucket"
                  name="filesystems.disks.qiniu.bucket"
                >
                  <Input style={{ width: 300 }} allowClear />
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

export default SystemImagesSaveConfigPage;
