import React, { useState, useEffect } from "react";
import styles from "./code.module.scss";
import { Input, Button, message } from "antd";
import { viewBlock } from "../../../../../api/index";

interface PropInterface {
  block: any;
  onUpdate: () => void;
}

export const CodeSet: React.FC<PropInterface> = ({ block, onUpdate }) => {
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
        <div className={styles["text"]}>代码块</div>
      </div>
      <div className={styles["config-item"]}>
        <div className={styles["config-item-title"]}>代码内容</div>
        <div className={styles["config-item-body"]}>
          <Input.TextArea
            value={config.html}
            placeholder="请输入代码"
            autoSize={{ minRows: 10 }}
            onChange={(e) => {
              let value = e.target.value;
              let obj = { ...config };
              obj.html = value;
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
