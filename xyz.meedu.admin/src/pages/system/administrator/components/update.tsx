import { useState, useEffect } from "react";
import {
  Button,
  Input,
  message,
  Form,
  Select,
  Switch,
  Space,
  Spin,
  Modal,
} from "antd";
import { system } from "../../../../api/index";
import { PerButton, HelperText } from "../../../../components";
import { passwordRules } from "../../../../utils/index";

interface PropsInterface {
  id: number;
  open: boolean;
  roles: any[];
  onCancel: () => void;
  onSuccess: () => void;
}

export const AdministratorUpdateDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [init, setInit] = useState<boolean>(true);
  const [loading, setLoading] = useState<boolean>(false);
  const [helpText, setHelpText] = useState<string>("");

  useEffect(() => {
    if (props.id > 0 && props.open) {
      setInit(true);
      setHelpText("");
      initData();
    }
  }, [props.open, props.id]);

  const initData = async () => {
    await getDetail();
    setInit(false);
  };

  const getDetail = async () => {
    if (props.id === 0) {
      return;
    }
    const res: any = await system.administratorDetail(props.id);
    var data = res.data;
    var roles = data.role_id;
    let newbox = [];
    for (var i = 0; i < roles.length; i++) {
      newbox.push(roles[i]);
    }
    form.setFieldsValue({
      is_ban_login: data.is_ban_login,
      email: data.email,
      name: data.name,
      role_id: newbox,
    });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    let params: any = {
      password_confirmation: values.password,
    };

    if (values.password === undefined || values.password === "") {
    } else {
      if (passwordRules(values.password)) {
        message.error("密码至少包含大写字母，小写字母，数字，且不少于12位");
        return;
      }
      params = {
        password_confirmation: values.password,
        password: values.password,
      };
    }
    Object.assign(params, {
      name: values.name,
      email: values.email,
      role_id: values.role_id,
      is_ban_login: values.is_ban_login,
    });
    setLoading(true);
    system
      .administratorUpdate(props.id, params)
      .then((res: any) => {
        setLoading(false);
        message.success("保存成功！");
        props.onSuccess();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const onChange = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ is_ban_login: 1 });
    } else {
      form.setFieldsValue({ is_ban_login: 0 });
    }
  };

  return (
    <>
      {props.open ? (
        <Modal
          title="编辑管理员"
          onCancel={() => {
            props.onCancel();
          }}
          open={true}
          width={800}
          maskClosable={false}
          onOk={() => {
            form.submit();
          }}
          centered
          okButtonProps={{ loading: loading }}
        >
          {init && (
            <div className="float-left text-center mt-30">
              <Spin></Spin>
            </div>
          )}
          <div
            style={{ display: init ? "none" : "block" }}
            className="float-left mt-30"
          >
            <Form
              form={form}
              name="administrator-update"
              labelCol={{ span: 3 }}
              wrapperCol={{ span: 21 }}
              initialValues={{ remember: true }}
              onFinish={onFinish}
              onFinishFailed={onFinishFailed}
              autoComplete="off"
            >
              <Form.Item label="角色">
                <Space align="baseline" style={{ height: 32 }}>
                  <Form.Item name="role_id">
                    <Select
                      style={{ width: 300 }}
                      mode="multiple"
                      allowClear
                      placeholder="请选择角色"
                      options={props.roles}
                    />
                  </Form.Item>
                </Space>
              </Form.Item>
              <Form.Item
                label="姓名"
                name="name"
                rules={[{ required: true, message: "请输入姓名!" }]}
              >
                <Input style={{ width: 300 }} placeholder="请输入姓名" allowClear />
              </Form.Item>
              <Form.Item
                label="邮箱"
                name="email"
                rules={[{ required: true, message: "请输入邮箱!" }]}
              >
                <Input style={{ width: 300 }} placeholder="请输入邮箱" allowClear />
              </Form.Item>
              <Form.Item label="密码" name="password">
                <Space align="baseline" style={{ height: 32 }}>
                  <Form.Item name="password">
                    <Input.Password
                      style={{ width: 300 }}
                      placeholder="请输入密码"
                      allowClear
                      onChange={(e) => {
                        if (e.target.value === "") {
                          setHelpText("");
                        } else {
                          let text = passwordRules(e.target.value);
                          setHelpText(String(text));
                        }
                      }}
                    />
                  </Form.Item>
                  <div className="ml-10">
                    <HelperText text="不修改密码请勿填写"></HelperText>
                  </div>
                  {helpText !== "" && helpText !== "undefined" && (
                    <div className="ml-10 c-red">{helpText}</div>
                  )}
                </Space>
              </Form.Item>
              <Form.Item
                label="禁止登录"
                name="is_ban_login"
                valuePropName="checked"
              >
                <Switch onChange={onChange} />
              </Form.Item>
            </Form>
          </div>
        </Modal>
      ) : null}
    </>
  );
};
