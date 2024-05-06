import { useEffect, useState } from "react";
import { Modal, Form, Input, message, Select, Space, Spin } from "antd";
import { course } from "../../../api/index";
import { HelperText } from "../../../components";

interface PropsInterface {
  open: boolean;
  id: number;
  categories: any[];
  onCancel: () => void;
  onSuccess: () => void;
}

export const CourseCategoryUpdateDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const [init, setInit] = useState<boolean>(true);
  const [loading, setLoading] = useState<boolean>(false);
  const [localCategories, setLocalCategories] = useState<any>([]);

  useEffect(() => {
    if (props.open) {
      setInit(true);
      form.setFieldsValue({
        name: "",
        sort: "",
        parent_id: 0,
      });
    }
    if (props.id > 0) {
      initData();
    }
  }, [props.open, props.id]);

  useEffect(() => {
    let box: any = [
      {
        value: 0,
        label: "无-作为一级分类",
      },
    ];
    for (let i = 0; i < props.categories.length; i++) {
      box.push({
        label: props.categories[i].name,
        value: props.categories[i].id,
        disabled: props.categories[i].id === props.id,
      });
    }
    setLocalCategories(box);
  }, [props.categories, props.id]);

  const initData = async () => {
    await getDetail();
    setInit(false);
  };

  const getDetail = async () => {
    const res: any = await course.categoryDetail(props.id);
    form.setFieldsValue({
      name: res.data.name,
      sort: res.data.sort,
      parent_id: res.data.parent_id,
    });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    course
      .categoryUpdate(props.id, values)
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
          title="编辑分类"
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
              name="learnPath-update-dailog"
              labelCol={{ span: 3 }}
              wrapperCol={{ span: 21 }}
              initialValues={{ remember: true }}
              onFinish={onFinish}
              onFinishFailed={onFinishFailed}
              autoComplete="off"
            >
              <Form.Item
                label="父级分类"
                name="parent_id"
                rules={[{ required: true, message: "请选择父级分类!" }]}
              >
                <Select
                  style={{ width: 300 }}
                  placeholder="请选择父级分类"
                  allowClear
                  options={localCategories}
                />
              </Form.Item>
              <Form.Item
                label="分类名称"
                name="name"
                rules={[{ required: true, message: "请输入分类名称!" }]}
              >
                <Input
                  style={{ width: 300 }}
                  placeholder="请输入分类名称"
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
