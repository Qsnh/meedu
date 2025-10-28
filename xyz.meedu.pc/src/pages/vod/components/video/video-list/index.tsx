import React, { useEffect, useRef } from "react";
import styles from "./index.module.scss";
import lockIcon from "../../../../../assets/img/commen/icon-lock.png";
import { DurationText } from "../../../../../components";

interface PropInterface {
  videos: any[];
  course: any;
  video: any;
  isBuy: boolean;
  buyVideos: any[];
  videoWatchedProgress: any;
  switchVideo: (item: any) => void;
}

export const VideoListComp: React.FC<PropInterface> = ({
  course,
  videos,
  video,
  isBuy,
  buyVideos,
  videoWatchedProgress,
  switchVideo,
}) => {
  const activeVideoRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    if (activeVideoRef.current) {
      activeVideoRef.current.scrollIntoView({
        behavior: 'smooth',
        block: 'nearest',
        inline: 'nearest'
      });
    }
  }, [video.id]);

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
            ref={item.id === video.id ? activeVideoRef : null}
            className={`${styles["video-item"]} ${
              item.id === video.id ? styles["active"] : ""
            }`}
            onClick={() => {
              if (video.id === item.id) {
                return;
              }
              switchVideo(item);
            }}
          >
            {!isBuy && course.is_free !== 1 && (
              <img className={styles["lock-icon"]} src={lockIcon} />
            )}
            <div className={styles["video-content"]}>
              <div className={styles["video-item-basic-info"]}>
                <div className={styles["video-title"]}>
                  <div className={styles["video-item-title"]}>{item.title}</div>
                </div>
              </div>
              <div className={styles["video-progress"]}>
                {isBuy === false &&
                  course.is_free !== 1 &&
                  item.free_seconds > 0 && (
                    <div className={styles["free"]}>试看</div>
                  )}
                <DurationText seconds={item.duration} />
                {getProgressText(item.id, item.duration) && (
                  <span style={{ paddingLeft: "8px" }}>
                    {getProgressText(item.id, item.duration)}
                  </span>
                )}
              </div>
            </div>
          </div>
        ))}
    </>
  );
};
