import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import courseIcon from "../../../../../assets/images/decoration/h5/course-back.png";

interface PropInterface {
  config: any;
}

export const RenderVod: React.FC<PropInterface> = ({ config }) => {
  const [loading, setLoading] = useState<boolean>(false);

  return (
    <div className={styles["vod-block-box"]}>
      <div className={styles["title"]}>
        <div className={styles["text"]}>{config.title}</div>
        <div className={styles["more"]}>更多</div>
      </div>
      <div className={styles["body"]}>
        {config.items.length === 0 &&
          Array.from({ length: 2 }).map((_, i) => (
            <div className={styles["course-item"]} key={i}>
              <div className={styles["course-thumb"]}>
                <img src={courseIcon} width={120} height={90} />
              </div>
              <div className={styles["course-body"]}>
                <div className={styles["course-title"]}>录播课程</div>
                <div className={styles["course-info"]}>
                  <div className={styles["sub"]}></div>
                  <div className={styles["price"]}>
                    <span className={styles["free"]}>免费</span>
                  </div>
                </div>
              </div>
            </div>
          ))}
        {config.items.length > 0 &&
          config.items.map((item: any, index: number) => (
            <div className={styles["course-item"]} key={index}>
              <div className={styles["course-thumb"]}>
                {item.thumb ? (
                  <img src={item.thumb} width={120} height={90} />
                ) : (
                  <img src={courseIcon} width={120} height={90} />
                )}
              </div>
              <div className={styles["course-body"]}>
                <div className={styles["course-title"]}>{item.title}</div>
                <div className={styles["course-info"]}>
                  <div className={styles["sub"]}>
                    <span>{item.user_count || 0}人已购买</span>
                  </div>
                  <div className={styles["price"]}>
                    {!item.charge && (
                      <span className={styles["free"]}>免费</span>
                    )}
                    {item.charge > 0 && (
                      <>
                        <small>￥</small>
                        <span>{item.charge}</span>
                      </>
                    )}
                  </div>
                </div>
              </div>
            </div>
          ))}
      </div>
    </div>
  );
};
