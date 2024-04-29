import { useEffect, useState } from "react";
import {
  Row,
  Col,
  Modal,
  Form,
  Input,
  message,
  Select,
  DatePicker,
  Space,
} from "antd";
import { member } from "../../../api/index";
import moment from "moment";
import { UploadImageButton, HelperText } from "../../../components";

interface PropsInterface {
  open: boolean;
  roles: any[];
  onCancel: () => void;
  onSuccess: () => void;
}

export const MemberCreateDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);
  const [avatar, setAvatar] = useState<string>("");
  const [role_id, setRoleId] = useState<any>(null);

  useEffect(() => {
    if (props.open) {
      form.setFieldsValue({
        nick_name: "",
        avatar: "",
        password: "",
        mobile: "",
        role_expired_at: "",
        role_id: [],
      });
      setRoleId(null);
      setAvatar("");
    }
  }, [props.open]);

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    if (
      values.role_id &&
      values.role_id.length !== 0 &&
      !values.role_expired_at
    ) {
      message.error("请选择VIP过期时间");
      return;
    }
    values.role_expired_at = values.role_expired_at
      ? moment(new Date(values.role_expired_at)).format("YYYY-MM-DD HH:mm:ss")
      : "";
    setLoading(true);
    member
      .store(values)
      .then((res: any) => {
        setLoading(false);
        message.success("成功！");
        props.onSuccess();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  return (
    <>
      {props.open ? (
        <Modal
          title="添加学员资料"
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
        >
          <div className="float-left mt-30">
            <Form
              form={form}
              name="member-create-dailog"
              labelCol={{ span: 3 }}
              wrapperCol={{ span: 21 }}
              initialValues={{ remember: true }}
              onFinish={onFinish}
              onFinishFailed={onFinishFailed}
              autoComplete="off"
            >
              <Form.Item
                label="学员昵称"
                name="nick_name"
                rules={[{ required: true, message: "请输入学员昵称!" }]}
              >
                <Input
                  style={{ width: 300 }}
                  placeholder="请输入学员昵称"
                  allowClear
                />
              </Form.Item>
              <Form.Item
                label="学员头像"
                name="avatar"
                rules={[{ required: true, message: "请上传学员头像!" }]}
              >
                <Space align="baseline" style={{ height: 32 }}>
                  <Form.Item
                    name="avatar"
                    rules={[{ required: true, message: "请上传学员头像!" }]}
                  >
                    <UploadImageButton
                      text="上传头像"
                      onSelected={(url) => {
                        form.setFieldsValue({ avatar: url });
                        setAvatar(url);
                      }}
                    ></UploadImageButton>
                  </Form.Item>
                  <div className="ml-10">
                    <HelperText text="建议尺寸：100x100"></HelperText>
                  </div>
                </Space>
              </Form.Item>
              {avatar && (
                <Row style={{ marginBottom: 22 }}>
                  <Col span={3}></Col>
                  <Col span={21}>
                    <div
                      className="contain-thumb-box"
                      style={{
                        backgroundImage: `url(${avatar})`,
                        width: 100,
                        height: 100,
                      }}
                    ></div>
                  </Col>
                </Row>
              )}
              <Form.Item
                label="手机号码"
                name="mobile"
                rules={[{ required: true, message: "请输入手机号码!" }]}
              >
                <Input
                  type="number"
                  style={{ width: 300 }}
                  placeholder="填输入学员登录手机号码"
                  allowClear
                />
              </Form.Item>
              <Form.Item
                label="登录密码"
                name="password"
                rules={[{ required: true, message: "请输入登录密码!" }]}
              >
                <Input.Password
                  style={{ width: 300 }}
                  placeholder="填输入登录密码"
                  allowClear
                />
              </Form.Item>
              <Form.Item label="设置会员" name="role_id">
                <Select
                  style={{ width: 300 }}
                  onChange={(e) => {
                    setRoleId(e);
                  }}
                  placeholder="请选择会员"
                  allowClear
                  options={props.roles}
                />
              </Form.Item>
              <div style={{ display: role_id ? "block" : "none" }}>
                <Form.Item label="会员到期" name="role_expired_at">
                  <DatePicker
                    format="YYYY-MM-DD HH:mm:ss"
                    style={{ width: 300 }}
                    showTime
                    placeholder="授权会员到期时间"
                  />
                </Form.Item>
              </div>
            </Form>
          </div>
        </Modal>
      ) : null}
    </>
  );
};
