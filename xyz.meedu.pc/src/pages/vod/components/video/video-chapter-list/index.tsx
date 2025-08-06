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
  const [expandedChapters, setExpandedChapters] = useState<{[key: number]: boolean}>({});

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

  useEffect(() => {
    // 默认展开包含当前视频的章节
    if (video && video.chapter_id && chapters.length > 0) {
      const currentChapterId = parseInt(video.chapter_id);
      if (currentChapterId > 0) {
        setExpandedChapters(prev => ({
          ...prev,
          [currentChapterId]: true
        }));
      } else {
        // 如果没有章节，展开"无章节内容"
        setExpandedChapters(prev => ({
          ...prev,
          0: true
        }));
      }
    }
  }, [video, chapters]);

  const checkHeight = (ref: any) => {
    let selItem = ref.current;
    if (selItem) {
      let pos = selItem.offsetTop - 289;
      if (pos > 0) {
        let box = document.querySelector(".course-chapter-box") as HTMLElement;
        box.scrollTop = pos;
      }
    }
  };

  const handler = () => checkHeight(myRef);

  const toggleChapter = (chapterId: number) => {
    setExpandedChapters(prev => ({
      ...prev,
      [chapterId]: !prev[chapterId]
    }));
  };

  const isChapterExpanded = (chapterId: number) => {
    return expandedChapters[chapterId] || false;
  };

  return (
    <div>
      {chapters.map((chapter: any) => (
        <div key={chapter.id} className={styles["chapter-item"]}>
          <div 
            className={styles["chapter-name"]} 
            onClick={() => toggleChapter(chapter.id)}
            style={{ cursor: "pointer" }}
          >
            {chapter.title}
            <span className={styles["expand-icon"]}>
              {isChapterExpanded(chapter.id) ? "-" : "+"}
            </span>
          </div>
          {isChapterExpanded(chapter.id) && (
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
          )}
        </div>
      ))}
      {videos[0] && videos[0].length > 0 && (
        <div className={styles["chapter-item"]}>
          <div 
            className={styles["chapter-name"]} 
            onClick={() => toggleChapter(0)}
            style={{ cursor: "pointer" }}
          >
            无章节内容
            <span className={styles["expand-icon"]}>
              {isChapterExpanded(0) ? "-" : "+"}
            </span>
          </div>
          {isChapterExpanded(0) && (
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
          )}
        </div>
      )}
    </div>
  );
};
