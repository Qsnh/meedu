import { useState, useEffect } from "react";
import { Spin, Form, Input, message, Button, Select } from "antd";
import { useNavigate, useLocation } from "react-router-dom";
import { useDispatch } from "react-redux";
import { titleAction } from "../../../store/user/loginUserSlice";
import { system } from "../../../api/index";
import { BackBartment } from "../../../components";
import {
  saveConfigAction,
  SystemConfigStoreInterface,
} from "../../../store/system/systemConfigSlice";

const SystemVideoSaveConfigPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [form] = Form.useForm();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState<boolean>(true);
  const [selects, setSelects] = useState<any>([]);
  const aliRegions = [
    {
      label: "华东1（杭州）/ 华东2（上海）",
      value: "cn-shanghai",
      host: "vod.cn-shanghai.aliyuncs.com",
    },
    {
      label: "华北2（北京）",
      value: "cn-beijing",
      host: "vod.cn-beijing.aliyuncs.com",
    },
    {
      label: "华北3（张家口）",
      value: "cn-zhangjiakou",
      host: "vod.cn-zhangjiakou.aliyuncs.com",
    },
    {
      label: "华南1（深圳）",
      value: "cn-shenzhen",
      host: "vod.cn-shenzhen.aliyuncs.com",
    },
  ];

  const definition = [
    {
      label: "mp4",
      value: "mp4",
    },
    {
      label: "m3u8",
      value: "m3u8",
    },
  ];

  useEffect(() => {
    document.title = "视频存储";
    dispatch(titleAction("视频存储"));
    getDetail();
  }, []);

  const getDetail = () => {
    system
      .setting()
      .then((res: any) => {
        let configData = res.data["视频"];
        for (let index in configData) {
          if (configData[index].key === "meedu.upload.video.aliyun.region") {
            form.setFieldsValue({
              "meedu.upload.video.aliyun.region": configData[index].value,
            });
          } else if (
            configData[index].key === "meedu.upload.video.aliyun.host"
          ) {
            form.setFieldsValue({
              "meedu.upload.video.aliyun.host": configData[index].value,
            });
          } else if (
            configData[index].key === "meedu.upload.video.aliyun.access_key_id"
          ) {
            form.setFieldsValue({
              "meedu.upload.video.aliyun.access_key_id":
                configData[index].value,
            });
          } else if (
            configData[index].key ===
            "meedu.upload.video.aliyun.access_key_secret"
          ) {
            form.setFieldsValue({
              "meedu.upload.video.aliyun.access_key_secret":
                configData[index].value,
            });
          } else if (configData[index].key === "tencent.vod.app_id") {
            form.setFieldsValue({
              "tencent.vod.app_id": configData[index].value,
            });
          } else if (configData[index].key === "tencent.vod.secret_id") {
            form.setFieldsValue({
              "tencent.vod.secret_id": configData[index].value,
            });
          } else if (configData[index].key === "tencent.vod.secret_key") {
            form.setFieldsValue({
              "tencent.vod.secret_key": configData[index].value,
            });
          } else if (
            configData[index].key === "meedu.system.player.tencent_play_key"
          ) {
            form.setFieldsValue({
              "meedu.system.player.tencent_play_key": configData[index].value,
            });
          } else if (
            configData[index].key === "meedu.upload.video.default_service"
          ) {
            form.setFieldsValue({
              "meedu.upload.video.default_service": configData[index].value,
            });
            let arr: any = [];
            let box = configData[index].option_value;
            box.map((item: any) => {
              arr.push({
                label: item.title,
                value: item.key,
              });
            });
            setSelects(arr);
          }
        }

        let configPlayData = res.data["播放器配置"];
        for (let index in configPlayData) {
          if (
            configPlayData[index].key ===
            "meedu.system.player.video_format_whitelist"
          ) {
            if (
              configPlayData[index].value &&
              configPlayData[index].value.length > 0
            ) {
              let value = lowerCase(configPlayData[index].value);
              form.setFieldsValue({
                "meedu.system.player.video_format_whitelist": value.split(","),
              });
            }
          }
        }
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const lowerCase = (str: any) => {
    let arr = str.split("");
    let newStr = "";
    for (let i = 0; i < arr.length; i++) {
      if (arr[i] >= "A" && arr[i] <= "Z") newStr += arr[i].toLowerCase();
      else newStr += arr[i];
    }
    return newStr;
  };

  const getSystemConfig = () => {
    system.getSystemConfig().then((res: any) => {
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
      navigate(-1);
    });
  };

  const onFinish = (values: any) => {
    if (loading) {
      return;
    }
    if (values["meedu.system.player.video_format_whitelist"]) {
      values["meedu.system.player.video_format_whitelist"] =
        values["meedu.system.player.video_format_whitelist"].join(",");
    }
    let it: any = aliRegions.find(
      (o: any) => o.value === values["meedu.upload.video.aliyun.region"]
    );
    if (it) {
      values["meedu.upload.video.aliyun.host"] = it.host;
    }
    setLoading(true);
    system
      .saveSetting({
        config: values,
      })
      .then((res: any) => {
        setLoading(false);
        message.success("成功！");
        getDetail();
        getSystemConfig();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const onFinishFailed = (errorInfo: any) => {
    console.log("Failed:", errorInfo);
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="视频存储"></BackBartment>
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
            name="system-videoSave-config"
            labelCol={{ span: 3 }}
            wrapperCol={{ span: 21 }}
            initialValues={{ remember: true }}
            onFinish={onFinish}
            onFinishFailed={onFinishFailed}
            autoComplete="off"
          >
            <div className="from-title mt-30">服务商配置</div>
            <Form.Item
              label="视频存储默认服务"
              name="meedu.upload.video.default_service"
            >
              <Select style={{ width: 300 }} allowClear options={selects} />
            </Form.Item>
            <div className="from-title mt-30">阿里云视频</div>
            <Form.Item
              label="阿里云视频Region"
              name="meedu.upload.video.aliyun.region"
            >
              <Select style={{ width: 300 }} allowClear options={aliRegions} />
            </Form.Item>
            <Form.Item
              label="阿里云视频AccessKeyId"
              name="meedu.upload.video.aliyun.access_key_id"
            >
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item
              label="阿里云视频AccessKeySecret"
              name="meedu.upload.video.aliyun.access_key_secret"
            >
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <div className="from-title mt-30">腾讯云视频</div>
            <Form.Item label="腾讯云视频AppId" name="tencent.vod.app_id">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item label="腾讯云视频SecretId" name="tencent.vod.secret_id">
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item
              label="腾讯云视频SecretKey"
              name="tencent.vod.secret_key"
            >
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <Form.Item
              label="腾讯云播放key"
              name="meedu.system.player.tencent_play_key"
            >
              <Input style={{ width: 300 }} allowClear />
            </Form.Item>
            <div className="from-title mt-30">播放格式白名单</div>
            <Form.Item
              label="视频播放格式白名单"
              name="meedu.system.player.video_format_whitelist"
            >
              <Select
                mode="multiple"
                style={{ width: 300 }}
                allowClear
                options={definition}
                placeholder="请选择"
              />
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

export default SystemVideoSaveConfigPage;
