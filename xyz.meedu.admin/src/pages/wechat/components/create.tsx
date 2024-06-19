import { useEffect, useState } from "react";
import { Modal, Form, Input, message, Select, Space } from "antd";
import { HelperText } from "../../../components";
import { wechat } from "../../../api/index";

interface PropsInterface {
  open: boolean;
  onCancel: () => void;
  onSuccess: () => void;
}

export const WechatCreateDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);
  const [types, setTypes] = useState<any>([]);
  const [type, setType] = useState<string>("");
  const events = [
    {
      value: "subscribe",
      label: "用户关注",
    },
    {
      value: "CLICK",
      label: "自定义菜单事件",
    },
  ];

  const getParams = () => {
    wechat.create().then((res: any) => {
      const arr = [];
      let types = res.data.types;
      for (let i = 0; i < types.length; i++) {
        arr.push({
          label: types[i].name,
          value: types[i].id,
        });
      }
      setTypes(arr);
    });
  };

  useEffect(() => {
    if (props.open) {
      getParams();
      form.setFieldsValue({
        rule: "",
        type: undefined,
        event_type: undefined,
        event_key: undefined,
        reply_content: "",
      });
    }
  }, [props.open]);

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    wechat
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
          title="新建自动回复"
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
              name="wechat-create-dailog"
              labelCol={{ span: 3 }}
              wrapperCol={{ span: 21 }}
              initialValues={{ remember: true }}
              onFinish={onFinish}
              onFinishFailed={onFinishFailed}
              autoComplete="off"
            >
              <Form.Item
                label="消息类型"
                name="type"
                rules={[{ required: true, message: "请选择消息类型!" }]}
              >
                <Select
                  style={{ width: 300 }}
                  allowClear
                  placeholder="请选择消息类型"
                  options={types}
                  onChange={(e) => {
                    setType(e);
                  }}
                />
              </Form.Item>
              {type === "text" && (
                <Form.Item label="触发关键字">
                  <Space align="baseline" style={{ height: 32 }}>
                    <Form.Item name="rule">
                      <Input
                        style={{ width: 300 }}
                        placeholder="请输入触发关键字"
                        allowClear
                      />
                    </Form.Item>
                    <div className="ml-10">
                      <HelperText text="支持正则表达式"></HelperText>
                    </div>
                  </Space>
                </Form.Item>
              )}
              {type === "event" && (
                <>
                  <Form.Item label="事件" name="event_type">
                    <Select
                      style={{ width: 300 }}
                      allowClear
                      placeholder="请选择事件"
                      options={events}
                    />
                  </Form.Item>
                  <Form.Item label="事件key" name="event_key">
                    <Input
                      style={{ width: 300 }}
                      allowClear
                      placeholder="请输入事件key"
                    />
                  </Form.Item>
                </>
              )}
              <Form.Item
                label="回复内容"
                name="reply_content"
                rules={[{ required: true, message: "请输入回复内容!" }]}
              >
                <Input.TextArea
                  style={{ width: 500, minHeight: 120 }}
                  placeholder="请输入回复内容"
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
