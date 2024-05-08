import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Carousel } from "antd";
import defaultIcon from "../../../../../assets/images/decoration/h5/default-slider.png";

interface PropInterface {
  config: any;
}

export const RenderSliders: React.FC<PropInterface> = ({ config }) => {
  const [loading, setLoading] = useState<boolean>(false);

  return (
    <div className={styles["slider-box"]}>
      <div className="float-left" style={{ height: 115 }}>
        {config.length > 0 && (
          <Carousel autoplay>
            {config.map((item: any, index: number) => (
              <div key={index} style={{ border: "none", outline: "none" }}>
                {item.src ? (
                  <img src={item.src} style={{ width: "100%", height: 115 }} />
                ) : (
                  <img
                    src={defaultIcon}
                    style={{ width: "100%", height: 115 }}
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
