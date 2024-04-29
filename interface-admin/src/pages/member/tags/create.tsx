import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Button, Input, message, Form, Space } from "antd";
import { member } from "../../../api/index";
import { useDispatch } from "react-redux";
import { titleAction } from "../../../store/user/loginUserSlice";
import { BackBartment } from "../../../components";

const MemberTagsCreatePage = () => {
  const [form] = Form.useForm();
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    document.title = "添加学员标签";
    dispatch(titleAction("添加学员标签"));
  }, []);

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    member
      .tagStore(values)
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

  return (
    <div className="meedu-main-body">
      <BackBartment title="添加学员标签" />
      <div className="float-left mt-30">
        <Form
          form={form}
          name="member-tag-create"
          labelCol={{ span: 3 }}
          wrapperCol={{ span: 21 }}
          initialValues={{ remember: true }}
          onFinish={onFinish}
          onFinishFailed={onFinishFailed}
          autoComplete="off"
        >
          <Form.Item
            label="标签名"
            name="name"
            rules={[{ required: true, message: "请输入标签名!" }]}
          >
            <Input
              style={{ width: 300 }}
              placeholder="请输入标签名"
              allowClear
            />
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

export default MemberTagsCreatePage;
