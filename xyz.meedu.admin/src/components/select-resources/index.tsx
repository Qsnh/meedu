import { useEffect, useState } from "react";
import { Modal, message, Tabs } from "antd";
import { useDispatch, useSelector } from "react-redux";
import { VodComp } from "./components/vod";
import { RoleComp } from "./components/vip";
import { VideoComp } from "./components/video";

interface PropsInterface {
  enabledResource: any;
  open: boolean;
  onSelected: (result: any) => void;
  onCancel: () => void;
}

export const SelectResources = (props: PropsInterface) => {
  const [selected, setSelected] = useState<any>(null);
  const [enabledResourceMap, setEnabledResourceMap] = useState<any>({});
  const [avaliableResources, setAvaliableResources] = useState<any>([]);
  const [resourceActive, setResourceActive] = useState<string>("vod");
  const enabledAddons = useSelector(
    (state: any) => state.enabledAddonsConfig.value.enabledAddons
  );

  useEffect(() => {
    if (!props.enabledResource) {
      setEnabledResourceMap({});
    } else {
      let items = props.enabledResource.split(",");
      let r: any = {};
      items.forEach((item: any) => {
        r[item] = 1;
      });
      setEnabledResourceMap(r);
    }
  }, [props.enabledResource]);

  useEffect(() => {
    let resources = [];

    if (enabledResourceMap["vod"]) {
      resources.push({
        label: "录播",
        key: "vod",
      });
    }

    if (enabledResourceMap["vip"]) {
      resources.push({
        label: "VIP会员",
        key: "vip",
      });
    }

    if (enabledResourceMap["video"]) {
      resources.push({
        label: "视频",
        key: "video",
      });
    }

    setAvaliableResources(resources);
    if (resources.length === 1) {
      setResourceActive(resources[0].key);
    }
  }, [enabledResourceMap, enabledAddons]);

  const onChange = (key: string) => {
    setResourceActive(key);
  };

  const change = (result: any) => {
    setSelected(result);
  };

  return (
    <>
      {props.open ? (
        <Modal
          title="选择"
          closable={false}
          onCancel={() => {
            props.onCancel();
          }}
          open={true}
          width={900}
          maskClosable={false}
          onOk={() => {
            if (!selected) {
              message.error("请先选择内容");
              return;
            }
            props.onSelected(selected);
          }}
          centered
        >
          <div className="float-left">
            <Tabs
              defaultActiveKey={resourceActive}
              items={avaliableResources}
              onChange={onChange}
            />
          </div>
          <div
            className="float-left"
            style={{
              maxHeight: 520,
              overflowX: "hidden",
              overflowY: "auto",
              marginBottom: 10,
            }}
          >
            {resourceActive === "vod" && <VodComp onChange={change}></VodComp>}
            {resourceActive === "vip" && (
              <RoleComp onChange={change}></RoleComp>
            )}
            {resourceActive === "video" && (
              <VideoComp onChange={change}></VideoComp>
            )}
          </div>
        </Modal>
      ) : null}
    </>
  );
};
