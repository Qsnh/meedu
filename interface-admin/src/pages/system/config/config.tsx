import { useState, useEffect } from "react";
import { Spin, Form, Input, message, Button, Select, Switch } from "antd";
import { useNavigate, useLocation } from "react-router-dom";
import { useDispatch } from "react-redux";
import { titleAction } from "../../../store/user/loginUserSlice";
import { system } from "../../../api/index";
import {
  BackBartment,
  UploadImageButton,
  QuillEditor,
} from "../../../components";

const SystemNormalConfigPage = () => {
  const result = new URLSearchParams(useLocation().search);
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(true);
  const [config, setConfig] = useState<any>({});
  const [thumb, setThumb] = useState<any>({});
  const [key, setKey] = useState(String(result.get("key")));

  useEffect(() => {
    document.title = key === "会员" ? "用户注册" : key;
    dispatch(titleAction(key === "会员" ? "用户注册" : key));
  }, [key]);

  useEffect(() => {
    setKey(String(result.get("key")));
    getDetail();
  }, [result.get("key")]);

  const getDetail = () => {
    setConfig({});
    system
      .setting()
      .then((res: any) => {
        let configData = res.data;
        // 数据修饰下
        for (let index in configData) {
          for (let index2 in configData[index]) {
            let item = configData[index][index2];
            let params: any = {};
            if (item.field_type === "image") {
              let box: any = thumb;
              box[item.key] = item.value;
              setThumb(box);
            }
            if (item.field_type === "switch") {
              params[item.key] = Number(item.value);
              form.setFieldsValue(params);
            } else {
              params[item.key] = item.value;
              form.setFieldsValue(params);
            }
            if (item.field_type === "select") {
              let box = [];
              for (let i = 0; i < item.option_value.length; i++) {
                configData[index][index2].option_value[i].key += "";
                box.push({
                  label: configData[index][index2].option_value[i].title,
                  value: configData[index][index2].option_value[i].key,
                });
              }
              item.option_value = box;
            }
          }
        }
        setConfig(configData);
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
      <BackBartment title={key === "会员" ? "用户注册" : key}></BackBartment>
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
            name="system-normal-config"
            labelCol={{ span: 4 }}
            wrapperCol={{ span: 20 }}
            initialValues={{ remember: true }}
            onFinish={onFinish}
            onFinishFailed={onFinishFailed}
            autoComplete="off"
          >
            {config[key] &&
              config[key].map((c: any) => (
                <Form.Item key={c.id} label={c.name} name={c.key}>
                  {c.field_type === "text" && (
                    <Form.Item name={c.key}>
                      <Input style={{ width: 300 }} allowClear />
                    </Form.Item>
                  )}
                  {c.field_type === "number" && (
                    <Form.Item name={c.key}>
                      <Input type="number" style={{ width: 300 }} allowClear />
                    </Form.Item>
                  )}
                  {c.field_type === "textarea" && (
                    <Form.Item name={c.key}>
                      <Input.TextArea
                        rows={3}
                        style={{ width: 300 }}
                        allowClear
                      />
                    </Form.Item>
                  )}
                  {c.field_type === "longtext" && (
                    <Form.Item name={c.key}>
                      <div className="w-800px">
                        <QuillEditor
                          mode=""
                          height={400}
                          defautValue={c.value}
                          isFormula={false}
                          setContent={(value: string) => {
                            let params: any = {};
                            params[c.key] = value;
                            form.setFieldsValue(params);
                          }}
                        ></QuillEditor>
                      </div>
                    </Form.Item>
                  )}
                  {c.name === "网站Logo" && c.field_type === "image" && (
                    <Form.Item name={c.key}>
                      <UploadImageButton
                        text={c.name}
                        onSelected={(url) => {
                          let params: any = {};
                          params[c.key] = url;
                          form.setFieldsValue(params);
                          setThumb(params);
                        }}
                      ></UploadImageButton>
                    </Form.Item>
                  )}
                  {c.name === "默认头像" && c.field_type === "image" && (
                    <Form.Item name={c.key}>
                      <UploadImageButton
                        text={c.name}
                        onSelected={(url) => {
                          let params: any = {};
                          params[c.key] = url;
                          form.setFieldsValue(params);
                          setThumb(params);
                        }}
                      ></UploadImageButton>
                    </Form.Item>
                  )}
                  {c.name !== "网站Logo" &&
                    c.name !== "默认头像" &&
                    c.field_type === "image" && (
                      <Form.Item name={c.key}>
                        <UploadImageButton
                          text={c.name}
                          onSelected={(url) => {
                            let params: any = {};
                            params[c.key] = url;
                            form.setFieldsValue(params);
                            setThumb(params);
                          }}
                        ></UploadImageButton>
                      </Form.Item>
                    )}
                  {c.field_type === "switch" && (
                    <Form.Item name={c.key} valuePropName="checked">
                      <Switch
                        onChange={(checked: boolean) => {
                          if (checked) {
                            let params: any = {};
                            params[c.key] = 1;
                            form.setFieldsValue(params);
                          } else {
                            let params: any = {};
                            params[c.key] = 0;
                            form.setFieldsValue(params);
                          }
                        }}
                      />
                    </Form.Item>
                  )}
                  {c.field_type === "select" && (
                    <Form.Item name={c.key}>
                      <Select
                        style={{ width: 300 }}
                        allowClear
                        options={c.option_value}
                      />
                    </Form.Item>
                  )}
                  {c.name === "网站Logo" &&
                    c.field_type === "image" &&
                    thumb[c.key] && <img src={thumb[c.key]} width={200} />}
                  {c.name === "默认头像" &&
                    c.field_type === "image" &&
                    thumb[c.key] && <img src={thumb[c.key]} width={100} />}
                  {c.name !== "网站Logo" &&
                    c.name !== "默认头像" &&
                    c.field_type === "image" &&
                    thumb[c.key] && <img src={thumb[c.key]} />}
                  {c.help && (
                    <div className="form-helper-text">
                      <span>{c.help}</span>
                    </div>
                  )}
                </Form.Item>
              ))}
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

export default SystemNormalConfigPage;
