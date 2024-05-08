import React, { useState } from "react";
import styles from "./index.module.scss";
import { ThumbBar } from "../../../../../components";
import backIcon from "../../../../../assets/images/decoration/h5/course-back.png";

interface PropInterface {
  config: any;
}

export const RenderVod: React.FC<PropInterface> = ({ config }) => {
  const [loading, setLoading] = useState<boolean>(false);

  return (
    <div className="float-left">
      <div className={styles["vod-title"]}>{config.title}</div>
      <div className={styles["vod-courses-box"]}>
        {config.items.length === 0 &&
          Array.from({ length: 4 }).map((_, i) => (
            <div className={styles["vod-item"]} key={i}>
              <div className={styles["course-thumb"]}>
                <img src={backIcon} width={"100%"} />
              </div>
              <div className={styles["course-title"]}>录播课程</div>
              <div className={styles["course-info"]}>
                <div className={styles["sub"]}></div>
                <div className={styles["charge"]}>
                  <span className={styles["free"]}>免费</span>
                </div>
              </div>
            </div>
          ))}
        {config.items.length > 0 &&
          config.items.map((item: any, index: number) => (
            <div className={styles["vod-item"]} key={index}>
              <div className={styles["course-thumb"]}>
                {item.thumb ? (
                  <ThumbBar
                    width={264}
                    value={item.thumb}
                    height={198}
                    title=""
                    border={0}
                  ></ThumbBar>
                ) : (
                  <img src={backIcon} width={"100%"} />
                )}
              </div>
              <div className={styles["course-title"]}>{item.title}</div>
              <div className={styles["course-info"]}>
                <div className={styles["sub"]}>
                  {item.category ? item.category.name : ""}
                </div>
                {item.charge === 0 ? (
                  <div className={styles["charge"]}>
                    <span className={styles["free"]}>免费</span>
                  </div>
                ) : (
                  <div className={styles["charge"]}>
                    <span className={styles["unit"]}>￥</span>
                    {item.charge}
                  </div>
                )}
              </div>
            </div>
          ))}
      </div>
    </div>
  );
};
