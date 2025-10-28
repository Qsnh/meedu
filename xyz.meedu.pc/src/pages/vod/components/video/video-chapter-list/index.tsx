import React, { useEffect, useRef } from "react";
import styles from "./index.module.scss";
import lockIcon from "../../../../../assets/img/commen/icon-lock.png";
import { DurationText } from "../../../../../components";

interface PropInterface {
  videos: any;
  course: any;
  video: any;
  chapters: any[];
  isBuy: boolean;
  buyVideos: any[];
  videoWatchedProgress: any;
  switchVideo: (item: any) => void;
}

interface VideoItemProps {
  item: any;
  video: any;
  course: any;
  isBuy: boolean;
  videoWatchedProgress: any;
  myRef: React.RefObject<HTMLDivElement>;
  switchVideo: (item: any) => void;
  getProgressText: (videoId: number, duration: number) => string | null;
}

const VideoItem: React.FC<VideoItemProps> = ({
  item,
  video,
  course,
  isBuy,
  videoWatchedProgress,
  myRef,
  switchVideo,
  getProgressText,
}) => {
  return (
    <div
      key={item.id}
      ref={item.id === video.id ? myRef : null}
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
            <div className={styles["video-item-title"]}>
              {item.title}
            </div>
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
  );
};

export const VideoChapterListComp: React.FC<PropInterface> = ({
  chapters,
  course,
  video,
  videos,
  isBuy,
  buyVideos,
  videoWatchedProgress,
  switchVideo,
}) => {
  const myRef = useRef<HTMLDivElement>(null);

  const getProgressText = (videoId: number, duration: number) => {
    const progress = videoWatchedProgress?.[videoId];
    if (!progress || !progress.watch_seconds || !duration) return null;
    const percent = Math.floor((progress.watch_seconds / duration) * 100);
    return percent > 0 ? `已学 ${percent}%` : null;
  };

  useEffect(() => {
    if (myRef.current) {
      myRef.current.scrollIntoView({
        behavior: 'smooth',
        block: 'nearest',
        inline: 'nearest'
      });
    }
  }, [video.id]);

  return (
    <>
      {chapters.map((chapter: any) => (
        <div key={chapter.id} className={styles["chapter-item"]}>
          <div className={styles["chapter-name"]}>{chapter.title}</div>
          <div className={styles["chapter-videos-box"]}>
            {videos[chapter.id] &&
              videos[chapter.id].length > 0 &&
              videos[chapter.id].map((item: any) => (
                <VideoItem
                  key={item.id}
                  item={item}
                  video={video}
                  course={course}
                  isBuy={isBuy}
                  videoWatchedProgress={videoWatchedProgress}
                  myRef={myRef}
                  switchVideo={switchVideo}
                  getProgressText={getProgressText}
                />
              ))}
          </div>
        </div>
      ))}
      {videos[0] && videos[0].length > 0 && (
        <div className={styles["chapter-item"]}>
          <div className={styles["chapter-name"]}>无章节内容</div>
          <div className={styles["chapter-videos-box"]}>
            {videos[0].map((item: any) => (
              <VideoItem
                key={item.id}
                item={item}
                video={video}
                course={course}
                isBuy={isBuy}
                videoWatchedProgress={videoWatchedProgress}
                myRef={myRef}
                switchVideo={switchVideo}
                getProgressText={getProgressText}
              />
            ))}
          </div>
        </div>
      )}
    </>
  );
};
