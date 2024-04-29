import { useEffect, useState } from "react";
import { Modal, Form, Input, message } from "antd";
import { member } from "../../../api/index";

interface PropsInterface {
  open: boolean;
  ids: any[];
  mid: number;
  onCancel: () => void;
  onSuccess: () => void;
}

export const SendMessageDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    if (props.open) {
      form.setFieldsValue({
        message: "",
      });
    }
  }, [props.open]);

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    if (props.mid === 0) {
      values.user_ids = props.ids;
      member
        .sendMessageMulti(values)
        .then((res: any) => {
          setLoading(false);
          message.success("成功！");
          props.onSuccess();
        })
        .catch((e) => {
          setLoading(false);
        });
    } else {
      member
        .sendMessage(props.mid, values)
        .then((res: any) => {
          setLoading(false);
          message.success("成功！");
          props.onSuccess();
        })
        .catch((e) => {
          setLoading(false);
        });
    }
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  return (
    <>
      {props.open ? (
        <Modal
          title="发消息"
          onCancel={() => {
            props.onCancel();
          }}
          open={true}
          width={400}
          maskClosable={false}
          onOk={() => {
            form.submit();
          }}
          centered
        >
          <div className="float-left mt-30">
            <Form
              form={form}
              name="message-send-dailog"
              labelCol={{ span: 6 }}
              wrapperCol={{ span: 18 }}
              initialValues={{ remember: true }}
              onFinish={onFinish}
              onFinishFailed={onFinishFailed}
              autoComplete="off"
            >
              <Form.Item
                label="消息文本"
                name="message"
                rules={[{ required: true, message: "请输入消息文本!" }]}
              >
                <Input.TextArea
                  style={{ width: "100%" }}
                  placeholder="请输入消息文本"
                  allowClear
                  rows={4}
                  maxLength={500}
                  showCount
                />
              </Form.Item>
            </Form>
          </div>
        </Modal>
      ) : null}
    </>
  );
};
