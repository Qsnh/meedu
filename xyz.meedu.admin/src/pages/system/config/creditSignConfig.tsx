import { useState, useEffect } from "react";
import { Spin, Form, Input, message, Button } from "antd";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { titleAction } from "../../../store/user/loginUserSlice";
import { system } from "../../../api/index";
import { BackBartment } from "../../../components";

const SystemCreditSignConfigPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(true);
  const enabledAddons = useSelector(
    (state: any) => state.enabledAddonsConfig.value.enabledAddons
  );

  useEffect(() => {
    document.title = "积分配置";
    dispatch(titleAction("积分配置"));
    getDetail();
  }, []);

  const getDetail = () => {
    system
      .setting()
      .then((res: any) => {
        let newConfig = res.data["积分"];
        for (let index in newConfig) {
          if (newConfig[index].key === "meedu.member.credit1.register") {
            form.setFieldsValue({
              "meedu.member.credit1.register": newConfig[index].value,
            });
          } else if (
            newConfig[index].key === "meedu.member.credit1.watched_course"
          ) {
            form.setFieldsValue({
              "meedu.member.credit1.watched_course": newConfig[index].value,
            });
          } else if (
            newConfig[index].key === "meedu.member.credit1.watched_video"
          ) {
            form.setFieldsValue({
              "meedu.member.credit1.watched_video": newConfig[index].value,
            });
          } else if (
            newConfig[index].key === "meedu.member.credit1.paid_order"
          ) {
            form.setFieldsValue({
              "meedu.member.credit1.paid_order": newConfig[index].value,
            });
          }
        }
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .saveSetting({
        config: values,
      })
      .then((res: any) => {
        setLoading(false);
        message.success("成功！");
        getDetail();
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
      <BackBartment title="积分配置"></BackBartment>
      {loading && (
        <div
          style={{
            width: "100%",
            textAlign: "center",
            paddingTop: 50,
            paddingBottom: 30,
            boxSizing: "border-box",
          }}
        >
          <Spin />
        </div>
      )}
      {!loading && (
        <div className="float-left mt-30">
          <Form
            form={form}
            name="system-creditSign-config"
            labelCol={{ span: 3 }}
            wrapperCol={{ span: 21 }}
            initialValues={{ remember: true }}
            onFinish={onFinish}
            onFinishFailed={onFinishFailed}
            autoComplete="off"
          >
            <Form.Item label="注册奖励" name="meedu.member.credit1.register">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item
              label="看完课程"
              name="meedu.member.credit1.watched_course"
            >
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item
              label="看完视频"
              name="meedu.member.credit1.watched_video"
            >
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="支付订单" name="meedu.member.credit1.paid_order">
              <Form.Item name="meedu.member.credit1.paid_order">
                <Input style={{ width: 300 }} allowClear />
              </Form.Item>
              <div className="form-helper-text">
                <span>
                  注意，支付订单的积分奖励与上面不同，它是根据订单金额*百分比奖励的，所以这里应该填写百分比。举个例子：订单支付金额100元，这里填写0.1，则用户奖励10积分。
                </span>
              </div>
            </Form.Item>
          </Form>
        </div>
      )}
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

export default SystemCreditSignConfigPage;
