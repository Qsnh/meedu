import React, { useState, useEffect } from "react";
import styles from "./vod-v1.module.scss";
import { Input, Button, message } from "antd";
import { viewBlock } from "../../../../../api/index";
import { CloseIcon, SelectResources } from "../../../../../components";
import editIcon from "../../../../../assets/images/decoration/h5/pc-edit.png";

interface PropInterface {
  block: any;
  onUpdate: () => void;
}

export const VodV1Set: React.FC<PropInterface> = ({ block, onUpdate }) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [config, setConfig] = useState<any>({});
  const [showVodWin, setShowVodWin] = useState<boolean>(false);
  const [curVodIndex, setCurVodIndex] = useState<any>(null);

  useEffect(() => {
    if (block) {
      setConfig(block.config_render);
    }
  }, [block]);

  const save = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    viewBlock
      .update(block.id, {
        sort: block.sort,
        config: config,
      })
      .then((res: any) => {
        message.success("成功");
        setLoading(false);
        onUpdate();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const changeCourse = (index: number) => {
    setCurVodIndex(index);
    setShowVodWin(true);
  };

  const addCourse = () => {
    let obj = { ...config };
    obj.items.push({
      title: null,
      thumb: null,
    });
    setCurVodIndex(obj.items.length - 1);
    setConfig(obj);
    setShowVodWin(true);
  };

  const delCourse = (index: number) => {
    let obj = { ...config };
    obj.items.splice(index, 1);
    setConfig(obj);
  };

  const vodChange = (vodCourse: any) => {
    if (curVodIndex === null) {
      return;
    }
    let obj = { ...config };
    Object.assign(obj.items[curVodIndex], vodCourse);
    setConfig(obj);
    setShowVodWin(false);
  };

  return (
    <div className={styles["vod-v1-box"]}>
      <div className={styles["title"]}>
        <div className={styles["text"]}>录播课程配置</div>
      </div>
      <div className={styles["config-item"]}>
        <div className={styles["config-item-title"]}>板块标题</div>
        <div className={styles["config-item-body"]}>
          <div className="float-left d-flex">
            <div className={styles["form-label"]}>标题</div>
            <div className="flex-1 ml-15">
              <Input
                value={config.title}
                placeholder="请输入标题"
                onChange={(e) => {
                  let value = e.target.value;
                  let obj = { ...config };
                  obj.title = value;
                  setConfig(obj);
                }}
              />
            </div>
          </div>
        </div>
      </div>
      <div className={styles["config-item"]}>
        <div className={styles["config-item-title"]}>板块内容</div>
        <div className={styles["config-item-body"]}>
          <div className={styles["courses-list-box"]}>
            {config.items &&
              config.items.length > 0 &&
              config.items.map((item: any, index: number) => (
                <div
                  className={styles["course-item"]}
                  key={index}
                  onClick={() => changeCourse(index)}
                >
                  {item.thumb ? (
                    <img src={item.thumb} width={80} height={60} />
                  ) : (
                    <img src={editIcon} width={80} height={60} />
                  )}
                  <div
                    className={styles["btn-del"]}
                    onClick={(e) => {
                      e.stopPropagation();
                      e.nativeEvent.stopImmediatePropagation();
                      delCourse(index);
                    }}
                  >
                    <CloseIcon></CloseIcon>
                  </div>
                </div>
              ))}
          </div>
        </div>
      </div>
      <div className="float-left mt-15">
        <div className="float-left">
          <Button style={{ width: "100%" }} onClick={() => addCourse()}>
            添加课程
          </Button>
        </div>
      </div>
      <div className={styles["footer-button"]}>
        <Button
          type="primary"
          style={{ width: "100%" }}
          loading={loading}
          onClick={() => save()}
        >
          保存
        </Button>
      </div>
      <SelectResources
        open={showVodWin}
        enabledResource={"vod"}
        onCancel={() => setShowVodWin(false)}
        onSelected={(result: any) => {
          let item = {
            charge: result.charge,
            id: result.id,
            thumb: result.thumb,
            title: result.title,
          };
          vodChange(item);
        }}
      ></SelectResources>
    </div>
  );
};
