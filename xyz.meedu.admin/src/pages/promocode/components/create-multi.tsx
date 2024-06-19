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

export const PromocodeCreateMultiDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    if (props.open) {
      form.setFieldsValue({
        prefix: "",
        num: undefined,
        expired_at: undefined,
        money: undefined,
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
      .createMulti(values)
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
          title="优惠码批量生成"
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
              name="promocode-create-multi-dailog"
              labelCol={{ span: 3 }}
              wrapperCol={{ span: 21 }}
              initialValues={{ remember: true }}
              onFinish={onFinish}
              onFinishFailed={onFinishFailed}
              autoComplete="off"
            >
              <Form.Item
                label="统一前缀"
                name="prefix"
                rules={[{ required: true, message: "请输入前缀!" }]}
              >
                <Input
                  style={{ width: 300 }}
                  placeholder="请输入前缀"
                  allowClear
                />
              </Form.Item>
              <Form.Item
                label="生成数量"
                name="num"
                rules={[{ required: true, message: "请输入生成数量!" }]}
              >
                <Space align="baseline" style={{ height: 32 }}>
                  <Form.Item
                    name="num"
                    rules={[{ required: true, message: "请输入生成数量!" }]}
                  >
                    <Input
                      type="number"
                      style={{ width: 300 }}
                      placeholder="请输入生成数量"
                      allowClear
                    />
                  </Form.Item>
                  <div className="ml-10">
                    <HelperText text="请输入整数。为防止系统卡顿导致生成失败，请勿输入超过1000的数字。"></HelperText>
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
                    <HelperText text="该字段决定优惠码的有效期限，到了选定的时间就无法使用了。"></HelperText>
                  </div>
                </Space>
              </Form.Item>
              <Form.Item
                label="面值"
                name="money"
                rules={[{ required: true, message: "请输入面值!" }]}
              >
                <Space align="baseline" style={{ height: 32 }}>
                  <Form.Item
                    name="money"
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
                    <HelperText text="请输入整数。不支持小数。面值是学员使用该码在收银台可抵扣的金额。"></HelperText>
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
