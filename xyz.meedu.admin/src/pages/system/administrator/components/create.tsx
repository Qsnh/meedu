import { useEffect, useState } from "react";
import { Button, Input, message, Form, Select, Switch, Space, Modal } from "antd";
import { system } from "../../../../api/index";
import { PerButton } from "../../../../components";
import { passwordRules } from "../../../../utils/index";

interface PropsInterface {
  open: boolean;
  roles: any[];
  onCancel: () => void;
  onSuccess: () => void;
}

export const AdministratorCreateDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);
  const [helpText, setHelpText] = useState<string>("");

  useEffect(() => {
    if (props.open) {
      form.resetFields();
      setHelpText("");
    }
  }, [props.open, form]);

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    if (passwordRules(values.password)) {
      message.error("密码至少包含大写字母，小写字母，数字，且不少于12位");
      return;
    }
    let params = {
      password_confirmation: values.password,
    };
    Object.assign(params, values);
    setLoading(true);
    system
      .administratorStore(params)
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
          title="新建管理员"
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
          <div className="float-left mt-30">
            <Form
              form={form}
              name="administrator-create"
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
              <Form.Item
                label="密码"
                name="password"
                rules={[{ required: true, message: "请输入密码!" }]}
              >
                <Space align="baseline" style={{ height: 32 }}>
                  <Form.Item
                    name="password"
                    rules={[{ required: true, message: "请输入密码!" }]}
                  >
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
