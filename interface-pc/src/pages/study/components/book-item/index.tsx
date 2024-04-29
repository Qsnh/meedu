import React, { useState } from "react";
import styles from "./index.module.scss";
import { ThumbBar } from "../../../../components/thumb-bar";
import { useNavigate } from "react-router-dom";
import { dateFormat, changeTime } from "../../../../utils/index";

interface PropInterface {
  list: any[];
  currentStatus: number;
}

export const BookItemComp: React.FC<PropInterface> = ({
  list,
  currentStatus,
}) => {
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);

  const goRead = (item: any) => {
    navigate("/book/read/" + item.article_id);
  };

  const goDetail = (id: number) => {
    let tab = currentStatus === 2 ? 3 : 2;
    navigate("/book/detail/" + id + "?tab=" + tab);
  };

  return (
    <div className={styles["box"]}>
      {currentStatus === 1 &&
        list.map((item: any) => (
          <div key={item.id + "book-learn"} className={styles["item-box"]}>
            {item.book && item.book.id && (
              <div className={styles["item"]}>
                <div className={styles["left-item"]}>
                  <ThumbBar
                    value={item.book.thumb}
                    border={4}
                    width={90}
                    height={120}
                  ></ThumbBar>
                  {item.is_subscribe === 1 && (
                    <div className={styles["icon"]}>已订阅</div>
                  )}
                </div>
                <div className={styles["right-item"]}>
                  <div className={styles["item-title"]}>{item.book.name}</div>
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
                    goRead(item);
                  }}
                >
                  继续学习
                </div>
              </div>
            )}
          </div>
        ))}
      {currentStatus === 2 &&
        list.map((item: any) => (
          <div key={item.id + "book-sub"} className={styles["item-box"]}>
            {item.book && item.book.id && (
              <div className={styles["item"]}>
                <div className={styles["left-item"]}>
                  <ThumbBar
                    value={item.book.thumb}
                    border={4}
                    width={90}
                    height={120}
                  ></ThumbBar>

                  <div className={styles["icon"]}>已订阅</div>
                </div>
                <div className={styles["right-item"]}>
                  <div className={styles["item-title"]}>{item.book.name}</div>
                  <div className={styles["item-info"]}>
                    {item.last_view &&
                    item.last_view.length === 0 &&
                    item.created_at ? (
                      <div className={styles["item-text"]}>
                        订阅时间：{dateFormat(item.created_at)}
                      </div>
                    ) : (
                      <div className={styles["item-text"]}>
                        上次浏览：{changeTime(item.created_at)}
                      </div>
                    )}
                  </div>
                </div>
                <div
                  className={styles["continue-button"]}
                  onClick={() => {
                    goDetail(item.book_id);
                  }}
                >
                  章节目录
                </div>
              </div>
            )}
          </div>
        ))}
      {currentStatus === 3 &&
        list.map((item: any) => (
          <div key={item.id + "book-collect"} className={styles["item-box"]}>
            <div className={styles["item"]}>
              <div className={styles["left-item"]}>
                <ThumbBar
                  value={item.thumb}
                  border={4}
                  width={90}
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
