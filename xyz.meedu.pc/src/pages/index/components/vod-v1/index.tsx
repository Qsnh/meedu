import React from "react";
import styles from "./index.module.scss";
import { VodCourseItem } from "../../../../components";

interface PropInterface {
  items: any;
  name: string;
}

export const VodComp: React.FC<PropInterface> = ({ items, name }) => {
  return (
    <>
      {items.length > 0 && (
        <div className={styles["index-section-box"]}>
          <div className={styles["index-section-title"]}>
            <div className={styles["index-section-title-text"]}>{name}</div>
          </div>
          <div className={styles["index-section-body"]}>
            {items.map((item: any, index: number) => (
              <div
                className={styles["vod-course-item"]}
                key={item.id + "vod" + index}
              >
                <VodCourseItem
                  cid={item.id}
                  videosCount={item.videos_count}
                  thumb={item.thumb}
                  category={item.category}
                  title={item.title}
                  charge={item.charge}
                  isFree={item.is_free}
                  userCount={item.user_count}
                ></VodCourseItem>
              </div>
            ))}
          </div>
        </div>
      )}
    </>
  );
};
