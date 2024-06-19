import { useEffect, useState } from "react";
import { Modal, Form, Input, message, DatePicker, Space } from "antd";
import { HelperText } from "../../../components";
import { promocode } from "../../../api/index";
import moment from "moment";

interface PropsInterface {
  open: boolean;
  onCancel: () => void;
  onSuccess: () => void;
}

export const PromocodeCreateDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    if (props.open) {
      form.setFieldsValue({
        code: "",
        expired_at: undefined,
        invited_user_reward: undefined,
        use_times: undefined,
      });
    }
  }, [props.open]);

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    values.expired_at = moment(new Date(values.expired_at)).format(
      "YYYY-MM-DD HH:mm"
    );
    promocode
      .create(values)
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
          title="新建优惠码"
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
              name="promocode-create-dailog"
              labelCol={{ span: 3 }}
              wrapperCol={{ span: 21 }}
              initialValues={{ remember: true }}
              onFinish={onFinish}
              onFinishFailed={onFinishFailed}
              autoComplete="off"
            >
              <Form.Item
                label="优惠码"
                name="code"
                rules={[{ required: true, message: "请输入优惠码!" }]}
              >
                <Space align="baseline" style={{ height: 32 }}>
                  <Form.Item
                    name="code"
                    rules={[{ required: true, message: "请输入优惠码!" }]}
                  >
                    <Input
                      style={{ width: 300 }}
                      placeholder="请输入优惠码"
                      allowClear
                    />
                  </Form.Item>
                  <div className="ml-10">
                    <HelperText text="请勿使用大写U或者小写u开头"></HelperText>
                  </div>
                </Space>
              </Form.Item>

              <Form.Item label="到期时间" required={true}>
                <Space align="baseline" style={{ height: 32 }}>
                  <Form.Item
                    name="expired_at"
                    rules={[{ required: true, message: "请选择到期时间!" }]}
                  >
                    <DatePicker
                      format="YYYY-MM-DD HH:mm"
                      style={{ width: 300 }}
                      showTime
                      placeholder="请选择到期时间"
                    />
                  </Form.Item>
                  <div className="ml-10">
                    <HelperText text="过期时间到了之后优惠码便无法使用了"></HelperText>
                  </div>
                </Space>
              </Form.Item>
              <Form.Item
                label="面值"
                name="invited_user_reward"
                rules={[{ required: true, message: "请输入面值!" }]}
              >
                <Space align="baseline" style={{ height: 32 }}>
                  <Form.Item
                    name="invited_user_reward"
                    rules={[{ required: true, message: "请输入面值!" }]}
                  >
                    <Input
                      type="number"
                      style={{ width: 300 }}
                      placeholder="请输入面值"
                      allowClear
                    />
                  </Form.Item>
                  <div className="ml-10">
                    <HelperText text="请输入整数。不支持小数。可在收银台抵扣的金额。"></HelperText>
                  </div>
                </Space>
              </Form.Item>
              <Form.Item
                label="可使用次数"
                name="use_times"
                rules={[{ required: true, message: "请输入可使用次数!" }]}
              >
                <Space align="baseline" style={{ height: 32 }}>
                  <Form.Item
                    name="use_times"
                    rules={[{ required: true, message: "请输入可使用次数!" }]}
                  >
                    <Input
                      type="number"
                      style={{ width: 300 }}
                      placeholder="请输入可使用次数"
                      allowClear
                    />
                  </Form.Item>
                  <div className="ml-10">
                    <HelperText text="请输入整数。0意味着不限制。"></HelperText>
                  </div>
                </Space>
              </Form.Item>
            </Form>
          </div>
        </Modal>
      ) : null}
    </>
  );
};
