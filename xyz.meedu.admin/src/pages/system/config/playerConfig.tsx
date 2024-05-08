import { useState, useEffect } from "react";
import {
  Spin,
  Form,
  Input,
  message,
  Button,
  Row,
  Col,
  Space,
  Switch,
  Slider,
} from "antd";
import { useNavigate, useLocation } from "react-router-dom";
import { useDispatch } from "react-redux";
import { titleAction } from "../../../store/user/loginUserSlice";
import { system } from "../../../api/index";
import {
  UploadImageButton,
  BackBartment,
  HelperText,
} from "../../../components";

const SystemPlayerConfigPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [form] = Form.useForm();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState<boolean>(true);
  const [thumb, setThumb] = useState<string>("");

  useEffect(() => {
    document.title = "播放器配置";
    dispatch(titleAction("播放器配置"));
    getDetail();
  }, []);

  const getDetail = () => {
    system
      .setting()
      .then((res: any) => {
        let configData = res.data["播放器配置"];
        for (let index in configData) {
          if (configData[index].key === "meedu.system.player_thumb") {
            form.setFieldsValue({
              "meedu.system.player_thumb": configData[index].value,
            });
            setThumb(configData[index].value);
          } else if (
            configData[index].key ===
            "meedu.system.player.enabled_bullet_secret"
          ) {
            form.setFieldsValue({
              "meedu.system.player.enabled_bullet_secret": Number(
                configData[index].value
              ),
            });
          } else if (
            configData[index].key === "meedu.system.player.bullet_secret.text"
          ) {
            form.setFieldsValue({
              "meedu.system.player.bullet_secret.text": configData[index].value,
            });
          } else if (
            configData[index].key === "meedu.system.player.bullet_secret.size"
          ) {
            form.setFieldsValue({
              "meedu.system.player.bullet_secret.size": configData[index].value,
            });
          } else if (
            configData[index].key === "meedu.system.player.bullet_secret.color"
          ) {
            form.setFieldsValue({
              "meedu.system.player.bullet_secret.color":
                configData[index].value,
            });
          } else if (
            configData[index].key ===
            "meedu.system.player.bullet_secret.opacity"
          ) {
            let value = 0;
            if (configData[index].value !== "") {
              value = Number(configData[index].value) * 100;
            }
            form.setFieldsValue({
              "meedu.system.player.bullet_secret.opacity": value,
            });
          }
        }
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    values["meedu.system.player.bullet_secret.opacity"] = String(
      values["meedu.system.player.bullet_secret.opacity"] / 100
    );
    setLoading(true);
    system
      .saveSetting({
        config: values,
      })
      .then((res: any) => {
        setLoading(false);
        message.success("成功！");
        if (result.get("referer")) {
          navigate(String(result.get("referer")), { replace: true });
        } else {
          navigate(-1);
        }
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  const isChange = (checked: boolean) => {
    if (checked) {
      form.setFieldsValue({ "meedu.system.player.enabled_bullet_secret": 1 });
    } else {
      form.setFieldsValue({ "meedu.system.player.enabled_bullet_secret": 0 });
    }
  };

  const addMobile = () => {
    var value = form.getFieldValue("meedu.system.player.bullet_secret.text");
    value += "${user.mobile}";
    form.setFieldsValue({
      "meedu.system.player.bullet_secret.text": value,
    });
  };

  const addID = () => {
    var value = form.getFieldValue("meedu.system.player.bullet_secret.text");
    value += "${user.id}";
    form.setFieldsValue({
      "meedu.system.player.bullet_secret.text": value,
    });
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="播放器配置"></BackBartment>
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
        <div className="float-left">
          <Form
            form={form}
            name="system-player-config"
            labelCol={{ span: 3 }}
            wrapperCol={{ span: 21 }}
            initialValues={{ remember: true }}
            onFinish={onFinish}
            onFinishFailed={onFinishFailed}
            autoComplete="off"
          >
            <div className="from-title mt-30">播放器封面</div>
            <Form.Item label="播放器封面" name="meedu.system.player_thumb">
              <Space align="baseline" style={{ height: 32 }}>
                <Form.Item name="meedu.system.player_thumb">
                  <UploadImageButton
                    text="上传图片"
                    onSelected={(url) => {
                      form.setFieldsValue({ "meedu.system.player_thumb": url });
                      setThumb(url);
                    }}
                  ></UploadImageButton>
                </Form.Item>
                <div className="ml-10">
                  <Button
                    onClick={() => {
                      form.setFieldsValue({ "meedu.system.player_thumb": "" });
                      setThumb("");
                    }}
                  >
                    清空
                  </Button>
                </div>
                <div className="ml-10">
                  <HelperText text="播放封面是在录播课播放未开始时显示的。推荐尺寸：1920x1080"></HelperText>
                </div>
              </Space>
            </Form.Item>
            {thumb && (
              <Row style={{ marginBottom: 22 }}>
                <Col span={3}></Col>
                <Col span={21}>
                  <div
                    className="contain-thumb-box"
                    style={{
                      backgroundImage: `url(${thumb})`,
                      width: 480,
                      height: 270,
                    }}
                  ></div>
                </Col>
              </Row>
            )}
            <div className="from-title mt-30">跑马灯</div>
            <Form.Item
              label="开关"
              name="meedu.system.player.enabled_bullet_secret"
              valuePropName="checked"
            >
              <Switch onChange={isChange} />
            </Form.Item>
            <Form.Item
              label="内容"
              name="meedu.system.player.bullet_secret.text"
            >
              <Space align="baseline" style={{ height: 32 }}>
                <Form.Item name="meedu.system.player.bullet_secret.text">
                  <Input
                    style={{ width: 300 }}
                    allowClear
                    placeholder="此处填写跑马灯内容"
                  />
                </Form.Item>
                <div className="d-flex ml-10">
                  <span className="helper-text">添加变量：</span>
                  <Button
                    type="link"
                    className="c-primary"
                    onClick={() => addMobile()}
                  >
                    学员手机号
                  </Button>
                  <Button
                    type="link"
                    className="c-primary"
                    onClick={() => addID()}
                  >
                    学员ID
                  </Button>
                </div>
              </Space>
            </Form.Item>
            <Form.Item
              label="文字大小"
              name="meedu.system.player.bullet_secret.size"
            >
              <Input type="number" style={{ width: 200 }} addonAfter="px" />
            </Form.Item>
            <Form.Item
              label="文字颜色"
              name="meedu.system.player.bullet_secret.color"
            >
              <Input type="color" style={{ width: 32, padding: 0 }} />
            </Form.Item>
            <Form.Item
              label="文字透明度"
              name="meedu.system.player.bullet_secret.opacity"
            >
              <Slider style={{ width: 400 }} range defaultValue={[0, 100]} />
            </Form.Item>
          </Form>
        </div>
      )}
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

export default SystemPlayerConfigPage;
