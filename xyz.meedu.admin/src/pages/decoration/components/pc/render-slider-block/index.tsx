import React from "react";
import styles from "./index.module.scss";
import { Carousel } from "antd";
import defaultIcon from "../../../../../assets/images/decoration/h5/default-slider.png";

interface PropInterface {
  config: any;
}

export const RenderSliderBlock: React.FC<PropInterface> = ({ config }) => {
  return (
    <div className={styles["slider-box"]}>
      <div className="float-left" style={{ height: 200 }}>
        {config && config.length > 0 && (
          <Carousel autoplay>
            {config.map((item: any, index: number) => (
              <div key={index} style={{ border: "none", outline: "none" }}>
                {item.src ? (
                  <img src={item.src} style={{ width: "100%", height: 200 }} />
                ) : (
                  <img
                    src={defaultIcon}
                    style={{ width: "100%", height: 200 }}
                  />
                )}
              </div>
            ))}
          </Carousel>
        )}
      </div>
    </div>
  );
};
