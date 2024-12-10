import React, { useState, useEffect } from "react";
import styles from "./image-group.module.scss";
import { Input, Button, message } from "antd";
import { viewBlock } from "../../../../../api/index";
import { SelectImage, H5Link } from "../../../../../components";
import group1ActiveIcon from "../../../../../assets/images/decoration/h5/image-group-1-active.png";
import group1Icon from "../../../../../assets/images/decoration/h5/image-group-1.png";
import group2ActiveIcon from "../../../../../assets/images/decoration/h5/image-group-2-active.png";
import group2Icon from "../../../../../assets/images/decoration/h5/image-group-2.png";
import group3ActiveIcon from "../../../../../assets/images/decoration/h5/image-group-3-active.png";
import group3Icon from "../../../../../assets/images/decoration/h5/image-group-3.png";
import group4ActiveIcon from "../../../../../assets/images/decoration/h5/image-group-4-active.png";
import group4Icon from "../../../../../assets/images/decoration/h5/image-group-4.png";
import group5ActiveIcon from "../../../../../assets/images/decoration/h5/image-group-1-2-active.png";
import group5Icon from "../../../../../assets/images/decoration/h5/image-group-1-2.png";
import emptyIcon from "../../../../../assets/images/decoration/h5/empty-image.png";

interface PropInterface {
  block: any;
  onUpdate: () => void;
}

export const ImageGroupSet: React.FC<PropInterface> = ({ block, onUpdate }) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [config, setConfig] = useState<any>({});
  const [showSelectImageWin, setShowSelectImageWin] = useState<boolean>(false);
  const [showLinkWin, setShowLinkWin] = useState<boolean>(false);
  const [curIndex, setCurIndex] = useState<any>(null);
  const [link, setLink] = useState<any>(null);
  const [value, setValue] = useState<any>(null);

  useEffect(() => {
    if (block) {
      setConfig(block.config_render);
    }
  }, [block]);

  useEffect(() => {
    if (curIndex !== null) {
      let obj = { ...config };
      obj.items[curIndex].url = link;
      setConfig(obj);
    }
  }, [link]);

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

  const swtichV = (newVal: any) => {
    setCurIndex(null);
    let obj = { ...config };
    obj.v = newVal;
    if (newVal === "v-1") {
      obj.items = [
        {
          src: null,
          url: null,
        },
      ];
    } else if (newVal === "v-2") {
      obj.items = [
        {
          src: null,
          url: null,
        },
        {
          src: null,
          url: null,
        },
      ];
    } else if (newVal === "v-3") {
      obj.items = [
        {
          src: null,
          url: null,
        },
        {
          src: null,
          url: null,
        },
        {
          src: null,
          url: null,
        },
      ];
    } else if (newVal === "v-4") {
      obj.items = [
        {
          src: null,
          url: null,
        },
        {
          src: null,
          url: null,
        },
        {
          src: null,
          url: null,
        },
        {
          src: null,
          url: null,
        },
      ];
    } else if (newVal === "v-1-2") {
      obj.items = [
        {
          src: null,
          url: null,
        },
        {
          src: null,
          url: null,
        },
        {
          src: null,
          url: null,
        },
      ];
    }
    setConfig(obj);
  };

  const setCurNumber = (index: number) => {
    setCurIndex(index);
    setLink(config.items[index].url);
    setShowSelectImageWin(true);
  };

  const uploadImage = (src: any) => {
    if (curIndex === null) {
      return;
    }
    let obj = { ...config };
    obj.items[curIndex].src = src;
    setConfig(obj);
    setShowSelectImageWin(false);
  };

  const linkChange = (url: any) => {
    if (curIndex === null) {
      return;
    }
    setLink(url);
    let obj = { ...config };
    obj.items[curIndex].url = url;
    setConfig(obj);
    setShowLinkWin(false);
  };

  return (
    <div className={styles["vod-v1-box"]}>
      <div className={styles["title"]}>
        <div className={styles["text"]}>图片魔方</div>
      </div>
      <div className={styles["config-item"]}>
        <div className={styles["config-item-title"]}>排版</div>
        <div className={styles["config-item-body"]}>
          <div className="d-flex">
            <div
              className="image-group-1 cursor-pointer"
              onClick={() => swtichV("v-1")}
            >
              {config.v === "v-1" ? (
                <img src={group1ActiveIcon} width={50} height={50} />
              ) : (
                <img src={group1Icon} width={50} height={50} />
              )}
            </div>
            <div
              className="image-group-2 ml-5 cursor-pointer"
              onClick={() => swtichV("v-2")}
            >
              {config.v === "v-2" ? (
                <img src={group2ActiveIcon} width={50} height={50} />
              ) : (
                <img src={group2Icon} width={50} height={50} />
              )}
            </div>
            <div
              className="image-group-2 ml-5 cursor-pointer"
              onClick={() => swtichV("v-3")}
            >
              {config.v === "v-3" ? (
                <img src={group3ActiveIcon} width={50} height={50} />
              ) : (
                <img src={group3Icon} width={50} height={50} />
              )}
            </div>
            <div
              className="image-group-4 ml-5 cursor-pointer"
              onClick={() => swtichV("v-4")}
            >
              {config.v === "v-4" ? (
                <img src={group4ActiveIcon} width={50} height={50} />
              ) : (
                <img src={group4Icon} width={50} height={50} />
              )}
            </div>
            <div
              className="image-group-1-2 ml-5 cursor-pointer"
              onClick={() => swtichV("v-1-2")}
            >
              {config.v === "v-1-2" ? (
                <img src={group5ActiveIcon} width={50} height={50} />
              ) : (
                <img src={group5Icon} width={50} height={50} />
              )}
            </div>
          </div>
        </div>
      </div>
      <div className={styles["config-item"]}>
        <div className={styles["config-item-title"]}>配置</div>
        <div className={styles["config-item-body"]}>
          {config.v === "v-1" && (
            <div
              className="float-left cursor-pointer"
              onClick={() => setCurNumber(0)}
            >
              {config.items[0].src ? (
                <img src={config.items[0].src} style={{ width: "100%" }} />
              ) : (
                <img src={emptyIcon} style={{ width: "100%" }} />
              )}
            </div>
          )}
          {config.v === "v-2" && (
            <div className="d-flex">
              <div
                className="float-left cursor-pointer"
                onClick={() => setCurNumber(0)}
              >
                {config.items[0].src ? (
                  <img src={config.items[0].src} style={{ width: "100%" }} />
                ) : (
                  <img src={emptyIcon} style={{ width: "100%" }} />
                )}
              </div>
              <div
                className="float-left cursor-pointer"
                onClick={() => setCurNumber(1)}
              >
                {config.items[1].src ? (
                  <img src={config.items[1].src} style={{ width: "100%" }} />
                ) : (
                  <img src={emptyIcon} style={{ width: "100%" }} />
                )}
              </div>
            </div>
          )}
          {config.v === "v-3" && (
            <div className="d-flex">
              <div
                className="float-left cursor-pointer"
                onClick={() => setCurNumber(0)}
              >
                {config.items[0].src ? (
                  <img src={config.items[0].src} style={{ width: "100%" }} />
                ) : (
                  <img src={emptyIcon} style={{ width: "100%" }} />
                )}
              </div>
              <div
                className="float-left cursor-pointer"
                onClick={() => setCurNumber(1)}
              >
                {config.items[1].src ? (
                  <img src={config.items[1].src} style={{ width: "100%" }} />
                ) : (
                  <img src={emptyIcon} style={{ width: "100%" }} />
                )}
              </div>
              <div
                className="float-left cursor-pointer"
                onClick={() => setCurNumber(2)}
              >
                {config.items[2].src ? (
                  <img src={config.items[2].src} style={{ width: "100%" }} />
                ) : (
                  <img src={emptyIcon} style={{ width: "100%" }} />
                )}
              </div>
            </div>
          )}
          {config.v === "v-4" && (
            <div className="d-flex">
              <div
                className="float-left cursor-pointer"
                onClick={() => setCurNumber(0)}
              >
                {config.items[0].src ? (
                  <img src={config.items[0].src} style={{ width: "100%" }} />
                ) : (
                  <img src={emptyIcon} style={{ width: "100%" }} />
                )}
              </div>
              <div
                className="float-left cursor-pointer"
                onClick={() => setCurNumber(1)}
              >
                {config.items[1].src ? (
                  <img src={config.items[1].src} style={{ width: "100%" }} />
                ) : (
                  <img src={emptyIcon} style={{ width: "100%" }} />
                )}
              </div>
              <div
                className="float-left cursor-pointer"
                onClick={() => setCurNumber(2)}
              >
                {config.items[2].src ? (
                  <img src={config.items[2].src} style={{ width: "100%" }} />
                ) : (
                  <img src={emptyIcon} style={{ width: "100%" }} />
                )}
              </div>
              <div
                className="float-left cursor-pointer"
                onClick={() => setCurNumber(3)}
              >
                {config.items[3].src ? (
                  <img src={config.items[3].src} style={{ width: "100%" }} />
                ) : (
                  <img src={emptyIcon} style={{ width: "100%" }} />
                )}
              </div>
            </div>
          )}
          {config.v === "v-1-2" && (
            <div className="d-flex">
              <div
                className="flex-1 cursor-pointer"
                onClick={() => setCurNumber(0)}
                style={{ height: 150 }}
              >
                {config.items[0].src ? (
                  <img
                    src={config.items[0].src}
                    style={{ width: "100%" }}
                    height={150}
                  />
                ) : (
                  <img src={emptyIcon} style={{ width: "100%" }} height={150} />
                )}
              </div>
              <div className="flex-1">
                {config.items[1] && (
                  <div
                    className="float-left cursor-pointer"
                    onClick={() => setCurNumber(1)}
                    style={{ height: 75 }}
                  >
                    {config.items[1].src ? (
                      <img
                        src={config.items[1].src}
                        style={{ width: "100%" }}
                        height={75}
                      />
                    ) : (
                      <img
                        src={emptyIcon}
                        style={{ width: "100%" }}
                        height={75}
                      />
                    )}
                  </div>
                )}
                {config.items[2] && (
                  <div
                    className="float-left cursor-pointer"
                    onClick={() => setCurNumber(2)}
                    style={{ height: 75 }}
                  >
                    {config.items[2].src ? (
                      <img
                        src={config.items[2].src}
                        style={{ width: "100%" }}
                        height={75}
                      />
                    ) : (
                      <img
                        src={emptyIcon}
                        style={{ width: "100%" }}
                        height={75}
                      />
                    )}
                  </div>
                )}
              </div>
            </div>
          )}
        </div>
      </div>
      {curIndex !== null && (
        <div className={styles["config-item"]}>
          <div className={styles["config-item-title"]}>
            第{curIndex + 1}张图的链接
          </div>
          <div className={styles["config-item-body"]}>
            <div className="d-flex">
              <div className="flex-1">
                <Input
                  value={link}
                  style={{ width: "100%" }}
                  onChange={(e) => {
                    setLink(e.target.value);
                  }}
                />
              </div>
              <div className="ml-15">
                <Button
                  type="link"
                  className="c-primary"
                  onClick={() => {
                    if (
                      link &&
                      (link.match("https://") || link.match("http://"))
                    ) {
                      setValue(null);
                    } else {
                      setValue(link);
                    }
                    setShowLinkWin(true);
                  }}
                >
                  选择链接
                </Button>
              </div>
            </div>
          </div>
        </div>
      )}
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
