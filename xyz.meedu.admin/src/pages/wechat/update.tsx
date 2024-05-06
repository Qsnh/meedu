import { useState, useEffect } from "react";
import { useNavigate, useLocation } from "react-router-dom";
import { Button, Input, message, Form, Space, Select, Spin } from "antd";
import { wechat } from "../../api/index";
import { useDispatch } from "react-redux";
import { titleAction } from "../../store/user/loginUserSlice";
import { BackBartment, HelperText } from "../../components";

const WechatUpdatePage = () => {
  const result = new URLSearchParams(useLocation().search);
  const [form] = Form.useForm();
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [init, setInit] = useState<boolean>(true);
  const [loading, setLoading] = useState<boolean>(false);
  const [types, setTypes] = useState<any>([]);
  const [type, setType] = useState<string>("");
  const [id, setId] = useState(Number(result.get("id")));
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

  useEffect(() => {
    document.title = "编辑自动回复";
    dispatch(titleAction("编辑自动回复"));
    initData();
  }, [id]);

  useEffect(() => {
    setId(Number(result.get("id")));
  }, [result.get("id")]);

  const initData = async () => {
    await getParams();
    await getDetail();
    setInit(false);
  };

  const getDetail = async () => {
    if (id === 0) {
      return;
    }
    const res: any = await wechat.detail(id);
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

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    wechat
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

  return (
    <div className="meedu-main-body">
      <BackBartment title="编辑自动回复" />
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
          name="wechat-update"
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

export default WechatUpdatePage;
