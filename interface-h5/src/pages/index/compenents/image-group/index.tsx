import styles from "./index.module.scss";
import React from "react";
import { useNavigate } from "react-router-dom";

interface PropInterface {
  render: any;

  v: string;
}

export const IndexImageGroup: React.FC<PropInterface> = ({ render, v }) => {
  const navigate = useNavigate();

  const go = (item: any) => {
    if (!item.url) {
      return;
    }
    let url = item.url;
    if (url.substr(0, 4) === "http") {
      window.location.href = url;
    } else {
      navigate(url);
    }
  };
  return (
    <div className={styles["image-group-box"]}>
      {v === "v-1" || v === "v-2" || v === "v-3" || v === "v-4" ? (
        <>
          {render.map((item: any, index: number) => (
            <div
              className={
                v === "v-1" || v === "v-3" || v === "v-4"
                  ? `${styles["image-group-item"]} ${styles["v-item"]}`
                  : styles["image-group-item"]
              }
              onClick={() => go(item)}
              key={index}
            >
              <img className={styles["image"]} src={item.src} />
            </div>
          ))}
        </>
      ) : v === "v-1-2" ? (
        <>
          <div
            className={styles["image-group-item"]}
            onClick={() => go(render[0])}
          >
            <img className={styles["image"]} src={render[0].src} />
          </div>
          <div className={styles["image-group-item"]}>
            <div onClick={() => go(render[1])} className={styles["box"]}>
              <img className={styles["image"]} src={render[1].src} />
            </div>
            <div onClick={() => go(render[2])} className="box">
              <img className={styles["image"]} src={render[2].src} />
            </div>
          </div>
        </>
      ) : null}
    </div>
  );
};
