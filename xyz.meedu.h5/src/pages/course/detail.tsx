import { useEffect, useState, useRef } from "react";
import styles from "./detail.module.scss";
import { useLocation } from "react-router-dom";
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
  const result = new URLSearchParams(useLocation().search);
  const [id, setId] = useState(Number(result.get("id") || 0));
  const [resDATA, setResDATA] = useState<CourseResponseInterface | null>(null);

  useEffect(() => {
    setId(Number(result.get("id")));
  }, [result.get("id")]);

  useEffect(() => {
    getDetail();
  }, [id]);

  const getDetail = () => {
    course.Detail(id).then((res: any) => {
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
            <TabsComponent id={id} data={resDATA} />
          </>
        ) : null}
      </div>
    </>
  );
};

export default CourseDetailPage;
