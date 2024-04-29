import React, { useState } from "react";
import styles from "./index.module.scss";
import { ThumbBar } from "../../../../components/thumb-bar";
import { useNavigate } from "react-router-dom";
import { dateFormat, changeTime } from "../../../../utils/index";

interface PropInterface {
  list: any[];
  currentStatus: number;
}

export const TopicItemComp: React.FC<PropInterface> = ({
  list,
  currentStatus,
}) => {
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);

  const goDetail = (item: any) => {
    navigate("/topic/detail/" + item.topic.id);
  };

  return (
    <div className={styles["box"]}>
      {currentStatus === 1 &&
        list.map((item: any) => (
          <div key={item.id + "topic-learn"} className={styles["item-box"]}>
            {item.topic && item.topic.id && (
              <div className={styles["item"]}>
                <div className={styles["left-item"]}>
                  <ThumbBar
                    value={item.topic.thumb}
                    border={4}
                    width={160}
                    height={120}
                  ></ThumbBar>
                  {item.is_subscribe === 1 && (
                    <div className={styles["icon"]}>已订阅</div>
                  )}
                </div>
                <div className={styles["right-item"]}>
                  <div className={styles["item-title"]}>{item.topic.title}</div>
                  <div className={styles["item-info"]}>
                    {item.created_at && (
                      <div className={styles["item-text"]}>
                        上次浏览：{changeTime(item.created_at)}
                      </div>
                    )}
                  </div>
                </div>
                <div
                  className={styles["continue-button"]}
                  onClick={() => {
                    goDetail(item);
                  }}
                >
                  立即查看
                </div>
              </div>
            )}
          </div>
        ))}
      {currentStatus === 2 &&
        list.map((item: any) => (
          <div key={item.id + "topic-sub"} className={styles["item-box"]}>
            {item.topic && item.topic.id && (
              <div className={styles["item"]}>
                <div className={styles["left-item"]}>
                  <ThumbBar
                    value={item.topic.thumb}
                    border={4}
                    width={160}
                    height={120}
                  ></ThumbBar>

                  <div className={styles["icon"]}>已订阅</div>
                </div>
                <div className={styles["right-item"]}>
                  <div className={styles["item-title"]}>{item.topic.title}</div>
                  <div className={styles["item-info"]}>
                    {item.created_at && (
                      <div className={styles["item-text"]}>
                        订阅时间：{dateFormat(item.created_at)}
                      </div>
                    )}
                  </div>
                </div>
                <div
                  className={styles["continue-button"]}
                  onClick={() => {
                    goDetail(item);
                  }}
                >
                  立即查看
                </div>
              </div>
            )}
          </div>
        ))}
      {currentStatus === 3 &&
        list.map((item: any) => (
          <div key={item.id + "topic-collect"} className={styles["item-box"]}>
            {item.topic && item.topic.id && (
              <div className={styles["item"]}>
                <div className={styles["left-item"]}>
                  <ThumbBar
                    value={item.topic.thumb}
                    border={4}
                    width={160}
                    height={120}
                  ></ThumbBar>
                </div>
                <div className={styles["right-item"]}>
                  <div className={styles["item-title"]}>{item.topic.title}</div>
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
                    goDetail(item);
                  }}
                >
                  立即查看
                </div>
              </div>
            )}
          </div>
        ))}
    </div>
  );
};
