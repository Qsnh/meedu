import React, { useState, useEffect } from "react";
import { Modal, Form, Input, Cascader, message, Spin } from "antd";
import styles from "./update.module.less";
import { videoCategory } from "../../../../api/index";

interface PropInterface {
  cid: number;
  ids: number[];
  open: boolean;
  onCancel: () => void;
}

interface Option {
  value: string | number;
  label: string;
  children?: Option[];
}

export const VideoCategoryUpdate: React.FC<PropInterface> = ({
  cid,
  ids,
  open,
  onCancel,
}) => {
  const [form] = Form.useForm();
  const [init, setInit] = useState(true);
  const [loading, setLoading] = useState(false);
  const [categories, setCategories] = useState<any>([]);
  const [parent_id, setParentId] = useState<number>(0);

  useEffect(() => {
    setInit(true);
    if (open) {
      setParentId(0);
      getParams();
    }
  }, [open]);

  const getParams = () => {
    videoCategory.create().then((res: any) => {
      const categories = res.data.categories;
      if (JSON.stringify(categories) !== "{}" && categories.length !== 0) {
        const new_arr: Option[] = checkArr(categories, 0);
        setCategories(new_arr);
      }
      if (ids.length === 0) {
        return;
      }
      getDetail();
    });
  };

  const getDetail = () => {
    form.setFieldsValue({
      category_id: cid > 0 ? cid : [],
    });
    setParentId(cid > 0 ? cid : 0);
    setInit(false);
  };

  const checkArr = (categories: any[], id: number) => {
    const arr = [];
    for (let i = 0; i < categories[id].length; i++) {
      if (!categories[categories[id][i].id]) {
        arr.push({
          label: categories[id][i].name,
          value: categories[id][i].id,
        });
      } else {
        const new_arr: Option[] = checkArr(categories, categories[id][i].id);
        arr.push({
          label: categories[id][i].name,
          value: categories[id][i].id,
          children: new_arr,
        });
      }
    }
    return arr;
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    videoCategory
      .videoUpdate({ ids: ids, category_id: parent_id || 0 })
      .then((res: any) => {
        setLoading(false);
        message.success("成功");
        onCancel();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const handleChange = (value: any) => {
    if (value !== undefined) {
      let it = value[value.length - 1];
      setParentId(it);
    } else {
      setParentId(0);
    }
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  return (
    <>
      {open ? (
        <Modal
          title="编辑视频所属分类"
          centered
          forceRender
          open={true}
          width={416}
          onOk={() => form.submit()}
          onCancel={() => onCancel()}
          maskClosable={false}
          okButtonProps={{ loading: loading }}
        >
          {init && (
            <div className="float-left text-center mt-30">
              <Spin></Spin>
            </div>
          )}
          {!init && (
            <div className="float-left mt-24">
              <Form
                form={form}
                name="basic"
                labelCol={{ span: 8 }}
                wrapperCol={{ span: 16 }}
                initialValues={{ remember: true }}
                onFinish={onFinish}
                onFinishFailed={onFinishFailed}
                autoComplete="off"
              >
                <Form.Item
                  label="分类"
                  name="category_id"
                  rules={[{ required: true, message: "请选择分类!" }]}
                >
                  <Cascader
                    style={{ width: 200 }}
                    allowClear
                    placeholder="请选择分类"
                    onChange={handleChange}
                    options={categories}
                    changeOnSelect
                    expand-trigger="hover"
                  />
                </Form.Item>
              </Form>
            </div>
          )}
        </Modal>
      ) : null}
    </>
  );
};
