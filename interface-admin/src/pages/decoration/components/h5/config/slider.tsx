import React, { useState, useEffect } from "react";
import styles from "./slider.module.scss";
import { Input, Button, message } from "antd";
import { viewBlock } from "../../../../../api/index";
import { SelectImage, H5Link, CloseIcon } from "../../../../../components";
import defaultIcon from "../../../../../assets/images/decoration/h5/default-slider.png";

interface PropInterface {
  block: any;
  onUpdate: () => void;
}

export const SliderSet: React.FC<PropInterface> = ({ block, onUpdate }) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [sliders, setSliders] = useState<any>([]);
  const [showSelectImageWin, setShowSelectImageWin] = useState<boolean>(false);
  const [showLinkWin, setShowLinkWin] = useState<boolean>(false);
  const [curIndex, setCurIndex] = useState<any>(null);
  const [curLinkIndex, setCurLinkIndex] = useState<any>(null);
  const [value, setValue] = useState<any>(null);

  useEffect(() => {
    if (block) {
      setSliders(block.config_render);
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
        config: sliders,
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

  const addSlider = () => {
    let obj = [...sliders];
    obj.push({
      src: null,
      link: null,
    });
    setCurIndex(obj.length - 1);
    setSliders(obj);
    setShowSelectImageWin(true);
  };

  const changeImage = (index: number) => {
    setCurIndex(index);
    setShowSelectImageWin(true);
  };

  const selectLink = (index: number) => {
    setCurLinkIndex(index);
    setShowLinkWin(true);
  };

  const delSlider = (index: number) => {
    setCurIndex(null);
    setCurLinkIndex(null);
    let obj = [...sliders];
    obj.splice(index, 1);
    setSliders(obj);
  };

  const uploadImage = (src: any) => {
    if (curIndex === null) {
      return;
    }
    let obj = [...sliders];
    obj[curIndex].src = src;
    setSliders(obj);
    setShowSelectImageWin(false);
  };

  const linkChange = (link: any) => {
    if (curLinkIndex === null) {
      return;
    }
    let obj = [...sliders];
    obj[curLinkIndex].href = link;
    setSliders(obj);
    setShowLinkWin(false);
  };

  return (
    <div className={styles["vod-v1-box"]}>
      <div className={styles["title"]}>
        <div className={styles["text"]}>幻灯片</div>
        <div className={styles["desc"]}>图片宽高比3:1 推荐尺寸1200x400</div>
      </div>
      <div className={styles["sliders-box"]}>
        {sliders.length > 0 &&
          sliders.map((item: any, index: number) => (
            <div className={styles["slider-item"]} key={index}>
              <div
                className={styles["btn-del"]}
                onClick={() => delSlider(index)}
              >
                <CloseIcon></CloseIcon>
              </div>
              <div
                className={styles["img"]}
                onClick={() => {
                  changeImage(index);
                }}
              >
                {item.src ? (
                  <img src={item.src} width={345} height={115} />
                ) : (
                  <img src={defaultIcon} width={345} height={115} />
                )}
              </div>
              <div className={styles["link"]}>
                <div className={styles["label"]}>链接</div>
                <div className={styles["value"]}>
                  <Input
                    value={item.href}
                    style={{ width: "100%" }}
                    onChange={(e) => {
                      let value = e.target.value;
                      let obj = [...sliders];
                      obj[index].href = value;
                      setSliders(obj);
                    }}
                  />
                </div>
                <div className={styles["option"]}>
                  <Button
                    type="link"
                    className="c-primary"
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
                    选择链接
                  </Button>
                </div>
              </div>
            </div>
          ))}
      </div>
      <div className="float-left mt-15">
        <div className="float-left">
          <Button style={{ width: "100%" }} onClick={() => addSlider()}>
            添加幻灯片
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
