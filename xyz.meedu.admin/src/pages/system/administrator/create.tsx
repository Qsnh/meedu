import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Button, Input, message, Form, Select, Switch, Space } from "antd";
import { system } from "../../../api/index";
import { useDispatch } from "react-redux";
import { titleAction } from "../../../store/user/loginUserSlice";
import { BackBartment, PerButton } from "../../../components";
import { passwordRules } from "../../../utils/index";

const SystemAdministratorCreatePage = () => {
  const [form] = Form.useForm();
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);
  const [roles, setRoles] = useState<any>([]);
  const [helpText, setHelpText] = useState<string>("");

  useEffect(() => {
    document.title = "新建管理员";
    dispatch(titleAction("新建管理员"));
    params();
  }, []);

  const params = () => {
    system.administratorCreate().then((res: any) => {
      const arr = [];
      let roles = res.data.roles;
      for (let i = 0; i < roles.length; i++) {
        arr.push({
          label: roles[i].display_name,
          value: roles[i].id,
        });
      }
      setRoles(arr);
    });
  };

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
        navigate(-1);
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
    <div className="meedu-main-body">
      <BackBartment title="新建管理员" />
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
                  options={roles}
                />
              </Form.Item>
              <div className="ml-10">
                <PerButton
                  type="link"
                  text="角色管理"
                  class="c-primary"
                  icon={null}
                  p="administrator_role"
                  onClick={() => {
                    navigate("/system/adminroles");
                  }}
                  disabled={null}
                />
              </div>
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

export default SystemAdministratorCreatePage;
