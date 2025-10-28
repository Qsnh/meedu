import React from "react";
import styles from "./index.module.scss";
import { DurationText } from "../../../../../components";
import lockIcon from "../../../../../assets/img/commen/icon-lock.png";

interface PropInterface {
  videos: any[];
  course: any;
  isBuy: boolean;
  buyVideos: any[];
  videoWatchedProgress: any;
  switchVideo: (item: any) => void;
}

export const VideoListComp: React.FC<PropInterface> = ({
  course,
  videos,
  isBuy,
  buyVideos,
  videoWatchedProgress,
  switchVideo,
}) => {
  const getProgressText = (videoId: number, duration: number) => {
    const progress = videoWatchedProgress?.[videoId];
    if (!progress || !progress.watch_seconds || !duration) return null;
    const percent = Math.floor((progress.watch_seconds / duration) * 100);
    return percent > 0 ? `已学 ${percent}%` : null;
  };

  return (
    <>
      {videos.length > 0 &&
        videos.map((item: any) => (
          <div
            key={item.id}
            className={styles["video-item"]}
            onClick={() => switchVideo(item)}
          >
            {!isBuy && course.is_free !== 1 && (
              <img className={styles["lock-icon"]} src={lockIcon} />
            )}
            <div className={styles["video-content"]}>
              <div className={styles["video-item-basic-info"]}>
                <div className={styles["video-title"]}>
                  <div className={styles["text"]}>{item.title}</div>
                </div>
                <div className={styles["video-duration"]}>
                  <DurationText seconds={item.duration} />
                </div>
              </div>
              {((isBuy === false &&
                course.is_free !== 1 &&
                item.free_seconds > 0) ||
                getProgressText(item.id, item.duration)) && (
                <div className={styles["video-progress-wrapper"]}>
                  {isBuy === false &&
                    course.is_free !== 1 &&
                    item.free_seconds > 0 && (
                      <div className={styles["free"]}>试看</div>
                    )}
                  {getProgressText(item.id, item.duration) && (
                    <div className={styles["video-progress"]}>
                      {getProgressText(item.id, item.duration)}
                    </div>
                  )}
                </div>
              )}
            </div>
          </div>
        ))}
    </>
  );
};
