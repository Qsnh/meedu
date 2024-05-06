import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import lockIcon from "../../../../../assets/img/commen/icon-lock.png";

interface PropInterface {
  videos: any[];
  course: any;
  video: any;
  isBuy: boolean;
  buyVideos: any[];
  switchVideo: (item: any) => void;
}

export const VideoListComp: React.FC<PropInterface> = ({
  course,
  videos,
  video,
  isBuy,
  buyVideos,
  switchVideo,
}) => {
  return (
    <>
      {videos.length > 0 &&
        videos.map((item: any) => (
          <div
            key={item.id}
            className={styles["video-item"]}
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
    </>
  );
};
