import React, { useState, useEffect } from "react";
import { Form, Input, Button, Space, message } from "antd";
import { system } from "../../../../../api";
import { HelperText } from "../../../../../components";

interface PropInterface {
  open: boolean;
  id: number;
  onClose: () => void;
}

export const LinksUpdate: React.FC<PropInterface> = ({ id, open, onClose }) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    if (open && id) {
      getDetail();
    }
  }, [open, id]);

  const getDetail = () => {
    if (id === 0) {
      return;
    }
    system.linksDetail(id).then((res: any) => {
      let data = res.data;
      form.setFieldsValue({
        sort: data.sort,
        name: data.name,
        url: data.url,
      });
    });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .linksUpdate(id, values)
      .then((res: any) => {
        setLoading(false);
        message.success("成功！");
        onClose();
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
      {open && (
        <div className="meedu-dialog-mask">
          <div className="meedu-dialog-box">
            <div className="meedu-dialog-header">编辑友情链接</div>
            <div className="meedu-dialog-body">
              <Form
                form={form}
                name="links-update"
                labelCol={{ span: 3 }}
                wrapperCol={{ span: 21 }}
                initialValues={{ remember: true }}
                onFinish={onFinish}
                onFinishFailed={onFinishFailed}
                autoComplete="off"
              >
                <Form.Item
                  label="排序值"
                  name="sort"
                  rules={[{ required: true, message: "填输入排序!" }]}
                >
                  <Space align="baseline" style={{ height: 32 }}>
                    <Form.Item
                      name="sort"
                      rules={[{ required: true, message: "填输入排序!" }]}
                    >
                      <Input
                        type="number"
                        style={{ width: 300 }}
                        placeholder="填输入排序"
                        allowClear
                      />
                    </Form.Item>
                    <div className="ml-10">
                      <HelperText text="填写整数，数字越小排序越靠前"></HelperText>
                    </div>
                  </Space>
                </Form.Item>
                <Form.Item
                  label="链接名"
                  name="name"
                  rules={[{ required: true, message: "填输入链接名!" }]}
                >
                  <Input
                    style={{ width: 300 }}
                    placeholder="填输入链接名"
                    allowClear
                  />
                </Form.Item>
                <Form.Item
                  label="链接地址"
                  name="url"
                  rules={[{ required: true, message: "填输入链接地址!" }]}
                >
                  <Input
                    style={{ width: 300 }}
                    placeholder="填输入链接地址"
                    allowClear
                  />
                </Form.Item>
              </Form>
            </div>
            <div className="meedu-dialog-footer">
              <Button
                loading={loading}
                type="primary"
                onClick={() => form.submit()}
              >
                确定
              </Button>
              <Button className="ml-10" onClick={() => onClose()}>
                取消
              </Button>
            </div>
          </div>
        </div>
      )}
    </>
  );
};
