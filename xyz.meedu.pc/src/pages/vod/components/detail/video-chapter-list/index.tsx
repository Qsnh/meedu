import React from "react";
import styles from "./index.module.scss";
import { DurationText } from "../../../../../components";
import lockIcon from "../../../../../assets/img/commen/icon-lock.png";

interface PropInterface {
  videos: any;
  course: any;
  chapters: any[];
  isBuy: boolean;
  buyVideos: any[];
  videoWatchedProgress: any;
  switchVideo: (item: any) => void;
}

export const VideoChapterListComp: React.FC<PropInterface> = ({
  chapters,
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

  const renderVideoItem = (item: any) => (
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
  );

  return (
    <>
      {chapters.map((chapter: any) => (
        <div key={chapter.id} className={styles["chapter-item"]}>
          <div className={styles["chapter-name"]}>{chapter.title}</div>
          <div className={styles["chapter-videos-box"]}>
            {videos[chapter.id] &&
              videos[chapter.id].length > 0 &&
              videos[chapter.id].map(renderVideoItem)}
          </div>
        </div>
      ))}
      {videos[0] && videos[0].length > 0 && (
        <div className={styles["chapter-item"]}>
          <div className={styles["chapter-name"]}>无章节内容</div>
          <div className={styles["chapter-videos-box"]}>
            {videos[0].map(renderVideoItem)}
          </div>
        </div>
      )}
    </>
  );
};
