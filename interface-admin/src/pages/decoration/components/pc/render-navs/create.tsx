import React, { useState, useEffect } from "react";
import { Form, Select, Input, Button, Space, message, Switch } from "antd";
import { system } from "../../../../../api";
import { HelperText, PCLink } from "../../../../../components";

interface PropInterface {
  open: boolean;
  onClose: () => void;
}

export const NavsCreate: React.FC<PropInterface> = ({ open, onClose }) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);
  const [navs, setNavs] = useState<any>([]);
  const [linkStatus, setLinkStatus] = useState<boolean>(false);
  const [showLinkWin, setShowLinkWin] = useState<boolean>(false);

  useEffect(() => {
    if (open) {
      form.setFieldsValue({
        parent_id: [],
        sort: "",
        name: "",
        url: "",
        blank: 0,
      });
      getParams();
    }
  }, [open]);

  const getParams = () => {
    system.navsCreate().then((res: any) => {
      let box = [];
      for (let i = 0; i < res.data.navs.length; i++) {
        box.push({
          label: res.data.navs[i].name,
          value: res.data.navs[i].id,
        });
      }
      setNavs(box);
    });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    values.platform = "PC";
    if (!values.parent_id) {
      values.parent_id = null;
    }
    if (!values.blank) {
      values.blank = 0;
    }
    setLoading(true);
    system
      .navsStore(values)
      .then((res: any) => {
        setLoading(false);
        message.success("成功！");
        onClose();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const onSwitch = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ blank: 1 });
    } else {
      form.setFieldsValue({ blank: 0 });
    }
  };

  return (
    <>
      {open && (
        <div className="meedu-dialog-mask">
          <div className="meedu-dialog-box">
            <div className="meedu-dialog-header">添加导航</div>
            <div className="meedu-dialog-body">
              <Form
                form={form}
                name="navs-create"
                labelCol={{ span: 3 }}
                wrapperCol={{ span: 21 }}
                initialValues={{ remember: true }}
                onFinish={onFinish}
                onFinishFailed={onFinishFailed}
                autoComplete="off"
              >
                <Form.Item label="父导航" name="parent_id">
                  <Select
                    style={{ width: 300 }}
                    placeholder="请选择"
                    allowClear
                    options={navs}
                  />
                </Form.Item>
                <Form.Item
                  label="排序值"
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
                <Form.Item
                  label="导航名"
                  name="name"
                  rules={[{ required: true, message: "请输入导航名!" }]}
                >
                  <Input
                    style={{ width: 300 }}
                    placeholder="请输入导航名"
                    allowClear
                  />
                </Form.Item>
                <Form.Item
                  label="链接地址"
                  name="url"
                  rules={[{ required: true, message: "填输入链接地址!" }]}
                >
                  <Space align="baseline" style={{ height: 32 }}>
                    <Form.Item
                      name="url"
                      rules={[{ required: true, message: "填输入链接地址!" }]}
                    >
                      <Input
                        style={{ width: 300 }}
                        placeholder="填输入链接地址"
                        allowClear
                        onChange={(e) => {
                          if (
                            e.target.value.match("https://") ||
                            e.target.value.match("http://")
                          ) {
                            setLinkStatus(true);
                          } else {
                            setLinkStatus(false);
                          }
                        }}
                      />
                    </Form.Item>
                    <div className="ml-10">
                      <Button
                        type="link"
                        className="c-primary"
                        onClick={() => setShowLinkWin(true)}
                      >
                        选择链接
                      </Button>
                    </div>
                  </Space>
                </Form.Item>
                {linkStatus && (
                  <Form.Item
                    label="新窗口打开"
                    name="blank"
                    valuePropName="checked"
                  >
                    <Switch onChange={onSwitch} />
                  </Form.Item>
                )}
              </Form>
            </div>
            <div className="meedu-dialog-footer">
              <Button
                loading={loading}
                type="primary"
                onClick={() => form.submit()}
              >
                确定
              </Button>
              <Button className="ml-10" onClick={() => onClose()}>
                取消
              </Button>
            </div>
          </div>
          <PCLink
            defautValue={null}
            open={showLinkWin}
            onClose={() => setShowLinkWin(false)}
            onChange={(value: any) => {
              if (value) {
                form.setFieldsValue({ url: value });
              }
              setShowLinkWin(false);
            }}
          ></PCLink>
        </div>
      )}
    </>
  );
};
