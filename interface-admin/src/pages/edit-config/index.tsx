import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Spin, Form, Input, message, Button, Dropdown } from "antd";
import { useNavigate } from "react-router-dom";
import type { MenuProps } from "antd";
import { DownOutlined } from "@ant-design/icons";
import {
  getPreToken,
  setToken,
  clearPreToken,
  wechatUrlRules,
} from "../../utils/index";
import { useDispatch } from "react-redux";
import { login as loginApi, system, pre } from "../../api/index";
import { loginAction } from "../../store/user/loginUserSlice";
import { setEnabledAddonsAction } from "../../store/enabledAddons/enabledAddonsConfigSlice";
import {
  saveConfigAction,
  SystemConfigStoreInterface,
} from "../../store/system/systemConfigSlice";
import logo from "../../assets/home/logo.png";

const EditConfigPage = () => {
  document.title = "系统配置";
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [form] = Form.useForm();
  const [loading, setLoading] = useState<boolean>(true);
  const [config, setConfig] = useState<any>({});
  const [thumb, setThumb] = useState<any>({});

  useEffect(() => {
    getDetail();
  }, []);

  const getDetail = () => {
    setConfig({});
    pre
      .setting()
      .then((res: any) => {
        let configData = res.data;
        // 数据修饰下
        for (let index in configData) {
          for (let index2 in configData[index]) {
            let item = configData[index][index2];
            let params: any = {};
            if (item.field_type === "image") {
              let box: any = thumb;
              box[item.key] = item.value;
              setThumb(box);
            }
            if (item.field_type === "switch") {
              params[item.key] = Number(item.value);
              form.setFieldsValue(params);
            } else {
              params[item.key] = item.value;
              form.setFieldsValue(params);
            }
            if (item.field_type === "select") {
              let box = [];
              for (let i = 0; i < item.option_value.length; i++) {
                configData[index][index2].option_value[i].key += "";
                box.push({
                  label: configData[index][index2].option_value[i].title,
                  value: configData[index][index2].option_value[i].key,
                });
              }
              item.option_value = box;
            }
          }
        }
        setConfig(configData);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }

    if (wechatUrlRules(values["app.url"])) {
      message.error("API访问地址必须携带http://或https://协议");
      return;
    }
    if (wechatUrlRules(values["meedu.system.pc_url"])) {
      message.error("PC访问地址必须携带http://或https://协议");
      return;
    }
    if (wechatUrlRules(values["meedu.system.h5_url"])) {
      message.error("H5访问地址必须携带http://或https://协议");
      return;
    }
    setLoading(true);
    pre
      .saveSetting({
        config: values,
      })
      .then((res: any) => {
        message.success("成功！");
        let token = getPreToken();
        setToken(token);
        clearPreToken();
        handleSubmit();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const handleSubmit = async () => {
    await getSystemConfig(); //获取系统配置并写入store
    await getUser(); //获取登录用户的信息并写入store
    await getAddons(); //获取权限
    setLoading(false);
    navigate("/", { replace: true });
  };

  const getUser = async () => {
    let res: any = await loginApi.getUser();
    dispatch(loginAction(res.data));
  };

  const getAddons = async () => {
    let addonsRes: any = await system.addonsList();
    let enabledAddons: any = {};
    let count = 0;
    for (let i = 0; i < addonsRes.data.length; i++) {
      if (addonsRes.data[i].enabled) {
        count += 1;
        enabledAddons[addonsRes.data[i].sign] = 1;
      }
    }
    dispatch(setEnabledAddonsAction({ addons: enabledAddons, count: count }));
  };

  const getSystemConfig = async () => {
    let res: any = await system.getSystemConfig();
    let config: SystemConfigStoreInterface = {
      system: {
        logo: res.data.system.logo,
        url: {
          api: res.data.system.url.api,
          h5: res.data.system.url.h5,
          pc: res.data.system.url.pc,
        },
      },
      video: {
        default_service: res.data.video.default_service,
      },
    };
    dispatch(saveConfigAction(config));
  };

  const items: MenuProps["items"] = [
    {
      label: "安全退出",
      key: "login_out",
    },
  ];

  const onClick: MenuProps["onClick"] = ({ key }) => {
    if (key === "login_out") {
      message.success("安全退出成功");
      clearPreToken();
      navigate("/login", { replace: true });
    }
  };

  return (
    <div className={styles["layout-wrap"]}>
      <div className={styles["right-cont"]}>
        <div className={styles["right-top"]}>
          <div className={styles["app-header"]}>
            <div className={styles["main-header"]}>
              <img src={logo} className={styles["App-logo"]} />
              <div className={styles["page-name"]}>系统配置</div>
              <div className={styles["device-bar"]}>
                <Button.Group className={styles["user-info"]}>
                  <Dropdown menu={{ items, onClick }} placement="bottomRight">
                    <div className="d-flex">
                      <span className={styles["name"]}>系统管理员</span>
                      <DownOutlined
                        style={{
                          fontSize: 12,
                          marginLeft: 5,
                          color: "#606266",
                        }}
                      />
                    </div>
                  </Dropdown>
                </Button.Group>
              </div>
            </div>
          </div>
        </div>
        <div className={styles["right-main"]}>
          <div className="meedu-main-body">
            <div className="float-left c-red">请配置访问地址</div>
            {loading && (
              <div
                style={{
                  width: "100%",
                  textAlign: "center",
                  paddingTop: 50,
                  paddingBottom: 30,
                  boxSizing: "border-box",
                }}
              >
                <Spin />
              </div>
            )}
            {!loading && (
              <div className="float-left mt-30">
                <Form
                  form={form}
                  name="system-normal-config"
                  labelCol={{ span: 4 }}
                  wrapperCol={{ span: 20 }}
                  initialValues={{ remember: true }}
                  onFinish={onFinish}
                  onFinishFailed={onFinishFailed}
                  autoComplete="off"
                >
                  {config["系统"] &&
                    config["系统"].map((c: any) => (
                      <div key={c.id}>
                        {(c.name === "API访问地址" ||
                          c.name === "PC访问地址" ||
                          c.name === "H5访问地址") && (
                          <>
                            <Form.Item
                              label={c.name}
                              name={c.key}
                              rules={[
                                { required: true, message: "请输入访问地址!" },
                              ]}
                            >
                              <Form.Item name={c.key}>
                                <Input style={{ width: 300 }} allowClear />
                              </Form.Item>
                              {c.help && (
                                <div className="form-helper-text">
                                  <span>{c.help}</span>
                                </div>
                              )}
                            </Form.Item>
                          </>
                        )}
                      </div>
                    ))}
                </Form>
              </div>
            )}
            <div className="bottom-menus">
              <div className="bottom-menus-box" style={{ left: 20, right: 20 }}>
                <div>
                  <Button
                    loading={loading}
                    type="primary"
                    onClick={() => form.submit()}
                  >
                    保存
                  </Button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default EditConfigPage;
