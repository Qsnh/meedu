import { useEffect, useState } from "react";
import { Modal, Space, Form, Input, Upload, Button, message } from "antd";
import { useNavigate, useLocation } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { course } from "../../../api/index";
import { titleAction } from "../../../store/user/loginUserSlice";
import { BackBartment, HelperText } from "../../../components";

const CourseAttachCreatePage = () => {
  const [form] = Form.useForm();
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState<boolean>(false);
  const [cid, setCid] = useState(Number(result.get("course_id")));
  const [fileName, setFileName] = useState<string>("");
  const [file, setFile] = useState<any>(null);

  useEffect(() => {
    document.title = "添加课程附件";
    dispatch(titleAction("添加课程附件"));
  }, []);

  useEffect(() => {
    setCid(Number(result.get("course_id")));
  }, [result.get("course_id")]);

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    const formData = new FormData();
    formData.append("file", file);
    formData.append("name", values.name);
    formData.append("course_id", String(cid));
    course
      .attachStore(formData)
      .then((res: any) => {
        setLoading(false);
        message.success("成功！");
        navigate(-1);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const uploadProps = {
    accept:
      "image/gif,image/jpeg,image/jpg,image/png,.csv,.doc,.txt,.pdf,.md,.zip,",
    beforeUpload: (file: any) => {
      if (loading) {
        return;
      }
      setLoading(true);
      const f = file;
      if (f.size > 10240000) {
        message.error("上传附件大小不能超过10MB");
        setLoading(false);
        return;
      }
      setFileName(f.name);
      form.setFieldsValue({
        name: f.name,
      });
      setFile(f);
      setLoading(false);
      return false;
    },
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="添加课程附件" />
      <div className="float-left mt-30">
        <Form
          form={form}
          name="course-attach-create"
          labelCol={{ span: 3 }}
          wrapperCol={{ span: 21 }}
          initialValues={{ remember: true }}
          onFinish={onFinish}
          onFinishFailed={onFinishFailed}
          autoComplete="off"
        >
          <Form.Item
            label="排序"
            name="file"
            rules={[{ required: true, message: "填上传附件!" }]}
          >
            <Space align="baseline" style={{ height: 32 }}>
              <Form.Item
                name="file"
                rules={[{ required: true, message: "填上传附件!" }]}
              >
                <Upload {...uploadProps} showUploadList={false}>
                  <Button loading={loading} type="primary">
                    上传附件
                  </Button>
                  {fileName && <span className="ml-10">{fileName}</span>}
                </Upload>
              </Form.Item>
              <div className="ml-10">
                <HelperText text="支持zip,pdf,jpeg,jpg,gif,png,md,doc,txt,csv格式文件，上传附件大小不能超过10M"></HelperText>
              </div>
            </Space>
          </Form.Item>
          <Form.Item
            label="附件名"
            name="name"
            rules={[{ required: true, message: "请输入附件名!" }]}
          >
            <Input
              style={{ width: 300 }}
              placeholder="请输入附件名"
              allowClear
            />
          </Form.Item>
        </Form>
        <div className="bottom-menus">
          <div className="bottom-menus-box">
            <div>
              <Button
                loading={loading}
                type="primary"
                onClick={() => form.submit()}
              >
                保存
              </Button>
            </div>
            <div className="ml-24">
              <Button type="default" onClick={() => navigate(-1)}>
                取消
              </Button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CourseAttachCreatePage;
