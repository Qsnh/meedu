import React from "react";
import styles from "./index.module.scss";
import { ThumbBar } from "../thumb-bar";
import { useNavigate } from "react-router-dom";

interface PropInterface {
  cid: number;
  title: string;
  videosCount: number;
  thumb: string;
  charge: number;
  isFree: number;
  userCount: number;
  category: any;
}
export const VodCourseItem: React.FC<PropInterface> = ({
  cid,
  title,
  videosCount,
  thumb,
  charge,
  isFree,
  userCount,
  category,
}) => {
  const navigate = useNavigate();

  const goDetail = () => {
    navigate("/courses/detail/" + cid);
  };

  return (
    <div className={styles["vod-course-item-comp"]} onClick={() => goDetail()}>
      <div className={styles["vod-course-thumb"]}>
        <div className={styles["thumb-bar"]}>
          <ThumbBar value={thumb} width={264} height={198} border={null} />
        </div>
      </div>
      <div className={styles["vod-course-body"]}>
        <div className={styles["vod-course-title"]}>{title}</div>
        <div className={styles["vod-course-info"]}>
          <div className={styles["vod-course-sub"]}>{category.name}</div>
          <div className={styles["vod-course-charge"]}>
            {isFree === 0 && charge > 0 && (
              <span className={styles["charge-text"]}>
                <span className={styles["unit"]}>￥</span>
                {charge}
              </span>
            )}
            {isFree === 1 && <span className={styles["free-text"]}>免费</span>}
          </div>
        </div>
      </div>
    </div>
  );
};
