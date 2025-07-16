import { useState, useEffect } from "react";
import { Form, Input, message, Select, Switch, DatePicker, Button } from "antd";
import { useNavigate } from "react-router-dom";
import { agreement } from "../../api/index";
import { BackBartment } from "../../components";
import { useDispatch } from "react-redux";
import { titleAction } from "../../store/user/loginUserSlice";
import dayjs from "dayjs";

const { TextArea } = Input;

const AgreementCreatePage = () => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);
  const [types, setTypes] = useState<any>({});
  const [isActive, setIsActive] = useState<boolean>(false);
  const navigate = useNavigate();
  const dispatch = useDispatch();

  useEffect(() => {
    document.title = "新增协议";
    dispatch(titleAction("新增协议"));
    getFormData();
  }, []);

  const getFormData = () => {
    agreement.createForm().then((res: any) => {
      setTypes(res.data.types);
    });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    
    const params = {
      ...values,
      effective_at: values.effective_at ? values.effective_at.format("YYYY-MM-DD HH:mm:ss") : null,
    };

    agreement
      .store(params)
      .then((res: any) => {
        setLoading(false);
        message.success("保存成功！");
        navigate("/agreement/index");
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const handleIsActiveChange = (checked: boolean) => {
    setIsActive(checked);
    if (!checked) {
      form.setFieldsValue({ effective_at: null });
    }
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="新增协议" />
      <div className="float-left mt-30">
        <Form
          form={form}
          name="agreement-create"
          labelCol={{ span: 3 }}
          wrapperCol={{ span: 21 }}
          initialValues={{ is_active: false }}
          onFinish={onFinish}
          autoComplete="off"
        >
          <Form.Item
            label="协议类型"
            name="type"
            rules={[{ required: true, message: "请选择协议类型!" }]}
          >
            <Select placeholder="请选择协议类型" style={{ width: 300 }}>
              {Object.keys(types).map((key) => (
                <Select.Option key={key} value={key}>
                  {types[key]}
                </Select.Option>
              ))}
            </Select>
          </Form.Item>

          <Form.Item
            label="协议标题"
            name="title"
            rules={[{ required: true, message: "请输入协议标题!" }]}
          >
            <Input placeholder="请输入协议标题" style={{ width: 300 }} />
          </Form.Item>

          <Form.Item
            label="版本号"
            name="version"
            rules={[{ required: true, message: "请输入版本号!" }]}
          >
            <Input placeholder="请输入版本号" style={{ width: 300 }} />
          </Form.Item>

          <Form.Item
            label="是否生效"
            name="is_active"
            valuePropName="checked"
          >
            <Switch onChange={handleIsActiveChange} />
          </Form.Item>

          {isActive && (
            <Form.Item
              label="生效时间"
              name="effective_at"
              rules={[{ required: true, message: "请选择生效时间!" }]}
            >
              <DatePicker showTime placeholder="请选择生效时间" style={{ width: 300 }} />
            </Form.Item>
          )}

          <Form.Item
            label="协议内容"
            name="content"
            rules={[{ required: true, message: "请输入协议内容!" }]}
          >
            <TextArea 
              placeholder="请输入协议内容" 
              rows={15}
              style={{ width: 600 }}
            />
          </Form.Item>

          <Form.Item wrapperCol={{ offset: 3, span: 21 }}>
            <Button type="primary" htmlType="submit" loading={loading}>
              保存
            </Button>
            <Button 
              style={{ marginLeft: 10 }} 
              onClick={() => navigate("/agreement/index")}
            >
              取消
            </Button>
          </Form.Item>
        </Form>
      </div>
    </div>
  );
};

export default AgreementCreatePage; 