import styles from "./index.module.scss";
import { useNavigate } from "react-router-dom";

interface PropInterface {
  cid: number;
  thumb: string;
  title: string;
  userCount: number;
  isFree: number;
  charge: number;
}

export const VodCourseItem: React.FC<PropInterface> = ({
  cid,
  thumb,
  title,
  userCount,
  isFree,
  charge,
}) => {
  const navigate = useNavigate();

  const goShow = () => {
    navigate(`/course/${cid}`);
  };

  return (
    <div className={styles["vod-course-item-comp"]} onClick={() => goShow()}>
      <div className={styles["vod-course-thumb"]}>
        <img src={thumb} />
      </div>
      <div className={styles["vod-course-body"]}>
        <div className={styles["vod-course-title"]}>{title}</div>
        <div className={styles["vod-course-info"]}>
          <div className={styles["vod-course-sub"]}>{userCount}人已订阅</div>
          <div className={styles["vod-course-charge"]}>
            {isFree === 0 && charge > 0 && (
              <div className={styles["charge-text"]}>
                <span className={styles["unit"]}>￥</span>
                {charge}
              </div>
            )}
            {isFree === 1 && <div className={styles["free-text"]}>免费</div>}
          </div>
        </div>
      </div>
    </div>
  );
};
