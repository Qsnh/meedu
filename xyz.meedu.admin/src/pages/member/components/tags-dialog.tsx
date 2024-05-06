import { useEffect, useState } from "react";
import { Modal, Form, Input, message, Button, Select, Space } from "antd";
import { useNavigate } from "react-router-dom";
import { member } from "../../../api/index";
import { HelperText } from "../../../components";

interface PropsInterface {
  open: boolean;
  id: number;
  tags: any[];
  onCancel: () => void;
  onSuccess: () => void;
}

export const TagsDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    if (props.id && props.open) {
      form.setFieldsValue({
        tag_ids: [],
      });
      getUser();
    }
  }, [props.open, props.id]);

  const getUser = () => {
    member.edit(props.id).then((res: any) => {
      let data = [];
      if (res.data.tags) {
        for (let i = 0; i < res.data.tags.length; i++) {
          data.push(res.data.tags[i].id);
        }
      }
      form.setFieldsValue({
        tag_ids: data,
      });
    });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    member
      .tagRecharge(props.id, {
        tag_ids: values.tag_ids.join(","),
      })
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
          title="修改标签"
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
              name="tags-dailog"
              labelCol={{ span: 3 }}
              wrapperCol={{ span: 21 }}
              initialValues={{ remember: true }}
              onFinish={onFinish}
              onFinishFailed={onFinishFailed}
              autoComplete="off"
            >
              <Form.Item label="学员标签" name="tag_ids">
                <Space align="baseline" style={{ height: 32 }}>
                  <Form.Item name="tag_ids">
                    <Select
                      style={{ width: 300 }}
                      mode="multiple"
                      allowClear
                      placeholder="请选择学员标签"
                      options={props.tags}
                    />
                  </Form.Item>
                  <div>
                    <Button
                      type="link"
                      className="c-primary"
                      onClick={() => navigate("/member/tag/index")}
                    >
                      标签管理
                    </Button>
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
