import React from "react";
import styles from "./index.module.scss";
import { Carousel } from "antd";
import { useNavigate } from "react-router-dom";

interface PropInterface {
  items: any;
}

export const PCSliderComp: React.FC<PropInterface> = ({ items }) => {
  const navigate = useNavigate();

  const sliderClick = (url: string) => {
    if (!url) {
      return;
    }
    if (url.match("https:") || url.match("http:") || url.match("www")) {
      window.location.href = url;
    } else {
      navigate(url);
    }
  };

  const contentStyle: React.CSSProperties = {
    width: "100%",
    height: "400px",
    textAlign: "center",
    borderRadius: "16px 16px 0 0",
    cursor: "pointer",
    border: "none",
  };

  return (
    <>
      {items && items.length > 0 && (
        <div className={styles["slider-box"]}>
          <Carousel autoplay>
            {items.map((item: any, index: number) => (
              <div
                key={index}
                onClick={() => sliderClick(item.href)}
                style={{ border: "none", outline: "none" }}
              >
                <img src={item.src} style={contentStyle} />
              </div>
            ))}
          </Carousel>
        </div>
      )}
    </>
  );
};
