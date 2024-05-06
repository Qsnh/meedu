import { useEffect, useState } from "react";
import { Modal, Form, Input, message, Space, Spin } from "antd";
import { course } from "../../../api/index";
import { HelperText } from "../../../components";

interface PropsInterface {
  open: boolean;
  id: number;
  cid: number;
  onCancel: () => void;
  onSuccess: () => void;
}

export const CourseChapterUpdateDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [init, setInit] = useState<boolean>(true);
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    if (props.open) {
      setInit(true);
      form.setFieldsValue({
        title: "",
        sort: "",
      });
    }
    if (props.id > 0 && props.cid) {
      initData();
    }
  }, [props.open, props.cid, props.id]);

  const initData = async () => {
    await getDetail();
    setInit(false);
  };

  const getDetail = async () => {
    const res: any = await course.chaptersDetail(props.cid, props.id);
    form.setFieldsValue({
      title: res.data.title,
      sort: res.data.sort,
    });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    course
      .chaptersUpdate(props.cid, props.id, values)
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
          title="编辑章节"
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
          {init && (
            <div className="float-left text-center mt-30">
              <Spin></Spin>
            </div>
          )}
          <div
            style={{ display: init ? "none" : "block" }}
            className="float-left mt-30"
          >
            <Form
              form={form}
              name="course-chapter-update-dailog"
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
