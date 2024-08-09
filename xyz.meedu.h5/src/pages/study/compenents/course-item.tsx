import React from "react";
import { useNavigate } from "react-router-dom";
import styles from "./course-item.module.scss";

interface PropInterface {
  list: any[];
  currenStatus: string;
}

export const CoursesModel: React.FC<PropInterface> = ({
  list,
  currenStatus,
}) => {
  const navigate = useNavigate();

  const goPlay = (item: any) => {
    if (currenStatus === "study" && item.last_view_video.length !== 0) {
      let vid = item.last_view_video.video_id;
      navigate("/course/video/" + vid);
    } else {
      goDetail(item.course_id);
    }
  };

  const goDetail = (id: number) => {
    navigate("/course/" + id);
  };

  return (
    <>
      <div className={styles["course-box"]}>
        {list.map((item: any, index: number) => (
          <div
            className={styles["course-item"]}
            key={index}
            onClick={() => goPlay(item)}
          >
            <div className={styles["course-thumb"]}>
              <img src={item.course.thumb} />
              {(item.is_subscribe === 1 || currenStatus === "course") && (
                <div className={styles["icon"]}>已订阅</div>
              )}
            </div>
            <div className={styles["course-body"]}>
              <div className={styles["course-title"]}>{item.course.title}</div>
              <div className={styles["at"]}>
                已学&nbsp;{item.learned_count}/{item.course.videos_count}课时
              </div>
            </div>
          </div>
        ))}
      </div>
    </>
  );
};
