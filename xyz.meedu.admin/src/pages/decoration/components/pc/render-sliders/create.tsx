import React, { useState, useEffect } from "react";
import { Row, Col, Form, Input, Button, Space, message } from "antd";
import { system } from "../../../../../api";
import {
  HelperText,
  UploadImageButton,
  PCLink,
} from "../../../../../components";

interface PropInterface {
  open: boolean;
  onClose: () => void;
}

export const SlidersCreate: React.FC<PropInterface> = ({ open, onClose }) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);
  const [thumb, setThumb] = useState<string>("");
  const [showLinkWin, setShowLinkWin] = useState<boolean>(false);

  useEffect(() => {
    if (open) {
      form.setFieldsValue({
        thumb: "",
        sort: "",
        url: "",
      });
      setThumb("");
    }
  }, [open]);

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    values.platform = "PC";

    setLoading(true);
    system
      .slidersStore(values)
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
            <div className="meedu-dialog-header">添加幻灯片</div>
            <div className="meedu-dialog-body">
              <Form
                form={form}
                name="sliders-create"
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
                  label="幻灯片"
                  name="thumb"
                  rules={[{ required: true, message: "请上传幻灯片!" }]}
                >
                  <Space align="baseline" style={{ height: 32 }}>
                    <Form.Item
                      name="thumb"
                      rules={[{ required: true, message: "请上传幻灯片!" }]}
                    >
                      <UploadImageButton
                        text="上传图片"
                        scene="decoration"
                        onSelected={(url) => {
                          form.setFieldsValue({ thumb: url });
                          setThumb(url);
                        }}
                      ></UploadImageButton>
                    </Form.Item>
                    <div className="ml-10">
                      <HelperText text="推荐1200x400 宽高比3:1"></HelperText>
                    </div>
                  </Space>
                </Form.Item>
                {thumb && (
                  <Row style={{ marginBottom: 22 }}>
                    <Col span={3}></Col>
                    <Col span={21}>
                      <img src={thumb} width={279} height={90} />
                    </Col>
                  </Row>
                )}
                <Form.Item label="链接地址" name="url">
                  <Space align="baseline" style={{ height: 32 }}>
                    <Form.Item name="url">
                      <Input
                        style={{ width: 300 }}
                        placeholder="填输入链接地址"
                        allowClear
                      />
                    </Form.Item>
                    <div className="ml-10">
                      <Button
                        type="link"
                        className="c-primary"
                        onClick={() => setShowLinkWin(true)}
                      >
                        选择链接
                      </Button>
                    </div>
                  </Space>
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
          <PCLink
            defautValue={null}
            open={showLinkWin}
            onClose={() => setShowLinkWin(false)}
            onChange={(value: any) => {
              if (value) {
                form.setFieldsValue({ url: value });
              }
              setShowLinkWin(false);
            }}
          ></PCLink>
        </div>
      )}
    </>
  );
};
