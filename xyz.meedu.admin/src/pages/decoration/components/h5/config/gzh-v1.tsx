import React, { useState, useEffect } from "react";
import styles from "./gzh-v1.module.scss";
import { Input, Button, message } from "antd";
import { viewBlock } from "../../../../../api/index";
import { SelectImage } from "../../../../../components";
import editIcon from "../../../../../assets/images/decoration/h5/h5-edit.png";

interface PropInterface {
  block: any;
  onUpdate: () => void;
}

export const GzhV1Set: React.FC<PropInterface> = ({ block, onUpdate }) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [config, setConfig] = useState<any>({});
  const [showSelectImageWin, setShowSelectImageWin] = useState<boolean>(false);
  const [curImageIndex, setCurImageIndex] = useState<any>(null);

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

  const selectIcon = (index: number) => {
    setCurImageIndex(index);
    setShowSelectImageWin(true);
  };

  const uploadImage = (src: any) => {
    if (curImageIndex === null) {
      return;
    }
    let obj = { ...config };
    if (curImageIndex === 1) {
      obj.logo = src;
    } else {
      obj.qrcode = src;
    }
    setConfig(obj);
    setShowSelectImageWin(false);
  };

  return (
    <div className={styles["vod-v1-box"]}>
      <div className={styles["title"]}>
        <div className={styles["text"]}>公众号配置</div>
      </div>
      <div className={styles["line"]}></div>
      <div className={styles["config-item"]}>
        <div className={styles["config-item-body"]}>
          <div className="float-left d-flex">
            <div className={styles["form-label"]}>名称</div>
            <div className="flex-1 ml-15">
              <Input
                value={config.name}
                placeholder="请输入公众号名称"
                onChange={(e) => {
                  let value = e.target.value;
                  let obj = { ...config };
                  obj.name = value;
                  setConfig(obj);
                }}
              />
            </div>
          </div>
        </div>
      </div>
      <div className={styles["config-item"]}>
        <div className={styles["config-item-body"]}>
          <div className="float-left d-flex">
            <div className={styles["form-label"]}>引导</div>
            <div className="flex-1 ml-15">
              <Input
                value={config.desc}
                placeholder="填写引导，如“关注公众号了解更多”"
                onChange={(e) => {
                  let value = e.target.value;
                  let obj = { ...config };
                  obj.desc = value;
                  setConfig(obj);
                }}
              />
            </div>
          </div>
        </div>
      </div>
      <div className={styles["config-item"]}>
        <div className={styles["config-item-body"]}>
          <div className="float-left d-flex">
            <div className={styles["form-label"]}>头像</div>
            <div className="flex-1 ml-15">
              <div className={styles["thumb"]} onClick={() => selectIcon(1)}>
                {config.logo ? (
                  <img src={config.logo} width={100} height={100} />
                ) : (
                  <img src={editIcon} width={100} height={100} />
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className={styles["config-item"]}>
        <div className={styles["config-item-body"]}>
          <div className="float-left d-flex">
            <div className={styles["form-label"]}>二维码</div>
            <div className="flex-1 ml-15">
              <div className={styles["thumb"]} onClick={() => selectIcon(2)}>
                {config.qrcode ? (
                  <img src={config.qrcode} width={100} height={100} />
                ) : (
                  <img src={editIcon} width={100} height={100} />
                )}
              </div>
            </div>
          </div>
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
      <SelectImage
        open={showSelectImageWin}
        from={0}
        scene="decoration"
        onCancel={() => setShowSelectImageWin(false)}
        onSelected={(url) => {
          uploadImage(url);
        }}
      ></SelectImage>
    </div>
  );
};
