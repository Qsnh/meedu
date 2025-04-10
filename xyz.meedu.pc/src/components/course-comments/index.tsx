import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Input, Button, message } from "antd";
import { useNavigate } from "react-router-dom";
import { useSelector } from "react-redux";
import { Empty } from "../../components";
import { comment } from "../../api/index";
import { getCommentTime } from "../../utils/index";
import defaultAvatar from "../../assets/img/commen/default-avatar.jpg";

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
  const navigate = useNavigate();
  const user = useSelector((state: any) => state.loginUser.value.user);
  const isLogin = useSelector((state: any) => state.loginUser.value.isLogin);

  const [content, setContent] = useState("");
  const [reply, setReply] = useState("");
  const [loading, setLoading] = useState(false);
  const [replyLoading, setReplyLoading] = useState(false);
  const [total, setTotal] = useState(0);
  const [comments, setComments] = useState<any[]>([]);
  const [commentLoading, setCommentLoading] = useState(false);
  const [showMore, setShowMore] = useState(true);
  const [hideChild, setHideChild] = useState<any>({});
  const [showReply, setShowReply] = useState<any>({});
  const [moreLoading, setMoreLoading] = useState(false);
  const [moreLoading2, setMoreLoading2] = useState(false);

  useEffect(() => {
    setShowMore(true);
    setHideChild({});
    setShowReply({});
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

  const submitComment = (pid: number, replyId: number) => {
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
        parent_id: pid,
        reply_id: replyId,
      })
      .then((res: any) => {
        message.success("成功");
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
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const submitReply = (pid: number, replyId: number) => {
    if (replyLoading) {
      return;
    }
    if (reply === "") {
      return;
    }
    setReplyLoading(true);
    comment
      .submitComment({
        rt: rt,
        rid: rid,
        content: reply,
        parent_id: pid,
        reply_id: replyId,
      })
      .then((res: any) => {
        message.success("成功");
        setReplyLoading(false);
        setReply("");
        let box = [...comments];
        let index = box.findIndex((i: any) => i.id === pid);
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
      })
      .catch((e) => {
        setReplyLoading(false);
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

  return (
    <div className={styles["course-comments-box"]}>
      <div className={styles["comment-divider"]}>全部评论</div>
      <div className={styles["line"]}></div>

      {isLogin && isBuy && isAllowComment === 1 && (
        <div className={styles["replybox"]}>
          <div className={styles["reply"]}>
            <img className={styles["user-avatar"]} src={user.avatar} />
            <Input
              value={content}
              onChange={(e) => {
                setContent(e.target.value);
              }}
              style={{ width: 960, height: 48, marginRight: 30, fontSize: 16 }}
              placeholder="此处填写你的评论"
            ></Input>
            <Button
              type="primary"
              disabled={content.length === 0}
              style={{ width: 72, height: 48, fontSize: 16, border: "none" }}
              onClick={() => {
                submitComment(0, 0);
              }}
              loading={loading}
            >
              评论
            </Button>
          </div>
        </div>
      )}

      <div className={styles["comment-top"]}>
        {comments.length === 0 && <Empty></Empty>}
        {comments.length > 0 &&
          comments.map((item: any) => (
            <div key={item.id} className={styles["comment-item"]}>
              <div className={styles["user-avatar"]}>
                <img src={item.user ? item.user.avatar : defaultAvatar} />
              </div>
              <div className={styles["comment-content"]}>
                <div className={styles["comment-info"]}>
                  <div className={styles["nickname"]}>
                    {item.user ? item.user.nick_name : "学员已注销"}
                  </div>
                  <div className={styles["comment-time"]}>
                    {item.ip_province ? "| " + item.ip_province : ""}
                  </div>
                </div>
                {item.is_check === 0 ? (
                  <div className={styles["comment-text-sp"]}>评论审核中</div>
                ) : (
                  <div
                    className={styles["comment-text"]}
                    dangerouslySetInnerHTML={{ __html: item.content }}
                  ></div>
                )}
                <div className={styles["comment-reply"]}>
                  <div className={styles["comment-time"]}>
                    {getCommentTime(item.created_at)}
                  </div>
                  {isLogin &&
                    isBuy &&
                    isAllowComment === 1 &&
                    item.is_check === 1 && (
                      <>
                        <div
                          className={styles["reply-button"]}
                          onClick={() => {
                            let box: any = {};
                            box[item.id] = true;
                            setShowReply(box);
                          }}
                        >
                          回复
                        </div>
                      </>
                    )}
                </div>
                {showReply[item.id] && (
                  <div className={styles["reply-box"]}>
                    <img className={styles["user-avatar"]} src={user.avatar} />
                    <Input
                      value={reply}
                      onChange={(e) => {
                        setReply(e.target.value);
                      }}
                      style={{
                        width: 882,
                        height: 48,
                        marginRight: 30,
                        fontSize: 16,
                      }}
                      placeholder="此处填写你的回复"
                    ></Input>
                    <Button
                      type="primary"
                      disabled={reply.length === 0}
                      style={{
                        width: 72,
                        height: 48,
                        fontSize: 16,
                        border: "none",
                      }}
                      onClick={() => {
                        submitReply(item.id, 0);
                      }}
                      loading={replyLoading}
                    >
                      回复
                    </Button>
                  </div>
                )}
                {item.replies.length > 0 && (
                  <div className={styles["reply-content"]}>
                    {item.replies.length > 0 &&
                      item.replies.map((it: any) => (
                        <div key={it.id} className={styles["reply-child"]}>
                          <div className={styles["user-avatar"]}>
                            <img
                              src={it.user ? it.user.avatar : defaultAvatar}
                            />
                          </div>
                          <div className={styles["child-content"]}>
                            <div className={styles["child-info"]}>
                              <div className={styles["nickname"]}>
                                {it.user ? it.user.nick_name : "学员已注销"}
                              </div>
                              <div className={styles["child-time"]}>
                                {it.ip_province ? "| " + it.ip_province : ""}
                                {it.reply_user
                                  ? ` 回复 ${it.reply_user.nick_name}:`
                                  : ""}
                              </div>
                            </div>
                            {it.is_check === 0 ? (
                              <div className={styles["child-text-sp"]}>
                                评论审核中
                              </div>
                            ) : (
                              <div
                                className={styles["child-text"]}
                                dangerouslySetInnerHTML={{
                                  __html: it.content,
                                }}
                              ></div>
                            )}
                            <div className={styles["child-reply"]}>
                              <div className={styles["child-time"]}>
                                {getCommentTime(it.created_at)}
                              </div>
                              {isLogin &&
                                isBuy &&
                                isAllowComment === 1 &&
                                it.is_check === 1 && (
                                  <div
                                    className={styles["child-reply-button"]}
                                    onClick={() => {
                                      let box: any = {};
                                      box[it.id] = true;
                                      setShowReply(box);
                                    }}
                                  >
                                    回复
                                  </div>
                                )}
                            </div>
                            {showReply[it.id] && (
                              <div className={styles["child-reply-box"]}>
                                <img
                                  className={styles["user-avatar"]}
                                  src={user.avatar}
                                />
                                <Input
                                  value={reply}
                                  onChange={(e) => {
                                    setReply(e.target.value);
                                  }}
                                  style={{
                                    width: 804,
                                    height: 48,
                                    marginRight: 30,
                                    fontSize: 16,
                                  }}
                                  placeholder="此处填写你的回复"
                                ></Input>
                                <Button
                                  type="primary"
                                  disabled={reply.length === 0}
                                  style={{
                                    width: 72,
                                    height: 48,
                                    fontSize: 16,
                                    border: "none",
                                  }}
                                  onClick={() => {
                                    submitReply(item.id, it.id);
                                  }}
                                  loading={replyLoading}
                                >
                                  回复
                                </Button>
                              </div>
                            )}
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
          <div className={styles["comment-more"]} onClick={() => getReplies(0)}>
            {moreLoading ? "加载中..." : `查看全部${total}条评论`}
          </div>
        )}
      </div>
    </div>
  );
};
