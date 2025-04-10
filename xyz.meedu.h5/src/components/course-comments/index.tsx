import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Input, Toast } from "antd-mobile";
import { useNavigate } from "react-router-dom";
import { useSelector } from "react-redux";
import { None } from "../../components";
import { comment } from "../../api/index";
import { changeTime } from "../..//utils";
import defaultAvatar from "../../assets/img/default_avatar.png";

interface PropInterface {
  rid: number;
  rt: number;
  isBuy: boolean;
  isAllowComment: number;
}

export const CourseComments: React.FC<PropInterface> = ({
  rid,
  rt,
  isBuy,
  isAllowComment,
}) => {
  const isLogin = useSelector((state: any) => state.loginUser.value.isLogin);
  const navigate = useNavigate();

  const [content, setContent] = useState("");
  const [loading, setLoading] = useState(false);
  const [total, setTotal] = useState(0);
  const [comments, setComments] = useState<any[]>([]);
  const [commentLoading, setCommentLoading] = useState(false);
  const [showMore, setShowMore] = useState(true);
  const [hideChild, setHideChild] = useState<any>({});
  const [showReply, setShowReply] = useState<any>({});
  const [moreLoading, setMoreLoading] = useState(false);
  const [moreLoading2, setMoreLoading2] = useState(false);
  const [placeholder, setPlaceholder] = useState("请输入评论内容");
  const [replyId, setReplyId] = useState(0);
  const [parentId, setParentId] = useState(0);

  useEffect(() => {
    setShowMore(true);
    setHideChild({});
    setShowReply({});
    setPlaceholder("请输入评论内容");
    setParentId(0);
    setReplyId(0);
    getComments();
  }, [rid]);

  const getComments = () => {
    if (commentLoading) {
      return;
    }
    setCommentLoading(true);
    comment
      .comments({
        rt: rt,
        rid: rid,
      })
      .then((res: any) => {
        setComments(res.data.data);
        setTotal(res.data.total);
        setCommentLoading(false);
      });
  };

  const submitComment = () => {
    if (!isLogin) {
      goLogin();
      return;
    }
    if (loading) {
      return;
    }
    if (content === "") {
      return;
    }
    setLoading(true);
    comment
      .submitComment({
        rt: rt,
        rid: rid,
        content: content,
        parent_id: parentId,
        reply_id: replyId,
      })
      .then((res: any) => {
        if (parentId === 0) {
          Toast.show("成功");
          setLoading(false);
          setContent("");
          let box = [...comments];
          box.unshift({
            is_check: 0,
            content: "评论审核中",
            id: res.data.id,
            ip_province: res.data.ip_province,
            created_at: res.data.created_at,
            reply_id: res.data.reply_id,
            parent_id: res.data.parent_id,
            user: res.data.user,
            replies: [],
          });
          setComments(box);
          setShowReply({});
          setPlaceholder("请输入评论内容");
          setParentId(0);
          setReplyId(0);
        } else {
          Toast.show("成功");
          setLoading(false);
          setContent("");
          let box = [...comments];
          let index = box.findIndex((i: any) => i.id === parentId);
          box[index].replies.unshift({
            is_check: 0,
            content: "评论审核中",
            id: res.data.id,
            ip_province: res.data.ip_province,
            created_at: res.data.created_at,
            reply_id: res.data.reply_id,
            parent_id: res.data.parent_id,
            user: res.data.user,
            reply_user: res.data.reply_user,
          });
          box[index].replies_count = (box[index].replies_count || 0) + 1;
          setComments(box);
          setShowReply({});
          setPlaceholder("请输入评论内容");
          setParentId(0);
          setReplyId(0);
        }
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const getReplies = (pid: number) => {
    if (moreLoading) {
      return;
    }
    setMoreLoading(true);
    comment
      .commentsReplies({
        rt: rt,
        rid: rid,
        parent_id: pid,
      })
      .then((res: any) => {
        let newComments = res.data.data;
        let box = [...comments];
        newComments.map((item: any) => {
          if (hideChild[item.id]) {
            let index = box.findIndex((i: any) => i.id === item.id);
            item.replies = box[index].replies;
          }
        });
        setComments(newComments);
        setMoreLoading(false);
        setShowMore(false);
      })
      .catch((e) => {
        setMoreLoading(false);
      });
  };

  const getChildReplies = (pid: number) => {
    if (moreLoading2) {
      return;
    }
    setMoreLoading2(true);
    comment
      .commentsReplies({
        rt: rt,
        rid: rid,
        parent_id: pid,
      })
      .then((res: any) => {
        let box = [...comments];
        let index = box.findIndex((i: any) => i.id === pid);
        box[index].replies = res.data.data;
        setComments(box);
        setMoreLoading2(false);
      })
      .catch((e) => {
        setMoreLoading2(false);
      });
  };

  const goLogin = () => {
    navigate(
      "/login?redirect=" +
        encodeURIComponent(window.location.pathname + window.location.search)
    );
  };

  return (
    <>
      <div className={styles["course-comments-box"]}>
        {comments.length > 0 ? (
          <>
            {comments.map((item: any) => (
              <div className={styles["comment-item"]} key={item.id}>
                <div className={styles["avatar"]}>
                  <img
                    src={item.user ? item.user.avatar : defaultAvatar}
                    width="32"
                    height="32"
                  />
                </div>
                <div className={styles["content"]}>
                  <div className={styles["nickname"]}>
                    {item.user ? item.user.nick_name : "学员已注销"}
                  </div>
                  <div className={styles["time"]}>
                    {changeTime(item.created_at)}
                    {item.ip_province ? " | " + item.ip_province : ""}
                  </div>
                  {item.is_check === 0 ? (
                    <div className={styles["text-sp"]}>评论审核中</div>
                  ) : (
                    <div className={styles["text"]}>
                      <div
                        dangerouslySetInnerHTML={{
                          __html: item.content,
                        }}
                      ></div>
                    </div>
                  )}
                  <div className={styles["comment-reply"]}>
                    {isBuy && isAllowComment === 1 && item.is_check === 1 && (
                      <>
                        <div
                          className={
                            showReply[item.id]
                              ? `${styles["reply-button"]} ${styles["active"]}`
                              : styles["reply-button"]
                          }
                          onClick={() => {
                            if (showReply[item.id]) {
                              setShowReply({});
                              setPlaceholder("请输入评论内容");
                              setParentId(0);
                              setReplyId(0);
                            } else {
                              if (item.user) {
                                let box: any = {};
                                box[item.id] = true;
                                setShowReply(box);
                                setPlaceholder(`回复${item.user.nick_name}`);
                                setParentId(item.id);
                                setReplyId(0);
                              }
                            }
                          }}
                        >
                          {showReply[item.id] ? "取消回复" : "回复"}
                        </div>
                      </>
                    )}
                  </div>
                  {item.replies.length > 0 && (
                    <div className={styles["reply-content"]}>
                      {item.replies.length > 0 &&
                        item.replies.map((it: any) => (
                          <div className={styles["reply-item"]} key={it.id}>
                            <div className={styles["avatar"]}>
                              <img
                                src={it.user ? it.user.avatar : defaultAvatar}
                                width="32"
                                height="32"
                              />
                            </div>
                            <div className={styles["content"]}>
                              <div className={styles["nickname"]}>
                                {it.user ? it.user.nick_name : "学员已注销"}
                                {it.reply_user
                                  ? ` 回复 ${it.reply_user.nick_name}:`
                                  : ""}
                              </div>
                              <div className={styles["time"]}>
                                {changeTime(it.created_at)}
                                {it.ip_province ? " | " + it.ip_province : ""}
                              </div>
                              {it.is_check === 0 ? (
                                <div className={styles["text-sp"]}>
                                  评论审核中
                                </div>
                              ) : (
                                <div className={styles["text"]}>
                                  <div
                                    dangerouslySetInnerHTML={{
                                      __html: it.content,
                                    }}
                                  ></div>
                                </div>
                              )}
                              <div className={styles["child-reply"]}>
                                {isBuy &&
                                  isAllowComment === 1 &&
                                  it.is_check === 1 && (
                                    <div
                                      className={
                                        showReply[it.id]
                                          ? `${styles["child-reply-button"]} ${styles["active"]}`
                                          : styles["child-reply-buttonn"]
                                      }
                                      onClick={() => {
                                        if (showReply[it.id]) {
                                          setShowReply({});
                                          setPlaceholder("请输入评论内容");
                                          setParentId(0);
                                          setReplyId(0);
                                        } else {
                                          if (item.user) {
                                            let box: any = {};
                                            box[it.id] = true;
                                            setShowReply(box);
                                            setPlaceholder(
                                              `回复${it.user.nick_name}`
                                            );
                                            setParentId(item.id);
                                            setReplyId(it.id);
                                          }
                                        }
                                      }}
                                    >
                                      {showReply[it.id] ? "取消回复" : "回复"}
                                    </div>
                                  )}
                              </div>
                            </div>
                          </div>
                        ))}
                      {!hideChild[item.id] &&
                        item.replies_count > item.replies.length && (
                          <div
                            className={styles["reply-more"]}
                            onClick={() => {
                              let box: any = { ...hideChild };
                              box[item.id] = true;
                              setHideChild(box);
                              getChildReplies(item.id);
                            }}
                          >
                            查看全部{item.replies_count}条回复
                          </div>
                        )}
                    </div>
                  )}
                </div>
              </div>
            ))}
            {showMore && total > comments.length && (
              <div
                className={styles["comment-more"]}
                onClick={() => getReplies(0)}
              >
                {moreLoading ? "加载中..." : `查看全部${total}条评论`}
              </div>
            )}
          </>
        ) : (
          <None type="white" />
        )}
      </div>
      {isLogin && (
        <div className={`${styles["bottom-bar"]} safe-area-bottom`}>
          {isBuy && isAllowComment === 1 && (
            <>
              <Input
                className={styles["input"]}
                placeholder={placeholder}
                value={content}
                onChange={(e: any) => {
                  setContent(e);
                }}
              />
              <div
                className={
                  content.length > 0
                    ? `${styles["comment-button"]} ${styles["active"]}`
                    : styles["comment-button"]
                }
                onClick={() => submitComment()}
              >
                发布
              </div>
            </>
          )}
        </div>
      )}
    </>
  );
};
