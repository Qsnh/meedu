import { useEffect, useState } from "react";
import { Modal, Form, Input, message, Select, Space, Spin } from "antd";
import { HelperText } from "../../../components";
import { wechat } from "../../../api/index";

interface PropsInterface {
  open: boolean;
  id: number;
  onCancel: () => void;
  onSuccess: () => void;
}

export const WechatUpdateDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [init, setInit] = useState<boolean>(true);
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

  const getParams = async () => {
    const res: any = await wechat.create();
    const arr = [];
    let types = res.data.types;
    for (let i = 0; i < types.length; i++) {
      arr.push({
        label: types[i].name,
        value: types[i].id,
      });
    }
    setTypes(arr);
  };

  useEffect(() => {
    if (props.open && props.id > 0) {
      setInit(true);
      initData();
    }
  }, [props.open, props.id]);

  const initData = async () => {
    await getParams();
    await getDetail();
    setInit(false);
  };

  const getDetail = async () => {
    const res: any = await wechat.detail(props.id);
    var data = res.data.data;
    setType(data.type);
    form.setFieldsValue({
      reply_content: data.reply_content,
      event_key: data.event_key,
      rule: data.rule,
      event_type: data.event_type,
      type: data.type,
    });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    wechat
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

  return (
    <>
      {props.open ? (
        <Modal
          title="编辑自动回复"
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
              name="wechat-update-dailog"
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
