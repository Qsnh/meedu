import React, { useState, useEffect } from "react";
import styles from "./grid-nav.module.scss";
import { Input, Button, message, Radio } from "antd";
import { viewBlock } from "../../../../../api/index";
import { SelectImage, H5Link, CloseIcon } from "../../../../../components";
import defaultIcon from "../../../../../assets/images/decoration/h5/default-grid-nav.png";

interface PropInterface {
  block: any;
  onUpdate: () => void;
}

export const GridNavSet: React.FC<PropInterface> = ({ block, onUpdate }) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [config, setConfig] = useState<any>({});
  const [showSelectImageWin, setShowSelectImageWin] = useState<boolean>(false);
  const [showLinkWin, setShowLinkWin] = useState<boolean>(false);
  const [curImageIndex, setCurImageIndex] = useState<any>(null);
  const [curLinkIndex, setCurLinkIndex] = useState<any>(null);
  const [lineCount, setLineCount] = useState(0);
  const [value, setValue] = useState<any>(null);

  useEffect(() => {
    if (block) {
      setConfig(block.config_render);
    }
  }, [block]);

  useEffect(() => {
    if (config && config.items) {
      let num = Math.ceil(config.items.length / config.line_count);
      setLineCount(num);
    }
  }, [config]);

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

  const addNav = () => {
    let obj = { ...config };
    obj.items.push({
      name: "xxx",
      href: null,
      icon: null,
    });
    setConfig(obj);
  };

  const delNav = (index: number) => {
    setCurImageIndex(null);
    setCurLinkIndex(null);
    let obj = { ...config };
    obj.items.splice(index, 1);
    setConfig(obj);
  };

  const linkChange = (link: any) => {
    if (curLinkIndex === null) {
      return;
    }
    let obj = { ...config };
    obj.items[curLinkIndex].href = link;
    setConfig(obj);
    setShowLinkWin(false);
  };

  const selectIcon = (index: number) => {
    setCurImageIndex(index);
    setShowSelectImageWin(true);
  };

  const selectLink = (index: number) => {
    setCurLinkIndex(index);
    setShowLinkWin(true);
  };

  const uploadImage = (src: any) => {
    if (curImageIndex === null) {
      return;
    }
    let obj = { ...config };
    obj.items[curImageIndex].src = src;
    setConfig(obj);
    setShowSelectImageWin(false);
  };

  return (
    <div className={styles["grid-nav-box"]}>
      <div className={styles["title"]}>
        <div className={styles["text"]}>宫格导航</div>
      </div>
      <div className={styles["config-item"]}>
        <div className={styles["config-item-title"]}>排列样式</div>
        <div className={styles["config-body"]}>
          <div className="float-left d-flex">
            <div className={styles["form-label"]}>每行显示个数</div>
            <div className="ml-30">
              <Radio
                checked={config.line_count === 4}
                value={config.line_count}
                onChange={(e) => {
                  let obj = { ...config };
                  obj.line_count = 4;
                  setConfig(obj);
                }}
              >
                4个
              </Radio>
              <Radio
                checked={config.line_count === 5}
                value={config.line_count}
                onChange={(e) => {
                  let obj = { ...config };
                  obj.line_count = 5;
                  setConfig(obj);
                }}
              >
                5个
              </Radio>
            </div>
          </div>
        </div>
      </div>
      <div className={styles["config-item"]}>
        <div className={styles["config-item-title"]}>导航内容</div>
        <div className={styles["config-body"]}>
          {config.items &&
            config.items.length > 0 &&
            config.items.map((item: any, index: number) => (
              <div className={styles["nav-item"]} key={index}>
                <div
                  className={styles["btn-del"]}
                  onClick={() => delNav(index)}
                >
                  <CloseIcon></CloseIcon>
                </div>
                <div
                  className={styles["nav-icon"]}
                  onClick={() => selectIcon(index)}
                >
                  {item.src ? (
                    <img src={item.src} width={60} height={60} />
                  ) : (
                    <img src={defaultIcon} width={60} height={60} />
                  )}
                </div>
                <div className={styles["nav-body"]}>
                  <div className="float-left d-flex">
                    <div className={styles["form-label"]}>标题</div>
                    <div className="ml-15">
                      <Input
                        value={item.name}
                        style={{ width: 100 }}
                        onChange={(e) => {
                          let value = e.target.value;
                          let obj = { ...config };
                          obj.items[index].name = value;
                          setConfig(obj);
                        }}
                      />
                    </div>
                  </div>
                  <div className="float-left d-flex mt-15">
                    <div className={styles["form-label"]}>链接</div>
                    <div className="ml-15 flex-1">
                      <Input
                        value={item.href}
                        style={{ width: 100 }}
                        onChange={(e) => {
                          let value = e.target.value;
                          let obj = { ...config };
                          obj.items[index].href = value;
                          setConfig(obj);
                        }}
                      />
                    </div>
                    <Button
                      type="link"
                      className="c-primary"
                      style={{ fontSize: 12 }}
                      onClick={() => {
                        if (
                          item.href &&
                          (item.href.match("https://") ||
                            item.href.match("http://"))
                        ) {
                          setValue(null);
                        } else {
                          setValue(item.href);
                        }
                        selectLink(index);
                      }}
                    >
                      选择
                    </Button>
                  </div>
                </div>
              </div>
            ))}
        </div>
      </div>
      <div className="float-left mt-15">
        <div className="float-left">
          <Button style={{ width: "100%" }} onClick={() => addNav()}>
            添加导航
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
      <SelectImage
        open={showSelectImageWin}
        from={0}
        scene="decoration"
        onCancel={() => setShowSelectImageWin(false)}
        onSelected={(url) => {
          uploadImage(url);
        }}
      ></SelectImage>
      <H5Link
        defautValue={value}
        open={showLinkWin}
        onClose={() => setShowLinkWin(false)}
        onChange={(value: any) => linkChange(value)}
      ></H5Link>
    </div>
  );
};
