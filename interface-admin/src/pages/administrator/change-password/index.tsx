import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { message, Form, Input, Button } from "antd";
import { useDispatch } from "react-redux";
import { administrator } from "../../../api/index";
import { titleAction } from "../../../store/user/loginUserSlice";

const ChangePasswordPage = () => {
  const [form] = Form.useForm();
  const dispatch = useDispatch();
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    document.title = "修改密码";
    dispatch(titleAction("修改密码"));
  }, []);

  const onFinish = (values: any) => {
    if (values.new_password !== values.new_password_confirmation) {
      message.error("两次输入新密码不一致");
      return;
    }
    administrator
      .changePassword({
        old_password: values.old_password,
        new_password: values.new_password,
        new_password_confirmation: values.new_password_confirmation,
      })
      .then((res: any) => {
        message.success("成功");
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  return (
    <div className={styles["change-password-box"]}>
      <Form
        form={form}
        name="change-password"
        labelCol={{ span: 4 }}
        wrapperCol={{ span: 20 }}
        initialValues={{ remember: true }}
        onFinish={onFinish}
        onFinishFailed={onFinishFailed}
        autoComplete="off"
      >
        <Form.Item
          label="原密码"
          name="old_password"
          rules={[{ required: true, message: "请输入原密码!" }]}
        >
          <Input.Password
            allowClear
            style={{
              width: 400,
              height: 40,
              borderRadius: 4,
              border: "1px solid #DCDFE6",
            }}
            placeholder="请输入原密码"
          />
        </Form.Item>
        <Form.Item
          label="新密码"
          name="new_password"
          rules={[{ required: true, message: "请输入新密码!" }]}
        >
          <Input.Password
            allowClear
            style={{
              width: 400,
              height: 40,
              borderRadius: 4,
              border: "1px solid #DCDFE6",
            }}
            placeholder="请输入新密码"
          />
        </Form.Item>
        <Form.Item
          label="确认新密码"
          name="new_password_confirmation"
          rules={[{ required: true, message: "请确认新密码!" }]}
        >
          <Input.Password
            allowClear
            style={{
              width: 400,
              height: 40,
              borderRadius: 4,
              border: "1px solid #DCDFE6",
            }}
            placeholder="请确认新密码"
          />
        </Form.Item>
        <Form.Item wrapperCol={{ offset: 4, span: 20 }}>
          <Button
            type="primary"
            htmlType="submit"
            style={{ width: 70, height: 40 }}
          >
            提交
          </Button>
        </Form.Item>
      </Form>
    </div>
  );
};

export default ChangePasswordPage;
