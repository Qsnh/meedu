import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Button, Input, message, Form, TreeSelect } from "antd";
import { adminRole } from "../../../api/index";
import { useDispatch } from "react-redux";
import { titleAction } from "../../../store/user/loginUserSlice";
import { BackBartment } from "../../../components";

const SystemAdminrolesCreatePage = () => {
  const [form] = Form.useForm();
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);
  const [permissionsTransform, setPermissionsTransform] = useState<any>([]);
  const [selectedValues, setSelectedValues] = useState([]);

  useEffect(() => {
    document.title = "新建管理员角色";
    dispatch(titleAction("新建管理员角色"));
    params();
  }, []);

  const params = () => {
    adminRole.createAdminRole().then((res: any) => {
      const arr = [];
      let roles = res.data.permissions;
      for (let i in roles) {
        let children = [];
        let ids = [];
        for (let j = 0; j < roles[i].length; j++) {
          ids.push(roles[i][j].id);
          children.push({
            value: roles[i][j].id,
            title: roles[i][j].display_name,
          });
        }

        arr.push({
          value: i,
          title: i,
          children: children,
        });
      }
      setPermissionsTransform(arr);
    });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    adminRole
      .storeAdminRole({
        display_name: values.display_name,
        description: values.description,
        permission_ids: selectedValues,
      })
      .then((res: any) => {
        setLoading(false);
        message.success("保存成功！");
        navigate(-1);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const handleChange = (value: any) => {
    setSelectedValues(value);
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="新建管理员角色" />
      <div className="float-left mt-30">
        <Form
          form={form}
          name="administrator-create"
          labelCol={{ span: 3 }}
          wrapperCol={{ span: 21 }}
          initialValues={{ remember: true }}
          onFinish={onFinish}
          onFinishFailed={onFinishFailed}
          autoComplete="off"
        >
          <Form.Item
            label="角色名"
            name="display_name"
            rules={[{ required: true, message: "请输入角色名!" }]}
          >
            <Input
              style={{ width: 300 }}
              placeholder="请输入角色名"
              allowClear
            />
          </Form.Item>
          <Form.Item
            label="描述"
            name="description"
            rules={[{ required: true, message: "请输入描述!" }]}
          >
            <Input style={{ width: 300 }} placeholder="请输入描述" allowClear />
          </Form.Item>
          <Form.Item label="权限" name="permission_ids">
            <TreeSelect
              style={{ width: "100%" }}
              placeholder="请选择权限"
              multiple
              allowClear
              treeCheckable
              treeData={permissionsTransform}
              onChange={handleChange}
              showCheckedStrategy={TreeSelect.SHOW_CHILD}
              maxTagCount="responsive"
              treeDefaultExpandAll
            />
          </Form.Item>
        </Form>
      </div>
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
  );
};

export default SystemAdminrolesCreatePage;
