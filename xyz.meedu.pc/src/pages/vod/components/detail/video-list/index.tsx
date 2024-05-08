import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Button, message } from "antd";
import { useNavigate } from "react-router-dom";
import { useSelector } from "react-redux";
import { DurationText } from "../../../../../components";
import lockIcon from "../../../../../assets/img/commen/icon-lock.png";

interface PropInterface {
  videos: any[];
  course: any;
  isBuy: boolean;
  buyVideos: any[];
  switchVideo: (item: any) => void;
}

export const VideoListComp: React.FC<PropInterface> = ({
  course,
  videos,
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
            onClick={() => switchVideo(item)}
          >
            {!isBuy && course.is_free !== 1 && (
              <img className={styles["play-icon"]} src={lockIcon} />
            )}
            <div className={styles["video-title"]}>
              <div className={styles["text"]}>{item.title}</div>
              {isBuy === false &&
                course.is_free !== 1 &&
                item.free_seconds > 0 && (
                  <div className={styles["free"]}>试看</div>
                )}
            </div>
            <div className={styles["video-duration"]}>
              <DurationText seconds={item.duration} />
            </div>
          </div>
        ))}
    </>
  );
};
