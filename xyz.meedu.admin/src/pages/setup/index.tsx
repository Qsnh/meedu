import { useEffect, useMemo, useState } from "react";
import { Form, Input, Button, message } from "antd";
import { useNavigate } from "react-router-dom";
import { setup as setupApi } from "../../api";
import logoImg from "../../assets/home/logo.png";
import styles from "./index.module.scss";

type FormValues = {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
};

const SetupPage = () => {
  const navigate = useNavigate();
  const [form] = Form.useForm<FormValues>();
  const [loading, setLoading] = useState(false);
  const password = Form.useWatch("password", form) ?? "";

  useEffect(() => {
    document.title = "初始化超级管理员 · MeEdu";
  }, []);

  const passwordChecks = useMemo(
    () => [
      { key: "length", label: "8–32 位", met: password.length >= 8 && password.length <= 32 },
      { key: "letter", label: "含字母", met: /[A-Za-z]/.test(password) },
      { key: "digit", label: "含数字", met: /\d/.test(password) },
    ],
    [password]
  );

  const onFinish = async (values: FormValues) => {
    if (loading) return;
    setLoading(true);
    try {
      const res: any = await setupApi.submitSetup(values);
      const email = res?.data?.email ?? values.email;
      message.success("超级管理员创建成功，请登录");
      navigate(`/login?email=${encodeURIComponent(email)}`, { replace: true });
    } catch {
      setLoading(false);
    }
  };

  return (
    <div className={styles["setup-container"]}>
      <div className={styles["card"]}>
        <div className={styles["brand"]}>
          <img src={logoImg} alt="MeEdu" />
        </div>

        <div className={styles["eyebrow"]}>系统初始化</div>
        <h1 className={styles["title"]}>创建超级管理员</h1>
        <p className={styles["subtitle"]}>
          该账号将持有后台全部权限，请妥善保管登录凭据。
        </p>

        <Form
          form={form}
          layout="vertical"
          onFinish={onFinish}
          autoComplete="off"
          requiredMark={false}
          className={styles["form"]}
        >
          <Form.Item
            label="姓名"
            name="name"
            rules={[
              { required: true, message: "请输入姓名" },
              { min: 2, max: 20, message: "姓名长度为 2-20 个字符" },
            ]}
          >
            <Input placeholder="用于在后台显示和操作日志" />
          </Form.Item>

          <Form.Item
            label="邮箱"
            name="email"
            rules={[
              { required: true, message: "请输入邮箱" },
              { type: "email", message: "请输入合法邮箱" },
            ]}
          >
            <Input placeholder="将作为后续登录账号" />
          </Form.Item>

          <Form.Item
            label="密码"
            name="password"
            rules={[
              { required: true, message: "请输入密码" },
              { min: 8, max: 32, message: "密码长度为 8-32 个字符" },
              {
                pattern: /^(?=.*[A-Za-z])(?=.*\d).+$/,
                message: "密码必须同时包含字母和数字",
              },
            ]}
          >
            <Input.Password placeholder="设置后台登录密码" />
          </Form.Item>

          <ul className={styles["checklist"]} aria-label="密码要求">
            {passwordChecks.map((check) => (
              <li
                key={check.key}
                className={`${styles["check-item"]} ${check.met ? styles["met"] : ""}`}
              >
                {check.label}
              </li>
            ))}
          </ul>

          <Form.Item
            label="确认密码"
            name="password_confirmation"
            dependencies={["password"]}
            style={{ marginTop: 18 }}
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
            <Input.Password placeholder="再次输入以确认" />
          </Form.Item>

          <Form.Item className={styles["submit-row"]}>
            <Button
              type="primary"
              htmlType="submit"
              loading={loading}
              className={styles["submit"]}
            >
              创建并前往登录
            </Button>
            <div className={styles["footer-note"]}>
              创建成功后将跳转登录页，使用该邮箱与密码登录后台。
            </div>
          </Form.Item>
        </Form>
      </div>
    </div>
  );
};

export default SetupPage;
