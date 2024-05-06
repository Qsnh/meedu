import styles from "./index.module.scss";
import React from "react";
import { Swiper } from "antd-mobile";
import { useNavigate } from "react-router-dom";

interface PropInterface {
  render: any;
}

export const IndexSlider: React.FC<PropInterface> = ({ render }) => {
  const navigate = useNavigate();

  const items = render.map((item: any, index: number) => (
    <Swiper.Item key={index}>
      <div className={styles["swiper-slide"]}>
        <img
          onClick={() => goLink(item.href)}
          src={item.src}
          alt={"slide" + index}
        />
      </div>
    </Swiper.Item>
  ));

  const goLink = (url: string) => {
    if (url) {
      if (url.match("https:") || url.match("http:") || url.match("www")) {
        window.location.href = url;
      } else {
        navigate(url);
      }
    }
  };

  return (
    <>
      <div className={styles["slider-box"]}>
        <Swiper
          trackOffset={0}
          style={{
            "--border-radius": "8px",
            "--width": "100%",
            "--height": "115px",
            "--track-padding": "0px",
          }}
          defaultIndex={0}
        >
          {items}
        </Swiper>
      </div>
    </>
  );
};
