import { useEffect, useState } from "react";
import { Modal, Form, Input, message, Switch, Space } from "antd";
import { HelperText } from "../../../components";
import { role } from "../../../api/index";

interface PropsInterface {
  open: boolean;
  id: number;
  onCancel: () => void;
  onSuccess: () => void;
}

export const RoletUpdateDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [init, setInit] = useState<boolean>(true);
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    if (props.open && props.id > 0) {
      setInit(true);
      initData();
    }
  }, [props.open, props.id]);

  const initData = async () => {
    await getDetail();
    setInit(false);
  };

  const getDetail = async () => {
    const res: any = await role.detail(props.id);
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
      .update(props.id, values)
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

  const onChange = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ is_show: 1 });
    } else {
      form.setFieldsValue({ is_show: 0 });
    }
  };

  return (
    <>
      {props.open ? (
        <Modal
          title="编辑会员"
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
              name="role-update-dailog"
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
        </Modal>
      ) : null}
    </>
  );
};
