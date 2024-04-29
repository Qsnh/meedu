import { useEffect, useState } from "react";
import { Modal, Form, Input, message, Button, Select, Space } from "antd";
import { useNavigate } from "react-router-dom";
import { member } from "../../../api/index";
import { QuillEditor } from "../../../components";

interface PropsInterface {
  open: boolean;
  id: number;
  onCancel: () => void;
  onSuccess: () => void;
}

export const RemarkDialog = (props: PropsInterface) => {
  const [form] = Form.useForm();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);
  const [defautValue, setDefautValue] = useState("");

  useEffect(() => {
    if (props.id && props.open) {
      form.setFieldsValue({
        remark: "",
      });
      getUser();
    }
  }, [props.open, props.id]);

  const getUser = () => {
    member.edit(props.id).then((res: any) => {
      form.setFieldsValue({
        remark: res.data.remark ? res.data.remark.remark : "",
      });
      setDefautValue(res.data.remark ? res.data.remark.remark : "");
    });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    member
      .remarkUpdate(props.id, values)
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
          title="修改备注"
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
              name="remark-dailog"
              labelCol={{ span: 3 }}
              wrapperCol={{ span: 21 }}
              initialValues={{ remember: true }}
              onFinish={onFinish}
              onFinishFailed={onFinishFailed}
              autoComplete="off"
            >
              <Form.Item label="学员备注" name="remark" style={{ height: 240 }}>
                <QuillEditor
                  mode="remark"
                  height={200}
                  defautValue={defautValue}
                  isFormula={false}
                  setContent={(value: string) => {
                    form.setFieldsValue({ remark: value });
                  }}
                ></QuillEditor>
              </Form.Item>
            </Form>
          </div>
        </Modal>
      ) : null}
    </>
  );
};
