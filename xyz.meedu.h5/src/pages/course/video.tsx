import { useEffect, useRef, useState } from "react";
import styles from "./video.module.scss";
import NavHeader from "../../components/nav-header";
import { useParams, useNavigate } from "react-router-dom";
import { useSelector } from "react-redux";
import { course as Course } from "../../api/index";
import { Toast, SpinLoading } from "antd-mobile";
import { DurationText, CourseComments } from "../../components";
import AttachBox from "./compenents/attach-box";
import backIcon from "../../assets/img/icon-back.png";
import playIcon from "../../assets/img/play.gif";
import wechatShare from "../../js/wechat-share";
import { RootState } from "../../store";
import { AppConfigInterface } from "../../store/system/systemConfigSlice";

declare const window: any;

interface KeysInterafce {
  [key: number]: boolean;
}

const CoursePlayPage = () => {
  const navigate = useNavigate();
  const params: any = useParams();
  const [loading, setLoading] = useState<boolean>(true);
  const [course, setCourse] = useState<any>(null);
  const [video, setVideo] = useState<any>(null);
  const [videos, setVideos] = useState<any>([]);
  const [chapters, setChapters] = useState<any>([]);
  const [isWatch, setIsWatch] = useState<boolean>(false);
  const [isLastpage, setIsLastpage] = useState<boolean>(false);
  const [lastVideoId, setLastVideoId] = useState<number>(0);
  const [configkey, setConfigkey] = useState<KeysInterafce>({});
  const [expandedChapters, setExpandedChapters] = useState<{[key: number]: boolean}>({});
  const [nowChapter, setNowChapter] = useState<any>(null);
  const [attachs, setAttachs] = useState<any>([]);
  const [showTry, setShowTry] = useState<boolean>(false);
  const [isBuy, setIsBuy] = useState<boolean>(false);
  const [lastSeeValue, setLastSeeValue] = useState<any>(null);
  const [playUrl, setPlayUrl] = useState<string>("");
  const [isIframe, setIsIframe] = useState<boolean>(false);
  const [playendedStatus, setPlayendedStatus] = useState<boolean>(false);
  const [playDuration, setPlayDuration] = useState(0);
  const [currentTab, setCurrentTab] = useState(0);
  const user = useSelector((state: RootState) => state.loginUser.value.user);
  const config: AppConfigInterface = useSelector(
    (state: RootState) => state.systemConfig.value
  );
  const isLogin = useSelector(
    (state: RootState) => state.loginUser.value.isLogin
  );
  const myRef = useRef(0);

  const tabs = [
    {
      name: "目录",
      key: "chapter",
      id: 0,
    },
    {
      name: "评论",
      key: "comment",
      id: 1,
    },
    {
      name: "课件",
      key: "attach",
      id: 3,
    },
  ];

  useEffect(() => {
    window.player && window.player.destroy();
    myRef.current = 0;
    setPlayDuration(0);
    setLastSeeValue(null);
    setPlayendedStatus(false);
    setLoading(true);
    getVideo();
  }, [params.videoId, isLogin, user]);

  useEffect(() => {
    myRef.current = playDuration;
  }, [playDuration]);

  const getVideo = () => {
    Course.Video(Number(params.videoId))
      .then((res: any) => {
        setVideo(res.data.video);
        setCourse(res.data.course);
        setVideos(res.data.videos);
        setIsWatch(res.data.is_watch);
        setChapters(res.data.chapters);
        document.title = res.data.video.title;
        let chapteId = parseInt(res.data.video.chapter_id) || 0;
        let videoBox: any = [];
        for (let key in res.data.videos) {
          videoBox = videoBox.concat(res.data.videos[key]);
        }
        for (var j = 0; j < videoBox.length; j++) {
          if (res.data.video.id === videoBox[j].id) {
            if (1 + j >= videoBox.length) {
              setIsLastpage(true);
            } else {
              setIsLastpage(false);
              setLastVideoId(videoBox[j + 1].id);
            }
          }
        }

        let box = res.data.chapters;
        var sel: any = {};
        const newExpandedChapters: {[key: number]: boolean} = {};
        
        for (var i = 0; i < box.length; i++) {
          if (chapteId == box[i].id) {
            setNowChapter(box[i]);
            sel[i] = true;
            newExpandedChapters[box[i].id] = true;
          }
        }
        setConfigkey(sel);
        setExpandedChapters(prev => ({...prev, ...newExpandedChapters}));
        //播放记录跳转
        let last_see_value = null;
        if (
          res.data.video_watched_progress &&
          res.data.video_watched_progress[Number(params.videoId)] &&
          res.data.video_watched_progress[Number(params.videoId)]
            .watch_seconds > 0
        ) {
          last_see_value = {
            time: 5,
            pos: res.data.video_watched_progress[Number(params.videoId)]
              .watch_seconds,
          };
          setLastSeeValue(last_see_value);
        }
        // 当前用户已购买 || 可以试看
        if (res.data.is_watch || res.data.video.free_seconds > 0) {
          getPlayInfo(
            res.data.is_watch,
            res.data.video.free_seconds,
            res.data.video.ban_drag,
            last_see_value,
            res.data.course
          );
        }

        //获取附件
        getAttach(res.data.course.id);
        setLoading(false);
        // 微信H5分享
        wechatShare.methods.wechatH5Share(
          res.data.course.title,
          res.data.course.short_description,
          res.data.course.thumb,
          isLogin ? user?.id || 0 : 0
        );
      })
      .catch((e) => {
        setLoading(false);
        navigate(-1);
      });
  };

  const getPlayInfo = (
    active: boolean,
    free_seconds: number,
    ban_drag: number,
    last_see_value: any,
    course: any
  ) => {
    let isTrySee = 0;
    if (active === false && free_seconds > 0) {
      isTrySee = 1;
    }
    Course.PlayInfo(Number(params.videoId), { is_try: isTrySee }).then(
      (res: any) => {
        if (res.data.urls.length === 0) {
          Toast.show("无播放地址");
          return;
        }

        let playUrls = res.data.urls;
        let firstPlayUrl = playUrls[0].url;

        if (firstPlayUrl.substr(1, 6) === "iframe") {
          setIsIframe(true);
          let playUrl = firstPlayUrl.replace(
            ">",
            ' style="width:100%;height:506px" >'
          );
          setPlayUrl(playUrl);
          return;
        }
        setIsIframe(false);
        initDPlayer(playUrls, isTrySee, ban_drag, last_see_value, course);
      }
    );
  };

  const initDPlayer = (
    playUrls: any,
    isTrySee: number,
    ban_drag: number,
    lastSeeParams: any,
    course: any
  ) => {
    let dplayerUrls: any[] = [];
    playUrls.forEach((item: any) => {
      dplayerUrls.push({
        name: item.name,
        url: item.url,
      });
    });
    // 初始化播放器
    let bulletSecretFontSize = !config.player.bullet_secret.size
      ? 14
      : config.player.bullet_secret.size;
    window.player = new window.DPlayer({
      container: document.getElementById("meedu-player-container"),
      autoplay: false,
      video: {
        quality: dplayerUrls,
        defaultQuality: 0,
        pic: config.player.cover,
      },
      try: isTrySee === 1,
      bulletSecret: {
        enabled: parseInt(config.player.enabled_bullet_secret) === 1,
        text: config.player.bullet_secret.text
          .replace("${user.mobile}", user?.mobile || "")
          .replace("${mobile}", user?.mobile || "")
          .replace("${user.id}", user?.id?.toString() || ""),
        size: bulletSecretFontSize + "px",
        color: !config.player.bullet_secret.color
          ? "red"
          : config.player.bullet_secret.color,
        opacity: config.player.bullet_secret.opacity,
      },
      ban_drag: ban_drag === 1,
      last_see_pos: lastSeeParams,
    });

    // 监听播放进度更新evt
    window.player.on("timeupdate", () => {
      playTimeUpdate(parseInt(window.player.video.currentTime), false);
    });
    window.player.on("ended", () => {
      playTimeUpdate(parseInt(window.player.video.currentTime), true);
      setPlayendedStatus(true);
    });
    window.player.on("sub_course", () => {
      navigate(
        `/order?goods_id=${course.id}&goods_name=${course.title}&goods_label=录播课程&goods_charge=${course.charge}&goods_type=vod&goods_thumb=${course.thumb}`
      );
    });
    window.player.on("play_error", (e: any) => {
      console.log("视频播放错误,错误信息:", e);
    });
  };

  const playTimeUpdate = (duration: number, isEnd: boolean) => {
    if (duration - myRef.current >= 10 || isEnd === true) {
      setPlayDuration(duration);
      Course.VideoRecord(Number(params.videoId), {
        duration: duration,
      }).then((res: any) => {});
    }
  };

  const getAttach = (cid: number) => {
    Course.Detail(cid).then((res: any) => {
      setAttachs(res.data.attach);
      setIsBuy(res.data.isBuy);
      setShowTry(!res.data.isBuy);
    });
  };

  const buyCourse = () => {
    navigate(
      `/order?goods_id=${course.id}&goods_name=${course.title}&goods_label=录播课程&goods_charge=${course.charge}&goods_type=vod&goods_thumb=${course.thumb}`
    );
  };

  const goNextVideo = () => {
    setLastSeeValue(null);
    navigate("/course/video/" + lastVideoId, { replace: true });
  };

  const goVideo = (item: any) => {
    setLastSeeValue(null);
    navigate("/course/video/" + item.id, { replace: true });
  };

    const goRole = () => {
    navigate("/role");
  };

  const toggleChapter = (chapterId: number) => {
    setExpandedChapters(prev => ({
      ...prev,
      [chapterId]: !prev[chapterId]
    }));
  };

  const isChapterExpanded = (chapterId: number) => {
    return expandedChapters[chapterId] || false;
  };

  // 如果 video 没有值则显示loading
  if (!video) {
    return (
      <div
        style={{
          width: "100vw",
          height: "100vh",
          display: "flex",
          justifyContent: "center",
          alignItems: "center",
        }}
      >
        <SpinLoading color="primary" />
      </div>
    );
  }

  return (
    <>
      <div className={styles["box"]}>
        <NavHeader text="" />
        <div className={styles["play-box"]}>
          {!playendedStatus && (isWatch || video.free_seconds > 0) ? (
            <div className={styles["playing"]} v-if="">
              {isIframe ? (
                <div
                  className={styles["iframe-player-box"]}
                  dangerouslySetInnerHTML={{
                    __html: playUrl,
                  }}
                ></div>
              ) : (
                <div
                  className={styles["meedu-player-container"]}
                  id="meedu-player-container"
                ></div>
              )}
            </div>
          ) : (
            <>
              {isLogin ? (
                <div className={styles["alert-message"]}>
                  {playendedStatus && (
                    <>
                      {isWatch === false && video.free_seconds > 0 ? (
                        <div className={styles["subscribe-info"]}>
                          试看结束，购买课程观看所有视频
                        </div>
                      ) : !isLastpage ? (
                        <div
                          className={styles["next-page"]}
                          onClick={() => goNextVideo()}
                        >
                          下一节
                        </div>
                      ) : (
                        <div className={styles["last-video"]}>
                          恭喜您已经学完本套课程！
                        </div>
                      )}
                    </>
                  )}
                  {course.charge > 0 && isWatch === false && (
                    <div
                      className={styles["subscribe-button"]}
                      onClick={() => buyCourse()}
                    >
                      <span>购买课程 ￥{course.charge}</span>
                    </div>
                  )}
                </div>
              ) : (
                <div className={styles["alert-message"]}>请登录后观看</div>
              )}
            </>
          )}
        </div>
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
            <div className={styles["course-chapter-box"]}>
              {chapters.length > 0 ? (
                <>
                  {chapters.map((chapter: any, index: number) => (
                    <div className={styles["chapter-item"]} key={chapter.id}>
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
                            videos[chapter.id].map((videoItem: any) => (
                              <div
                                className={styles["video-item"]}
                                key={videoItem.id}
                                onClick={() => goVideo(videoItem)}
                              >
                                <div className={styles["video-title"]}>
                                  {course.is_free !== 1 &&
                                    videoItem.free_seconds > 0 && (
                                      <span className={styles["free"]}>
                                        试看
                                      </span>
                                    )}
                                  <span className={styles["text"]}>
                                    {videoItem.title}
                                  </span>
                                </div>
                                {video.id === videoItem.id ? (
                                  <div className={styles["video-duration"]}>
                                    <img
                                      width="24"
                                      height="24"
                                      className={styles["play-icon"]}
                                      src={playIcon}
                                    />
                                  </div>
                                ) : (
                                  <div className={styles["video-duration"]}>
                                    <DurationText
                                      seconds={videoItem.duration}
                                    />
                                  </div>
                                )}
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
                        {videos[0].map((videoItem: any) => (
                          <div
                            className={styles["video-item"]}
                            key={videoItem.id}
                            onClick={() => goVideo(videoItem)}
                          >
                            <div className={styles["video-title"]}>
                              {course.is_free !== 1 &&
                                videoItem.free_seconds > 0 && (
                                  <span className={styles["free"]}>试看</span>
                                )}
                              <span className={styles["text"]}>
                                {videoItem.title}
                              </span>
                            </div>
                            {video.id === videoItem.id ? (
                              <div className={styles["video-duration"]}>
                                <img
                                  width="24"
                                  height="24"
                                  className={styles["play-icon"]}
                                  src={playIcon}
                                />
                              </div>
                            ) : (
                              <div className={styles["video-duration"]}>
                                <DurationText seconds={videoItem.duration} />
                              </div>
                            )}
                          </div>
                        ))}
                      </div>
                    </div>
                  )}
                </>
              ) : (
                <>
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
                        {videos[0].map((videoItem: any) => (
                          <div
                            className={styles["video-item"]}
                            key={videoItem.id}
                            onClick={() => goVideo(videoItem)}
                          >
                            <div className={styles["video-title"]}>
                              {course.is_free !== 1 &&
                                videoItem.free_seconds > 0 && (
                                  <span className={styles["free"]}>试看</span>
                                )}
                              <span className={styles["text"]}>
                                {videoItem.title}
                              </span>
                            </div>
                            {video.id === videoItem.id ? (
                              <div className={styles["video-duration"]}>
                                <img
                                  width="24"
                                  height="24"
                                  className={styles["play-icon"]}
                                  src={playIcon}
                                />
                              </div>
                            ) : (
                              <div className={styles["video-duration"]}>
                                <DurationText seconds={videoItem.duration} />
                              </div>
                            )}
                          </div>
                        ))}
                      </div>
                    )}
                  </div>
                )}
                </>
              )}
            </div>
          )}
          {currentTab === 1 && video && (
            <CourseComments
              rid={video.id}
              isBuy={isWatch && isBuy}
              isAllowComment={video.is_allow_comment}
              rt={2}
            />
          )}
          {currentTab === 3 && (
            <AttachBox cid={course.id} list={attachs} isBuy={isBuy} />
          )}
        </div>
        {!loading && currentTab === 0 && !isWatch && (
          <div className={styles["bottom-bar"]}>
            <>
              {course.is_vip_free === 1 ? (
                <div
                  className={`${styles["button-item"]} ${styles["role-button"]}`}
                  onClick={() => goRole()}
                >
                  <span>VIP会员免费看</span>
                </div>
              ) : null}
              <div
                className={`${styles["button-item"]} ${styles["buy-button"]}`}
                onClick={() => buyCourse()}
              >
                <span>购买课程</span>
              </div>
            </>
          </div>
        )}
      </div>
    </>
  );
};

export default CoursePlayPage;
