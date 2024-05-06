import React, { useState, useEffect } from "react";
import { Form, Input, Button, message } from "antd";
import { system } from "../../../../../api";
import { QuillEditor } from "../../../../../components";

interface PropInterface {
  open: boolean;
  id: number;
  onClose: () => void;
}

export const NoticeUpdate: React.FC<PropInterface> = ({
  id,
  open,
  onClose,
}) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);
  const [defautValue, setDefautValue] = useState("");

  useEffect(() => {
    if (open && id) {
      getDetail();
    }
  }, [open, id]);

  const getDetail = () => {
    if (id === 0) {
      return;
    }
    system.announcementDetail(id).then((res: any) => {
      let data = res.data;
      form.setFieldsValue({
        title: data.title,
        announcement: data.announcement,
      });
      setDefautValue(data.announcement);
    });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .announcementUpdate(id, values)
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
            <div className="meedu-dialog-header">编辑公告</div>
            <div className="meedu-dialog-body">
              <Form
                form={form}
                name="notice-update"
                labelCol={{ span: 3 }}
                wrapperCol={{ span: 21 }}
                initialValues={{ remember: true }}
                onFinish={onFinish}
                onFinishFailed={onFinishFailed}
                autoComplete="off"
              >
                <Form.Item
                  label="标题"
                  name="title"
                  rules={[{ required: true, message: "请输入标题!" }]}
                >
                  <Input
                    style={{ width: 300 }}
                    placeholder="请输入标题"
                    allowClear
                  />
                </Form.Item>
                <Form.Item
                  label="内容"
                  name="announcement"
                  rules={[{ required: true, message: "请输入内容!" }]}
                  style={{ height: 440 }}
                >
                  <div className="w-800px">
                    <QuillEditor
                      mode=""
                      height={400}
                      defautValue={defautValue}
                      isFormula={false}
                      setContent={(value: string) => {
                        form.setFieldsValue({ announcement: value });
                      }}
                    ></QuillEditor>
                  </div>
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
