import React, { useState, useEffect } from "react";
import styles from "./blank.module.scss";
import { Input, Button, message, InputNumber } from "antd";
import { viewBlock } from "../../../../../api/index";

interface PropInterface {
  block: any;
  onUpdate: () => void;
}

export const BlankSet: React.FC<PropInterface> = ({ block, onUpdate }) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [config, setConfig] = useState<any>({});

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

  return (
    <div className={styles["vod-v1-box"]}>
      <div className={styles["title"]}>
        <div className={styles["text"]}>辅助空白块</div>
      </div>
      <div className={styles["config-item"]}>
        <div className={styles["config-item-title"]}>高度</div>
        <div className={styles["config-item-body"]}>
          <div className="d-flex">
            <InputNumber
              value={config.height}
              min={1}
              onChange={(e) => {
                let value = e;
                let obj = { ...config };
                obj.height = value;
                setConfig(obj);
              }}
            />
            <div className="ml-15">
              <span className="helper-text">单位：像素</span>
            </div>
          </div>
        </div>
      </div>
      <div className={styles["config-item"]}>
        <div className={styles["config-item-title"]}>背景颜色</div>
        <div className={styles["config-item-body"]}>
          <Input
            type="color"
            style={{ width: 32, padding: 0 }}
            value={config.bgcolor}
            onChange={(e) => {
              let value = e.target.value;
              let obj = { ...config };
              obj.bgcolor = value;
              setConfig(obj);
            }}
          />
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
    </div>
  );
};
