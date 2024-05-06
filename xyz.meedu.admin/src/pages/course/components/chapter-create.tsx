import { useEffect, useState } from "react";
import { Modal, Form, Input, message, Space } from "antd";
import { course } from "../../../api/index";
import { HelperText } from "../../../components";

interface PropsInterface {
  open: boolean;
  cid: number;
  onCancel: () => void;
  onSuccess: () => void;
}

export const CourseChapterCreateDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    if (props.open) {
      form.setFieldsValue({
        title: "",
        sort: "",
      });
    }
  }, [props.open, props.cid]);

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    course
      .chaptersStore(props.cid, values)
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
          title="添加章节"
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
              name="course-chapter-create-dailog"
              labelCol={{ span: 3 }}
              wrapperCol={{ span: 21 }}
              initialValues={{ remember: true }}
              onFinish={onFinish}
              onFinishFailed={onFinishFailed}
              autoComplete="off"
            >
              <Form.Item
                label="章节名称"
                name="title"
                rules={[{ required: true, message: "请输入章节名称!" }]}
              >
                <Input
                  style={{ width: 300 }}
                  placeholder="请输入章节名称"
                  allowClear
                />
              </Form.Item>
              <Form.Item
                label="排序"
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
            </Form>
          </div>
        </Modal>
      ) : null}
    </>
  );
};
