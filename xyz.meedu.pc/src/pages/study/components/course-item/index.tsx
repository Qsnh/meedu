import React, { useState } from "react";
import styles from "./index.module.scss";
import { ThumbBar } from "../../../../components/thumb-bar";
import { useNavigate } from "react-router-dom";
import { dateFormat } from "../../../../utils/index";
import { DetailDialog } from "../detail-dialog";

interface PropInterface {
  list: any[];
  currentStatus: number;
}

export const CourseItemComp: React.FC<PropInterface> = ({
  list,
  currentStatus,
}) => {
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);
  const [visiable, setVisiable] = useState<boolean>(false);
  const [cid, setCid] = useState(0);

  const goPlay = (item: any) => {
    if (item.progress < 100 && item.last_view_video.length !== 0) {
      let vid = item.last_view_video.video_id;
      navigate("/courses/video/" + vid);
    } else {
      goDetail(item.course_id);
    }
  };

  const goDetail = (id: number) => {
    let tab = currentStatus === 2 ? 3 : 2;
    navigate("/courses/detail/" + id + "?tab=" + tab);
  };

  return (
    <>
      <DetailDialog
        open={visiable}
        id={cid}
        onCancel={() => setVisiable(false)}
      ></DetailDialog>
      <div className={styles["box"]}>
        {currentStatus === 1 &&
          list.map((item: any) => (
            <div className={styles["item-box"]} key={item.id + "course-learn"}>
              {item.course && item.course.id && (
                <div className={styles["item"]}>
                  <div className={styles["left-item"]}>
                    <ThumbBar
                      value={item.course.thumb}
                      border={4}
                      width={160}
                      height={120}
                    ></ThumbBar>
                    {item.is_subscribe === 1 && (
                      <div className={styles["icon"]}>已购买</div>
                    )}
                  </div>
                  <div className={styles["right-item"]}>
                    <div className={styles["item-title"]}>
                      {item.course.title}
                    </div>
                    <div className={styles["item-info"]}>
                      <div className={styles["item-text"]}>
                        已学完：<span>{item.learned_count}课时</span> / 共
                        {item.course.videos_count}课时
                      </div>
                    </div>
                  </div>
                  <div
                    className={styles["detail-button"]}
                    onClick={() => {
                      setCid(item.course_id);
                      setVisiable(true);
                    }}
                  >
                    学习进度
                  </div>
                  {item.is_watched === 1 && (
                    <div
                      className={styles["completed-button"]}
                      onClick={() => {
                        goPlay(item);
                      }}
                    >
                      学习完成
                    </div>
                  )}
                  {item.is_watched !== 1 && (
                    <div
                      className={styles["continue-button"]}
                      onClick={() => {
                        goPlay(item);
                      }}
                    >
                      继续学习
                    </div>
                  )}
                </div>
              )}
            </div>
          ))}
        {currentStatus === 2 &&
          list.map((item: any) => (
            <div className={styles["item-box"]} key={item.id + "course-sub"}>
              {item.course && item.course.id && (
                <div className={styles["item"]}>
                  <div className={styles["left-item"]}>
                    <ThumbBar
                      value={item.course.thumb}
                      border={4}
                      width={160}
                      height={120}
                    ></ThumbBar>
                    <div className={styles["icon"]}>已购买</div>
                  </div>
                  <div className={styles["right-item"]}>
                    <div className={styles["item-title"]}>
                      {item.course.title}
                    </div>
                    <div className={styles["item-info"]}>
                      <div className={styles["item-text"]}>
                        已学完：<span>{item.learned_count}课时</span> / 共
                        {item.course.videos_count}课时
                      </div>
                    </div>
                  </div>
                  <div
                    className={styles["detail-button"]}
                    onClick={() => {
                      setCid(item.course_id);
                      setVisiable(true);
                    }}
                  >
                    学习进度
                  </div>
                  <div
                    className={styles["continue-button"]}
                    onClick={() => {
                      goDetail(item.course_id);
                    }}
                  >
                    课程目录
                  </div>
                </div>
              )}
            </div>
          ))}
        {currentStatus === 3 &&
          list.map((item: any) => (
            <div
              className={styles["item-box"]}
              key={item.id + "course-collect"}
            >
              {item.course && item.course.id && (
                <div className={styles["item"]}>
                  <div className={styles["left-item"]}>
                    <ThumbBar
                      value={item.course.thumb}
                      border={4}
                      width={160}
                      height={120}
                    ></ThumbBar>
                  </div>
                  <div className={styles["right-item"]}>
                    <div className={styles["item-title"]}>
                      {item.course.title}
                    </div>
                    <div className={styles["item-info"]}>
                      <div className={styles["item-text"]}>
                        已学完：<span>{item.learned_count}课时</span> / 共
                        {item.course.videos_count}课时
                      </div>
                      {item.created_at && (
                        <div className={styles["item-text"]}>
                          收藏时间：{dateFormat(item.created_at)}
                        </div>
                      )}
                    </div>
                  </div>
                  <div
                    className={styles["continue-button"]}
                    onClick={() => {
                      goDetail(item.course_id);
                    }}
                  >
                    详情
                  </div>
                </div>
              )}
            </div>
          ))}
      </div>
    </>
  );
};
