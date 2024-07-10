import { useState, useEffect } from "react";
import { course } from "../../../../api";
import { useSelector } from "react-redux";
import { Input, Toast } from "antd-mobile";
import styles from "./index.module.scss";
import { useNavigate } from "react-router-dom";
import { DurationText, None } from "../../../../components";
import AttachBox from "../attach-box";
import { changeTime } from "../../../../utils";
import backIcon from "../../../../assets/img/icon-back.png";
import collectActive from "../../../../assets/img/collect-active.png";
import collect from "../../../../assets/img/collect.png";

interface PropsInterafce {
  id: number;
  data: CourseResponseInterface;
}

interface CourseResponseInterface {
  attach: any[];
  buyVideos: any[];
  course: CourseDetailInterface;
  isBuy: boolean;
  isCollect: boolean;
  videoWatchedProgress: any[];
  chapters: CourseDetailChapterInterface[];
  videos: CourseDetailVideosInterface;
}

interface KeysInterafce {
  [key: number]: boolean;
}

export default function TabsComponent(props: PropsInterafce) {
  const navigate = useNavigate();
  const isLogin = useSelector((state: any) => state.loginUser.value.isLogin);
  const [comments, setComments] = useState<any>([]);
  const [commentUsers, setCommentUsers] = useState<any>({});
  const [content, setContent] = useState("");
  const [configkey, setConfigkey] = useState<KeysInterafce>({});
  const [currentTab, setCurrentTab] = useState(0);
  const [isCollect, setIsCollect] = useState(props.data.isCollect);
  const tabs = [
    {
      name: "介绍",
      key: "desc",
      id: 0,
    },
    {
      name: "目录",
      key: "chapter",
      id: 1,
    },
    {
      name: "评论",
      key: "comment",
      id: 2,
    },
    {
      name: "课件",
      key: "attach",
      id: 3,
    },
  ];

  useEffect(() => {
    var box = props.data.chapters;
    var sel: any = {};
    for (var i = 0; i < box.length; i++) {
      sel[i] = true;
    }
    setConfigkey(sel);
  }, [props.data]);

  useEffect(() => {
    if (props.id) {
      getCourseComments();
    }
  }, [props.id]);

  const goLogin = () => {
    navigate(
      "/login?redirect=" +
        encodeURIComponent(window.location.pathname + window.location.search)
    );
  };

  const startLearn = () => {
    if (!isLogin) {
      goLogin();
      return;
    }
    let video = null;
    if (props.data.chapters.length === 0) {
      video = props.data.videos[0][0];
    } else {
      video = props.data.videos[props.data.chapters[0].id][0];
    }
    navigate("/vod/video?id=" + video.id);
  };

  const likeHit = () => {
    if (isLogin) {
      course.CourseLikeHit(props.id).then((res) => {
        setIsCollect(!isCollect);
      });
    } else {
      goLogin();
    }
  };

  const goRole = () => {
    if (!isLogin) {
      goLogin();
      return;
    }
    navigate("/role");
  };

  const buyCourse = () => {
    if (!isLogin) {
      goLogin();
      return;
    }
    navigate(
      `/order?goods_id=${props.data.course.id}&goods_name=${props.data.course.title}&goods_label=点播课程&goods_charge=${props.data.course.charge}&goods_type=vod&goods_thumb=${props.data.course.thumb}`
    );
  };

  const submitComment = () => {
    if (!isLogin) {
      goLogin();
      return;
    }
    if (content === "") {
      return;
    }
    if (content.length < 6) {
      Toast.show("评论内容不能少于6个字");
      return;
    }
    course.SubmitComment(props.id, { content: content }).then(() => {
      Toast.show("成功");
      setContent("");
      getCourseComments();
    });
  };

  const getCourseComments = () => {
    course.Comments(props.id).then((res: any) => {
      setComments(res.data.comments);
      setCommentUsers(res.data.users);
    });
  };

  const goVideo = (video: any) => {
    if (!isLogin) {
      goLogin();
      return;
    }
    navigate("/vod/video?id=" + video.id);
  };

  return (
    <>
      <div className={styles["body"]}>
        <div className={styles["tabs"]}>
          {tabs.map((item: any, index: number) => (
            <div
              key={index}
              className={
                currentTab === item.id
                  ? `${styles["item-tab"]} ${styles["active"]}`
                  : styles["item-tab"]
              }
              onClick={() => setCurrentTab(item.id)}
            >
              {item.name}
              {currentTab === item.id && (
                <div className={styles["actline"]}></div>
              )}
            </div>
          ))}
        </div>
        {currentTab === 0 && (
          <div className={styles["coursr-desc"]}>
            <div
              className={styles["desc"]}
              style={{ fontSize: 14 }}
              dangerouslySetInnerHTML={{
                __html: props.data.course.render_desc.replace(
                  /<img/g,
                  "<img style='width:100%;height:auto;'"
                ),
              }}
            ></div>
          </div>
        )}
        {currentTab === 1 && (
          <div className={styles["course-chapter-box"]}>
            {props.data.chapters.length > 0 ? (
              <>
                {props.data.chapters.map((chapter: any, index: number) => (
                  <div className={styles["chapter-item"]} key={chapter.id}>
                    <div
                      className={styles["chapter-name"]}
                      onClick={() => {
                        let box = { ...configkey };
                        box[index] = !box[index];
                        setConfigkey(box);
                      }}
                    >
                      {chapter.title}
                      <img
                        width="15"
                        height="15"
                        style={{ float: "right" }}
                        className={
                          configkey[index] === true
                            ? `${styles["normaltran"]} ${styles["trans"]}`
                            : styles["normaltran"]
                        }
                        src={backIcon}
                      />
                    </div>
                    {configkey[index] && (
                      <div className={styles["chapter-videos-box"]}>
                        {props.data.videos[chapter.id] &&
                          props.data.videos[chapter.id].map((video: any) => (
                            <div
                              className={styles["video-item"]}
                              key={video.id}
                              onClick={() => goVideo(video)}
                            >
                              <div className={styles["video-title"]}>
                                {props.data.course.is_free !== 1 &&
                                  video.free_seconds > 0 && (
                                    <span className={styles["free"]}>试看</span>
                                  )}
                                <span className={styles["text"]}>
                                  {video.title}
                                </span>
                              </div>
                              <div className={styles["video-duration"]}>
                                <DurationText seconds={video.duration} />
                              </div>
                            </div>
                          ))}
                      </div>
                    )}
                  </div>
                ))}
                {props.data.videos[0] && props.data.videos[0].length > 0 && (
                  <div className={styles["chapter-item"]}>
                    <div className={styles["chapter-name"]}>无章节内容</div>
                    <div className={styles["chapter-videos-box"]}>
                      {props.data.videos[0].map((video: any) => (
                        <div
                          className={styles["video-item"]}
                          key={video.id}
                          onClick={() => goVideo(video)}
                        >
                          <div className={styles["video-title"]}>
                            {props.data.course.is_free !== 1 &&
                              video.free_seconds > 0 && (
                                <span className={styles["free"]}>试看</span>
                              )}
                            <span className={styles["text"]}>
                              {video.title}
                            </span>
                          </div>
                          <div className={styles["video-duration"]}>
                            <DurationText seconds={video.duration} />
                          </div>
                        </div>
                      ))}
                    </div>
                  </div>
                )}
              </>
            ) : (
              <>
                {props.data.videos[0] &&
                  props.data.videos[0].length > 0 &&
                  props.data.videos[0].map((video: any) => (
                    <div
                      className={styles["video-item"]}
                      key={video.id}
                      onClick={() => goVideo(video)}
                    >
                      <div className={styles["video-title"]}>
                        {props.data.course.is_free !== 1 &&
                          video.free_seconds > 0 && (
                            <span className={styles["free"]}>试看</span>
                          )}
                        <span className={styles["text"]}>{video.title}</span>
                      </div>
                      <div className={styles["video-duration"]}>
                        <DurationText seconds={video.duration} />
                      </div>
                    </div>
                  ))}
              </>
            )}
          </div>
        )}
        {currentTab === 2 && (
          <div className={styles["course-comments-box"]}>
            {comments.length > 0 ? (
              <>
                {comments.map((comment: any) => (
                  <div className={styles["comment-item"]} key={comment.id}>
                    <div className={styles["avatar"]}>
                      <img
                        src={commentUsers[comment.user_id].avatar}
                        width="32"
                        height="32"
                      />
                    </div>
                    <div className={styles["content"]}>
                      <div className={styles["nickname"]}>
                        {commentUsers[comment.user_id].nick_name}
                      </div>
                      <div className={styles["time"]}>
                        {changeTime(comment.created_at)}
                      </div>
                      <div className={styles["text"]}>
                        <div
                          dangerouslySetInnerHTML={{
                            __html: comment.render_content,
                          }}
                        ></div>
                      </div>
                    </div>
                  </div>
                ))}
              </>
            ) : (
              <None type="white" />
            )}
          </div>
        )}
        {currentTab === 3 && (
          <AttachBox
            cid={props.id}
            list={props.data.attach}
            isBuy={props.data.isBuy}
          />
        )}
      </div>
      {currentTab !== 3 && (
        <div className={styles["bottom-bar"]}>
          {currentTab === 0 || currentTab === 1 ? (
            <>
              <div
                className={
                  isCollect
                    ? `${styles["collect-button"]} ${styles["active"]}`
                    : styles["collect-button"]
                }
              >
                <div className={styles["icon"]}>
                  {isCollect ? (
                    <img
                      className={styles["like-icon"]}
                      onClick={() => {
                        likeHit();
                      }}
                      width="24"
                      height="24"
                      src={collectActive}
                    />
                  ) : (
                    <img
                      className={styles["like-icon"]}
                      onClick={() => {
                        likeHit();
                      }}
                      width="24"
                      height="24"
                      src={collect}
                    />
                  )}
                </div>
                <div className={styles["text"]}>收藏</div>
              </div>
              {props.data.isBuy || props.data.course.is_free === 1 ? (
                <div
                  className={`${styles["button-item"]} ${styles["see-button"]}`}
                  onClick={() => startLearn()}
                >
                  <span>开始学习</span>
                </div>
              ) : (
                <>
                  {props.data.course.charge > 0 ? (
                    <>
                      <div
                        className={`${styles["button-item"]} ${styles["role-button"]}`}
                        onClick={() => goRole()}
                      >
                        <span>VIP会员免费看</span>
                      </div>
                      <div
                        className={`${styles["button-item"]} ${styles["buy-button"]}`}
                        onClick={() => buyCourse()}
                      >
                        <span>订阅课程</span>
                      </div>
                    </>
                  ) : (
                    <div
                      className={`${styles["button-item"]} ${styles["role-button2"]}`}
                      onClick={() => goRole()}
                    >
                      <span>VIP会员免费看</span>
                    </div>
                  )}
                </>
              )}
            </>
          ) : (
            <>
              <Input
                className={styles["input"]}
                placeholder="请输入评论内容"
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
}
