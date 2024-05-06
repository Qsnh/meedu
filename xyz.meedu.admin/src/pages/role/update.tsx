import { useState, useEffect } from "react";
import { useNavigate, useLocation } from "react-router-dom";
import { Button, Input, message, Form, Space, Switch, Spin } from "antd";
import { role } from "../../api/index";
import { useDispatch } from "react-redux";
import { titleAction } from "../../store/user/loginUserSlice";
import { BackBartment, HelperText } from "../../components";

const RoleUpdatePage = () => {
  const result = new URLSearchParams(useLocation().search);
  const [form] = Form.useForm();
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [init, setInit] = useState<boolean>(true);
  const [loading, setLoading] = useState<boolean>(false);
  const [id, setId] = useState(Number(result.get("id")));

  useEffect(() => {
    document.title = "编辑会员";
    dispatch(titleAction("编辑会员"));
    initData();
  }, [id]);

  useEffect(() => {
    setId(Number(result.get("id")));
  }, [result.get("id")]);

  const initData = async () => {
    await getDetail();
    setInit(false);
  };

  const getDetail = async () => {
    if (id === 0) {
      return;
    }
    const res: any = await role.detail(id);
    var data = res.data;
    form.setFieldsValue({
      description: data.description,
      name: data.name,
      is_show: data.is_show,
      charge: data.charge,
      expire_days: data.expire_days,
    });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    role
      .update(id, values)
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
      form.setFieldsValue({ is_show: 1 });
    } else {
      form.setFieldsValue({ is_show: 0 });
    }
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="编辑会员" />
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
          name="role-update"
          labelCol={{ span: 3 }}
          wrapperCol={{ span: 21 }}
          initialValues={{ remember: true }}
          onFinish={onFinish}
          onFinishFailed={onFinishFailed}
          autoComplete="off"
        >
          <Form.Item
            label="VIP名"
            name="name"
            rules={[{ required: true, message: "请输入VIP名!" }]}
          >
            <Input
              style={{ width: 300 }}
              placeholder="请输入VIP名"
              allowClear
            />
          </Form.Item>
          <Form.Item
            label="天数"
            name="expire_days"
            rules={[{ required: true, message: "请输入天数!" }]}
          >
            <Space align="baseline" style={{ height: 32 }}>
              <Form.Item
                name="expire_days"
                rules={[{ required: true, message: "请输入天数!" }]}
              >
                <Input
                  type="number"
                  style={{ width: 300 }}
                  placeholder="请输入天数"
                  allowClear
                />
              </Form.Item>
              <div className="ml-10">
                <HelperText text="决定用户购买VIP之后可享受的天数。"></HelperText>
              </div>
            </Space>
          </Form.Item>
          <Form.Item
            label="价格"
            name="charge"
            rules={[{ required: true, message: "请输入价格!" }]}
          >
            <Space align="baseline" style={{ height: 32 }}>
              <Form.Item
                name="charge"
                rules={[{ required: true, message: "请输入价格!" }]}
              >
                <Input
                  type="number"
                  style={{ width: 300 }}
                  placeholder="请输入价格"
                  allowClear
                />
              </Form.Item>
              <div className="ml-10">
                <HelperText text="请输入整数。不支持小数。"></HelperText>
              </div>
            </Space>
          </Form.Item>
          <Form.Item label="显示">
            <Space align="baseline" style={{ height: 32 }}>
              <Form.Item name="is_show" valuePropName="checked">
                <Switch onChange={onChange} />
              </Form.Item>
              <div className="ml-10">
                <HelperText text="控制用户是否能够看到并购买该VIP"></HelperText>
              </div>
            </Space>
          </Form.Item>
          <Form.Item
            label="描述"
            name="description"
            rules={[{ required: true, message: "请输入描述!" }]}
          >
            <Input.TextArea
              style={{ width: 500, minHeight: 120 }}
              placeholder="一行一个描述"
              allowClear
              maxLength={200}
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

export default RoleUpdatePage;
