import { useState, useEffect } from "react";
import { message, DatePicker, Form, Button, Input, Space } from "antd";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { promocode } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import { BackBartment, HelperText } from "../../components";
import moment from "moment";

const PromoCodeCreateMultiPage = () => {
  const [form] = Form.useForm();
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    document.title = "优惠码批量生成";
    dispatch(titleAction("优惠码批量生成"));
  }, []);

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
      <BackBartment title="优惠码批量生成" />
      <div className="float-left mt-30">
        <Form
          form={form}
          name="promoCode-create-multi"
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
            <Input style={{ width: 300 }} placeholder="请输入前缀" allowClear />
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
export default PromoCodeCreateMultiPage;
