import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { system } from "../../../../../api";
import { Carousel } from "antd";
import { SlidersList } from "./list";

interface PropInterface {
  reload: boolean;
  width: number;
}

export const RenderSliders: React.FC<PropInterface> = ({ reload, width }) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [showListWin, setShowListWin] = useState<boolean>(false);

  useEffect(() => {
    getData();
  }, [reload]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .slidersList({
        platform: "PC",
      })
      .then((res: any) => {
        setList(res.data);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const close = () => {
    setShowListWin(false);
    getData();
  };

  return (
    <div className={styles["sliders-box"]}>
      <div className="float-left" onClick={() => setShowListWin(true)}>
        {list.length > 0 && (
          <Carousel autoplay>
            {list.map((item: any) => (
              <div key={item.sort} style={{ border: "none", outline: "none" }}>
                <img
                  src={item.thumb}
                  style={{ width: width, height: Math.floor(width / 3) }}
                />
              </div>
            ))}
          </Carousel>
        )}
        {list.length === 0 && (
          <div className={styles["empty-data"]}>请添加幻灯片</div>
        )}
      </div>
      <SlidersList open={showListWin} onClose={() => close()}></SlidersList>
    </div>
  );
};
