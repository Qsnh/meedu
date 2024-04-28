import styles from "./index.module.scss";
import { useNavigate } from "react-router-dom";
import { VodCourseItem } from "../../../../components/vod-course-item";

interface PropInterface {
  render: any;
  name: string;
}

export const IndexVodV1: React.FC<PropInterface> = ({ render, name }) => {
  const navigate = useNavigate();

  return (
    <>
      {render.length > 0 && (
        <div className={styles["index-section-box"]}>
          <div className={styles["index-section-title"]}>
            <div className={styles["index-section-title-text"]}>{name}</div>
            <div className={styles["more"]}>
              <span onClick={() => navigate("/vod")}>查看全部</span>
            </div>
          </div>
          <div className={styles["index-section-body"]}>
            {render.map((course: any, index: number) => (
              <div className={styles["vod-course-item"]} key={index}>
                <VodCourseItem
                  cid={course.id}
                  thumb={course.thumb}
                  title={course.title}
                  charge={course.charge}
                  isFree={course.is_free}
                  userCount={course.user_count}
                />
              </div>
            ))}
          </div>
        </div>
      )}
    </>
  );
};
