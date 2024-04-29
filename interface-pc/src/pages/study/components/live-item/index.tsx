import React, { useState } from "react";
import styles from "./index.module.scss";
import { ThumbBar } from "../../../../components/thumb-bar";
import { useNavigate } from "react-router-dom";
import { dateFormat } from "../../../../utils/index";

interface PropInterface {
  list: any[];
  currentStatus: number;
}

export const LiveItemComp: React.FC<PropInterface> = ({
  list,
  currentStatus,
}) => {
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);

  const goPlay = (item: any) => {
    let vid = item.video_id;
    if (item.course && item.course.next_video.length !== 0) {
      vid = item.course.next_video.id;
    }
    navigate("/live/video/" + vid);
  };

  const goDetail = (id: number) => {
    let tab = currentStatus !== 3 ? 3 : 2;
    navigate("/live/detail/" + id + "?tab=" + tab);
  };

  return (
    <div className={styles["box"]}>
      {currentStatus === 1 &&
        list.map((item: any) => (
          <div className={styles["item-box"]} key={item.id + "live-learn"}>
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
                    <div className={styles["icon"]}>已订阅</div>
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
                    {item.course.status === 2 && (
                      <div className={styles["item-progress"]}>已结课</div>
                    )}
                    {item.course.next_video &&
                      item.course.next_video.length !== 0 && (
                        <div className={styles["item-progress"]}>
                          下节直播：{item.course.next_video.title}(
                          {dateFormat(item.course.next_video.published_at)})
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
                  观看直播
                </div>
              </div>
            )}
          </div>
        ))}
      {currentStatus === 2 &&
        list.map((item: any) => (
          <div className={styles["item-box"]} key={item.id + "live-sub"}>
            {item.course && item.course.id && (
              <div className={styles["item"]}>
                <div className={styles["left-item"]}>
                  <ThumbBar
                    value={item.course.thumb}
                    border={4}
                    width={160}
                    height={120}
                  ></ThumbBar>

                  <div className={styles["icon"]}>已订阅</div>
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
                    {item.course.status === 2 && (
                      <div className={styles["item-progress"]}>已结课</div>
                    )}
                    {item.course.next_video &&
                      item.course.next_video.length !== 0 && (
                        <div className={styles["item-progress"]}>
                          下节直播：{item.course.next_video.title}(
                          {dateFormat(item.course.next_video.published_at)})
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
                  直播排课
                </div>
              </div>
            )}
          </div>
        ))}
      {currentStatus === 3 &&
        list.map((item: any) => (
          <div key={item.id + "live-collect"} className={styles["item-box"]}>
            <div className={styles["item"]}>
              <div className={styles["left-item"]}>
                <ThumbBar
                  value={item.thumb}
                  border={4}
                  width={160}
                  height={120}
                ></ThumbBar>
              </div>
              <div className={styles["right-item"]}>
                <div className={styles["item-title"]}>{item.title}</div>
                <div className={styles["item-info"]}>
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
                  goDetail(item.id);
                }}
              >
                详情
              </div>
            </div>
          </div>
        ))}
    </div>
  );
};
