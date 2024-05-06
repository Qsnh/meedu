import { useEffect, useState } from "react";
import { Button, Row, Col, Modal, Form, Select, Input, message } from "antd";
import { HelperText } from "../../../../components";
import { order } from "../../../../api/index";

interface PropsInterface {
  open: boolean;
  order: any;
  onCancel: () => void;
  onSuccess: () => void;
}

export const RefundDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);
  const [value, setValue] = useState(0);
  const types = [
    {
      label: "原渠道退回",
      value: 0,
    },
    {
      label: "线下退款（线上记录）",
      value: 1,
    },
  ];

  useEffect(() => {
    if (props.open) {
      form.setFieldsValue({
        amount: "",
        is_local: [],
        reason: "",
      });
    }
  }, [props.open]);

  useEffect(() => {
    if (props.order.charge) {
      let total = props.order.charge;
      let num = getRecharge(props.order);
      let refund = 0;
      if (props.order.is_refund === 0) {
        refund = 0;
      } else if (props.order.refund) {
        refund = showRefund(props.order.refund);
      } else {
        refund = 0;
      }
      let val = total - num - refund;
      setValue(val);
    } else {
      setValue(0);
    }
  }, [props.order]);

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    if (value <= 0) {
      message.error("无法申请退款");
      return;
    }
    if (Number(values.amount) > value) {
      message.error("超过可退金额");
      return;
    }
    values.amount = Number(values.amount) * 100;
    setLoading(true);
    order
      .refund(props.order.id, values)
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

  const getRecharge = (item: any) => {
    let amount = 0;
    for (let i = 0; i < item.paid_records.length; i++) {
      if (item.paid_records[i].paid_type === 1) {
        amount += item.paid_records[i].paid_total;
      }
    }

    return amount;
  };

  const showRefund = (item: any) => {
    let amount = 0;
    for (let i = 0; i < item.length; i++) {
      if (item[i].status === 1 || item[i].status === 5) {
        amount += item[i].amount / 100;
      }
    }
    return amount;
  };

  return (
    <>
      {props.open ? (
        <Modal
          title="退款"
          onCancel={() => {
            props.onCancel();
          }}
          open={true}
          width={430}
          maskClosable={false}
          onOk={() => {
            form.submit();
          }}
          centered
        >
          <div className="float-left  mt-30">
            <HelperText text="退款成功不会自动取消课程/会员绑定关系，需手动操作。"></HelperText>
          </div>
          <div className="float-left mb-30 mt-30 ">
            订单支付总额：¥{props.order.charge}
            ，优惠码支付金额：¥{getRecharge(props.order)}，已退金额： ¥
            {props.order.is_refund === 0
              ? 0
              : props.order.refund
              ? showRefund(props.order.refund)
              : 0}
            ，
            <span className="c-red">
              可退金额：¥
              {value}
            </span>
          </div>
          <div className="float-left">
            <Form
              form={form}
              name="refund-dailog"
              labelCol={{ span: 5 }}
              wrapperCol={{ span: 19 }}
              initialValues={{ remember: true }}
              onFinish={onFinish}
              onFinishFailed={onFinishFailed}
              autoComplete="off"
            >
              <Form.Item
                label="退款方式"
                name="is_local"
                rules={[{ required: true, message: "请选择退款方式!" }]}
              >
                <Select
                  style={{ width: 300 }}
                  allowClear
                  placeholder="请选择退款方式"
                  options={types}
                />
              </Form.Item>

              <Form.Item
                label="退款金额"
                name="amount"
                rules={[{ required: true, message: "请输入退款金额!" }]}
              >
                <Input
                  type="number"
                  addonAfter="元"
                  style={{ width: 300 }}
                  placeholder="请输入退款金额"
                  allowClear
                />
              </Form.Item>
              <Form.Item
                label="退款理由"
                name="reason"
                rules={[{ required: true, message: "请输入退款理由!" }]}
              >
                <Input.TextArea
                  style={{ width: 300 }}
                  placeholder="请输入退款理由"
                  allowClear
                  rows={4}
                  maxLength={64}
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
