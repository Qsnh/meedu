import { useEffect, useState } from "react";
import { Modal, message, Tabs } from "antd";
import { useDispatch, useSelector } from "react-redux";
import { VodComp } from "./components/multiVod";
import { RoleComp } from "./components/multiVip";

interface PropsInterface {
  enabledResource: any;
  open: boolean;
  selectedVod: any;
  selectedLive: any;
  selectedBook: any;
  selectedPaper: any;
  selectedMockPaper: any;
  selectedPractice: any;
  selectedVip: any;
  type: boolean;
  onSelected: (result: any) => void;
  onCancel: () => void;
}

export const SelectResourcesMulti = (props: PropsInterface) => {
  const [selected, setSelected] = useState<any>(null);
  const [enabledResourceMap, setEnabledResourceMap] = useState<any>({});
  const [avaliableResources, setAvaliableResources] = useState<any>([]);
  const [resourceActive, setResourceActive] = useState<string>("");
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
    if (enabledResourceMap["paper"] && !props.type) {
      setResourceActive("paper");
    } else {
      setResourceActive("vod");
    }
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

    setAvaliableResources(resources);
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
            if (!selected || selected.length === 0) {
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
            {resourceActive === "vod" && (
              <VodComp selected={props.selectedVod} onChange={change}></VodComp>
            )}
            {resourceActive === "vip" && (
              <RoleComp
                selected={props.selectedVip}
                onChange={change}
              ></RoleComp>
            )}
          </div>
        </Modal>
      ) : null}
    </>
  );
};
