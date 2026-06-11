import { useState } from "react";
import { Form, Input, Button, message } from "antd";
import { useNavigate } from "react-router-dom";
import { setup as setupApi } from "../../api";
import styles from "./index.module.scss";

type FormValues = {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
};

const SetupPage = () => {
  document.title = "初始化超级管理员";
  const navigate = useNavigate();
  const [form] = Form.useForm<FormValues>();
  const [loading, setLoading] = useState(false);

  const onFinish = async (values: FormValues) => {
    if (loading) return;
    setLoading(true);
    try {
      const res: any = await setupApi.submitSetup(values);
      const email = res?.data?.email ?? values.email;
      message.success("超级管理员创建成功，请登录");
      navigate(`/login?email=${encodeURIComponent(email)}`, { replace: true });
    } catch {
      // 业务错误已被 axios 拦截器 toast，无需在此再次处理
      setLoading(false);
    }
  };

  return (
    <div className={styles["setup-container"]}>
      <div className={styles["card"]}>
        <div className={styles["logo"]}>
          <img src="/images/logo.png" alt="MeEdu" />
        </div>
        <div className={styles["title"]}>欢迎使用 MeEdu</div>
        <div className={styles["subtitle"]}>请创建首位超级管理员账号</div>

        <Form
          form={form}
          layout="vertical"
          onFinish={onFinish}
          autoComplete="off"
        >
          <Form.Item
            label="姓名"
            name="name"
            rules={[
              { required: true, message: "请输入姓名" },
              { min: 2, max: 20, message: "姓名长度为 2-20 个字符" },
            ]}
          >
            <Input placeholder="请输入姓名" />
          </Form.Item>

          <Form.Item
            label="邮箱"
            name="email"
            rules={[
              { required: true, message: "请输入邮箱" },
              { type: "email", message: "请输入合法邮箱" },
            ]}
          >
            <Input placeholder="用作登录账号" />
          </Form.Item>

          <Form.Item
            label="密码"
            name="password"
            extra="8-32 位，至少包含字母和数字"
            rules={[
              { required: true, message: "请输入密码" },
              { min: 8, max: 32, message: "密码长度为 8-32 个字符" },
              {
                pattern: /^(?=.*[A-Za-z])(?=.*\d).+$/,
                message: "密码必须同时包含字母和数字",
              },
            ]}
          >
            <Input.Password placeholder="请输入密码" />
          </Form.Item>

          <Form.Item
            label="确认密码"
            name="password_confirmation"
            dependencies={["password"]}
            rules={[
              { required: true, message: "请再次输入密码" },
              ({ getFieldValue }) => ({
                validator(_, value) {
                  if (!value || getFieldValue("password") === value) {
                    return Promise.resolve();
                  }
                  return Promise.reject(new Error("两次输入的密码不一致"));
                },
              }),
            ]}
          >
            <Input.Password placeholder="再次输入密码" />
          </Form.Item>

          <Form.Item>
            <Button
              type="primary"
              htmlType="submit"
              loading={loading}
              className={styles["submit"]}
            >
              创建并登录
            </Button>
          </Form.Item>
        </Form>
      </div>
    </div>
  );
};

export default SetupPage;
