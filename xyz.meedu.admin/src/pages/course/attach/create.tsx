import { useEffect, useState, useRef } from "react";
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
  const [key, setKey] = useState("");
  const [cid, setCid] = useState(Number(result.get("course_id")));
  const [fileName, setFileName] = useState<string>("");
  const [file, setFile] = useState<any>(null);
  const percentComplete = useRef(0);
  const [, forceUpdate] = useState({});

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
    if (!key) {
      message.error("请先上传附件！");
      return;
    }
    setLoading(true);
    course
      .attachStore({
        key: key,
        name: values.name,
        course_id: String(cid),
      })
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
      "image/gif,image/jpeg,image/jpg,image/png,.csv,.txt,.pdf,.md,.ppt,.pptx,.doc,.docx,.zip,.rar",
    beforeUpload: (file: any) => {
      if (loading) {
        return;
      }

      const f = file;
      let fileName = f.name;
      let lastName = fileName
        .substring(fileName.lastIndexOf("."))
        .toLowerCase();
      setLoading(true);
      course
        .attachUploadSign({ extension: lastName.substr(1) })
        .then((res: any) => {
          let key = res.data.key;
          let url = res.data.upload_url;
          const xhr = new XMLHttpRequest();
          xhr.open("PUT", url, true);
          xhr.setRequestHeader("Content-Type", f.type);
          xhr.upload.onprogress = (event) => {
            if (event.lengthComputable) {
              percentComplete.current = (event.loaded / event.total) * 100;
              forceUpdate({}); // 强制重新渲染
            }
          };
          xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
              if (xhr.status === 200) {
                percentComplete.current = 0;
                forceUpdate({}); // 强制重新渲染
                setLoading(false);
                message.success("上传成功");
                setKey(key);
                setFileName(f.name);
                form.setFieldsValue({
                  name: f.name,
                });
              } else {
                setKey("");
                setFileName("");
                form.setFieldsValue({
                  name: "",
                });
                percentComplete.current = 0;
                forceUpdate({}); // 强制重新渲染
                setLoading(false);
                message.error("上传失败");
                console.error("File upload failed:", xhr.statusText);
              }
            }
          };
          xhr.send(f);
        })
        .catch((e) => {
          setKey("");
          setFileName("");
          form.setFieldsValue({
            name: "",
          });
          percentComplete.current = 0;
          forceUpdate({}); // 强制重新渲染
          setLoading(false);
          message.error(e.message);
        });
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
                <Upload
                  {...uploadProps}
                  showUploadList={false}
                  disabled={loading}
                >
                  <Button loading={loading} type="primary">
                    {loading
                      ? `${percentComplete.current.toFixed(2)}%`
                      : "上传附件"}
                  </Button>
                  {fileName && <span className="ml-10">{fileName}</span>}
                </Upload>
              </Form.Item>
              <div className="ml-10">
                <HelperText text="支持pdf,jpeg,jpg,gif,png,md,txt,csv,ppt,pptx,doc,docx,zip,rar格式文件"></HelperText>
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
