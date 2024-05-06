import { useEffect, useState } from "react";
import { Modal, Form, Input, message, Select, Switch, DatePicker } from "antd";
import { member } from "../../../api/index";
import moment from "moment";

interface PropsInterface {
  open: boolean;
  ids: any[];
  roles: any[];
  tags: any[];
  onCancel: () => void;
  onSuccess: () => void;
}

export const ConfigUpdateDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);
  const [current, setCurrent] = useState<string>("");

  const types = [
    {
      label: "批量设置会员",
      value: "role_id",
    },
    {
      label: "批量设置标签",
      value: "tag",
    },
    {
      label: "批量冻结账号",
      value: "is_lock",
    },
  ];

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
    if (values.role_id && !values.role_expired_at) {
      message.error("请选择VIP过期时间");
      return;
    }
    if (!values.role_id && values.role_expired_at) {
      message.error("请选择VIP");
      return;
    }
    setLoading(true);
    values.user_ids = props.ids;
    member
      .editMulti({
        user_ids: props.ids,
        field: current,
        value:
          current === "tag"
            ? null
            : current === "is_lock"
            ? values.is_lock
            : values.role_id,
        role_expired_at: values.role_expired_at
          ? moment(new Date(values.role_expired_at)).format(
              "YYYY-MM-DD HH:mm:ss"
            )
          : null,
        tag_ids: values.tag_ids,
      })
      .then((res: any) => {
        setLoading(false);
        message.success("成功！");
        setCurrent("");
        props.onSuccess();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const onLockSwitch = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ is_lock: 1 });
    } else {
      form.setFieldsValue({ is_lock: 0 });
    }
  };

  return (
    <>
      {props.open ? (
        <Modal
          title="批量修改"
          onCancel={() => {
            props.onCancel();
          }}
          open={true}
          width={450}
          maskClosable={false}
          onOk={() => {
            form.submit();
          }}
          centered
        >
          <div className="float-left mt-30">
            <Form
              form={form}
              name="config-update-dailog"
              labelCol={{ span: 7 }}
              wrapperCol={{ span: 17 }}
              initialValues={{ remember: true }}
              onFinish={onFinish}
              onFinishFailed={onFinishFailed}
              autoComplete="off"
            >
              <Form.Item
                label="设置"
                name="field"
                rules={[{ required: true, message: "请选择设置!" }]}
              >
                <Select
                  style={{ width: "100%" }}
                  onChange={(e) => {
                    setCurrent(e);
                  }}
                  allowClear
                  placeholder="请选择"
                  options={types}
                />
              </Form.Item>
              {current === "is_lock" && (
                <Form.Item
                  label="是否冻结账号"
                  name="is_lock"
                  valuePropName="checked"
                  rules={[{ required: true, message: "请选择是否冻结账号!" }]}
                >
                  <Switch onChange={onLockSwitch} />
                </Form.Item>
              )}
              {current === "role_id" && (
                <>
                  <Form.Item
                    label="设置会员"
                    name="role_id"
                    rules={[{ required: true, message: "请选择会员!" }]}
                  >
                    <Select
                      style={{ width: "100%" }}
                      allowClear
                      placeholder="请选择会员"
                      options={props.roles}
                    />
                  </Form.Item>
                  <Form.Item
                    label="会员到期时间"
                    name="role_expired_at"
                    rules={[{ required: true, message: "请选择会员到期时间!" }]}
                  >
                    <DatePicker
                      format="YYYY-MM-DD HH:mm:ss"
                      style={{ width: 300 }}
                      showTime
                      placeholder="选择日期"
                    />
                  </Form.Item>
                </>
              )}
              {current === "tag" && (
                <Form.Item
                  label="设置标签"
                  name="tag_ids"
                  rules={[{ required: true, message: "请选择标签!" }]}
                >
                  <Select
                    style={{ width: "100%" }}
                    allowClear
                    mode="multiple"
                    placeholder="请选择标签"
                    options={props.tags}
                  />
                </Form.Item>
              )}
            </Form>
          </div>
        </Modal>
      ) : null}
    </>
  );
};
