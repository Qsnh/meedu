import { useEffect, useState, useRef } from "react";
import styles from "./detail.module.scss";
import { useParams } from "react-router-dom";
import { course } from "../../api";
import NavHeader from "../../components/nav-header";
import TabsComponent from "./compenents/tabs";

interface CourseResponseInterface {
  attach: any[];
  buyVideos: any[];
  course: CourseDetailInterface;
  isBuy: boolean;
  isCollect: boolean;
  videoWatchedProgress: any[];
  chapters: CourseDetailChapterInterface[];
  videos: CourseDetailVideosInterface;
}

const CourseDetailPage = () => {
  const params = useParams();
  const [resDATA, setResDATA] = useState<CourseResponseInterface | null>(null);

  useEffect(() => {
    getDetail();
  }, [params.courseId]);

  const getDetail = () => {
    course.Detail(Number(params.courseId)).then((res: any) => {
      setResDATA(res.data);
      document.title = res.data.course.title;
    });
  };

  return (
    <>
      <div className={styles["box"]}>
        <NavHeader text="课程详情" />
        {resDATA && resDATA.course ? (
          <>
            <div className={styles["course-thumb"]}>
              <img src={resDATA.course.thumb} width="100%" />
            </div>
            <div className={styles["course-title"]}>{resDATA.course.title}</div>
            <div className={styles["stat"]}>
              <div className={`${styles["charge"]} ${styles["item"]}`}>
                {resDATA.course.is_free === 1 || resDATA.course.charge == 0 ? (
                  <span className={styles["value"]}>免费</span>
                ) : resDATA.course.charge > 0 ? (
                  <>
                    <span className={styles["small"]}>￥</span>
                    {resDATA.course.charge}
                  </>
                ) : null}
              </div>
              <div className={`${styles["user-count"]} ${styles["item"]}`}>
                <span>{resDATA.course.user_count}人已订阅</span>
              </div>
            </div>
            <div className={styles["line"]}></div>
            <TabsComponent id={Number(params.courseId)} data={resDATA} />
          </>
        ) : null}
      </div>
    </>
  );
};

export default CourseDetailPage;
