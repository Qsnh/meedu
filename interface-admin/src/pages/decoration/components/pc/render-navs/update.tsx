import React, { useState, useEffect } from "react";
import { Form, Select, Input, Button, Space, message, Switch } from "antd";
import { system } from "../../../../../api";
import { HelperText, PCLink } from "../../../../../components";

interface PropInterface {
  id: number;
  open: boolean;
  onClose: () => void;
}

export const NavsUpdate: React.FC<PropInterface> = ({ id, open, onClose }) => {
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(false);
  const [navs, setNavs] = useState<any>([]);
  const [linkStatus, setLinkStatus] = useState<boolean>(false);
  const [showLinkWin, setShowLinkWin] = useState<boolean>(false);
  const [value, setValue] = useState<any>(null);

  useEffect(() => {
    if (open) {
      getParams();
    }
  }, [open]);

  useEffect(() => {
    if (id) {
      getDetail();
    }
  }, [id]);

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

  const getDetail = () => {
    if (id === 0) {
      return;
    }
    system.navsDetail(id).then((res: any) => {
      let data = res.data;
      if (data.parent_id === 0) {
        form.setFieldsValue({
          parent_id: [],
        });
      } else {
        form.setFieldsValue({
          parent_id: data.parent_id,
        });
      }
      form.setFieldsValue({
        sort: data.sort,
        name: data.name,
        url: data.url,
        blank: data.blank,
      });

      if (data.url.match("https://") || data.url.match("http://")) {
        setValue(null);
        setLinkStatus(true);
      } else {
        setValue(data.url);
        setLinkStatus(false);
      }
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
      .navsUpdate(id, values)
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
            <div className="meedu-dialog-header">编辑导航</div>
            <div className="meedu-dialog-body">
              <Form
                form={form}
                name="navs-update"
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
            defautValue={value}
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
