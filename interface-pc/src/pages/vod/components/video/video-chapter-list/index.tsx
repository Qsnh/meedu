import React, { useState, useEffect, useRef } from "react";
import styles from "./index.module.scss";
import lockIcon from "../../../../../assets/img/commen/icon-lock.png";

interface PropInterface {
  videos: any;
  course: any;
  video: any;
  chapters: any[];
  isBuy: boolean;
  buyVideos: any[];
  switchVideo: (item: any) => void;
}

export const VideoChapterListComp: React.FC<PropInterface> = ({
  chapters,
  course,
  video,
  videos,
  isBuy,
  buyVideos,
  switchVideo,
}) => {
  const myRef = useRef(null);
  useEffect(() => {
    // 自动锁定当前视频位置
    if (chapters.length > 0) {
      setTimeout(() => {
        window.addEventListener("scroll", handler, { passive: true });
      }, 200);
    }
    return () => {
      window.removeEventListener("scroll", handler);
    };
  }, [myRef, chapters]);

  const checkHeight = (ref: any) => {
    let selItem = ref.current;
    let pos = selItem.offsetTop - 289;
    if (pos > 0) {
      let box = document.querySelector(".course-chapter-box") as HTMLElement;
      box.scrollTop = pos;
    }
  };

  const handler = () => checkHeight(myRef);

  return (
    <div>
      {chapters.map((chapter: any) => (
        <div key={chapter.id} className={styles["chapter-item"]}>
          <div className={styles["chapter-name"]}>{chapter.title}</div>
          <div className={styles["chapter-videos-box"]}>
            {videos[chapter.id] &&
              videos[chapter.id].length > 0 &&
              videos[chapter.id].map((item: any) => (
                <div
                  key={item.id}
                  className={styles["video-item"]}
                  ref={video.id === item.id ? myRef : null}
                  onClick={() => {
                    if (video.id === item.id) {
                      return;
                    }
                    switchVideo(item);
                  }}
                >
                  {!isBuy && course.is_free !== 1 && (
                    <img className={styles["play-icon"]} src={lockIcon} />
                  )}
                  <div className={styles["video-title"]}>
                    {isBuy === false &&
                    course.is_free !== 1 &&
                    item.free_seconds > 0 ? (
                      <div
                        className={
                          item.id === video.id
                            ? styles["active-text"]
                            : styles["text"]
                        }
                      >
                        {item.title}
                      </div>
                    ) : (
                      <div
                        className={
                          item.id === video.id
                            ? styles["active-text2"]
                            : styles["text2"]
                        }
                      >
                        {item.title}
                      </div>
                    )}
                    {isBuy === false &&
                      course.is_free !== 1 &&
                      item.free_seconds > 0 && (
                        <div className={styles["free"]}>试看</div>
                      )}
                  </div>
                </div>
              ))}
          </div>
        </div>
      ))}
      {videos[0] && videos[0].length > 0 && (
        <div className={styles["chapter-item"]}>
          <div className={styles["chapter-name"]}>无章节内容</div>
          <div className={styles["chapter-videos-box"]}>
            {videos[0].map((item: any) => (
              <div
                key={item.id}
                className={styles["video-item"]}
                ref={video.id === item.id ? myRef : null}
                onClick={() => {
                  if (video.id === item.id) {
                    return;
                  }
                  switchVideo(item);
                }}
              >
                {!isBuy && course.is_free !== 1 && (
                  <img className={styles["play-icon"]} src={lockIcon} />
                )}
                <div className={styles["video-title"]}>
                  {isBuy === false &&
                  course.is_free !== 1 &&
                  item.free_seconds > 0 ? (
                    <div
                      className={
                        item.id === video.id
                          ? styles["active-text"]
                          : styles["text"]
                      }
                    >
                      {item.title}
                    </div>
                  ) : (
                    <div
                      className={
                        item.id === video.id
                          ? styles["active-text2"]
                          : styles["text2"]
                      }
                    >
                      {item.title}
                    </div>
                  )}
                  {isBuy === false &&
                    course.is_free !== 1 &&
                    item.free_seconds > 0 && (
                      <div className={styles["free"]}>试看</div>
                    )}
                </div>
              </div>
            ))}
          </div>
        </div>
      )}
    </div>
  );
};
