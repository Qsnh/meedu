import { useState, useEffect } from "react";
import styles from "./detail.module.scss";
import { Skeleton, message } from "antd";
import { useParams, useNavigate, useLocation } from "react-router-dom";
import { useSelector } from "react-redux";
import { course as vod } from "../../api/index";
import { ThumbBar, Empty, CourseComments } from "../../components";
import { VideoListComp } from "./components/detail/video-list";
import { VideoChapterListComp } from "./components/detail/video-chapter-list";
import collectIcon from "../../assets/img/commen/icon-collect-h.png";
import noCollectIcon from "../../assets/img/commen/icon-collect-n.png";
import { latexRender, codeRender } from "../../utils/index";
import appConfig from "../../js/config";

const VodDetailPage = () => {
  const isLogin = useSelector((state: any) => state.loginUser.value.isLogin);
  const navigate = useNavigate();
  const params = useParams();

  const result = new URLSearchParams(useLocation().search);
  const [currentTab, setCurrentTab] = useState(Number(result.get("tab")) || 2);

  const [loading, setLoading] = useState(false);
  const [cid] = useState(Number(params.courseId));
  const [course, setCourse] = useState<any>({});
  const [attach, setAttach] = useState<any[]>([]);
  const [chapters, setChapters] = useState<any[]>([]);
  const [isBuy, setIsBuy] = useState(false);
  const [isCollect, setIsCollect] = useState(false);
  const [videos, setVideos] = useState<any>({});
  const [buyVideos, setBuyVideos] = useState<any[]>([]);
  const [isfixTab, setIsfixTab] = useState(false);

  const tabs = [
    {
      name: "课程详情",
      id: 2,
    },
    {
      name: "课程目录",
      id: 3,
    },
    {
      name: "课程评论",
      id: 4,
    },
    {
      name: "课程附件",
      id: 5,
    },
  ];

  useEffect(() => {
    getDetail();

    window.addEventListener("scroll", handleTabFix, true);
    return () => {
      window.removeEventListener("scroll", handleTabFix, true);
    };
  }, [cid]);

  useEffect(() => {
    const dom = document ? document.getElementById("desc") : null;
    if (dom) {
      latexRender(dom);
      codeRender(dom);
    }
  }, [course]);

  const tabChange = (id: number) => {
    setCurrentTab(id);
    navigate("/courses/detail/" + cid + "?tab=" + id);
  };

  const handleTabFix = () => {
    const scrollTop =
      window.pageYOffset ||
      document.documentElement.scrollTop ||
      document.body.scrollTop;
    const navbar = document.querySelector("#NavBar") as HTMLElement;
    if (navbar) {
      const offsetTop = navbar.offsetTop;
      scrollTop > offsetTop ? setIsfixTab(true) : setIsfixTab(false);
    }
  };

  const getDetail = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    vod.detail(cid).then((res: any) => {
      document.title = res.data.course.title;
      setCourse(res.data.course);
      setAttach(res.data.attach);
      setChapters(res.data.chapters);
      setIsBuy(res.data.isBuy);
      setIsCollect(res.data.isCollect);
      setVideos(res.data.videos);
      setBuyVideos(res.data.buyVideos);

      setLoading(false);
    });
  };

  const collectCourse = () => {
    if (isLogin) {
      vod.collect(cid).then(() => {
        setIsCollect(!isCollect);
        if (isCollect) {
          message.success("取消收藏");
        } else {
          message.success("已收藏");
        }
      });
    } else {
      goLogin();
    }
  };

  const goLogin = () => {
    let url = encodeURIComponent(
      window.location.pathname + window.location.search
    );
    navigate("/login?redirect=" + url);
  };

  const goRole = () => {
    navigate("/vip");
  };

  const buyCourse = () => {
    if (!isLogin) {
      goLogin();
      return;
    }
    navigate(
      "/order?goods_id=" +
        cid +
        "&goods_type=vod&goods_charge=" +
        course.charge +
        "&goods_label=点播课程&goods_name=" +
        course.title +
        "&goods_thumb=" +
        course.thumb
    );
  };

  const goPlay = (item: any) => {
    if (!isLogin) {
      goLogin();
      return;
    }
    navigate("/courses/video/" + item.id);
  };

  const download = (id: number) => {
    if (!isLogin) {
      goLogin();
      return;
    }
    if (!isBuy) {
      message.error("请购买课程后下载");
      return;
    }
    vod.downloadAttachment(cid, id).then((res: any) => {
      window.open(res.data.download_url);
    });
  };

  return (
    <>
      {isfixTab && (
        <div className="fix-nav">
          <div className="course-tabs">
            {tabs.map((item: any) => (
              <div
                key={item.id}
                className={
                  currentTab === item.id ? "active item-tab" : "item-tab"
                }
                onClick={() => tabChange(item.id)}
              >
                {item.name}
                {currentTab === item.id && <div className="actline"></div>}
              </div>
            ))}
          </div>
        </div>
      )}
      <div className="container">
        <div className="bread-nav">
          {loading && (
            <Skeleton.Button
              active
              style={{
                width: 1200,
                height: 14,
                marginLeft: 0,
              }}
            ></Skeleton.Button>
          )}
          {!loading && (
            <>
              <a
                onClick={() => {
                  navigate("/");
                }}
              >
                首页
              </a>{" "}
              /
              <a
                onClick={() => {
                  navigate("/courses");
                }}
              >
                录播课
              </a>{" "}
              /<span>{course.title}</span>
            </>
          )}
        </div>
        <div className={styles["course-info"]}>
          <div className={styles["course-info-box"]}>
            <div className={styles["course-thumb"]}>
              {loading && (
                <Skeleton.Button
                  active
                  style={{
                    width: 320,
                    height: 240,
                    borderRadius: 8,
                  }}
                ></Skeleton.Button>
              )}
              <ThumbBar
                value={course.thumb}
                width={320}
                height={240}
                border={null}
              />
            </div>
            <div className={styles["info"]}>
              {loading && (
                <div
                  style={{
                    width: 710,
                    display: "flex",
                    flexDirection: "column",
                  }}
                >
                  <Skeleton.Button
                    active
                    style={{
                      width: 710,
                      height: 30,
                      marginTop: 20,
                    }}
                  ></Skeleton.Button>
                  <Skeleton.Button
                    active
                    style={{
                      width: 710,
                      height: 16,
                      marginTop: 21,
                    }}
                  ></Skeleton.Button>
                </div>
              )}
              <div className={styles["course-info-title"]}>{course.title}</div>
              {isCollect && (
                <img
                  onClick={() => {
                    collectCourse();
                  }}
                  className={styles["collect-button"]}
                  src={collectIcon}
                />
              )}
              {!isCollect && (
                <img
                  onClick={() => {
                    collectCourse();
                  }}
                  className={styles["collect-button"]}
                  src={noCollectIcon}
                />
              )}
              <p className={styles["desc"]}>{course.short_description}</p>
              <div className={styles["btn-box"]}>
                {!isBuy && course.charge !== 0 && (
                  <>
                    {course.charge > 0 && (
                      <div
                        className={styles["buy-button"]}
                        onClick={() => buyCourse()}
                      >
                        购买课程￥{course.charge}
                      </div>
                    )}
                    {course.vip_can_view === 1 && !appConfig.disable_vip && (
                      <div
                        className={styles["role-button"]}
                        onClick={() => goRole()}
                      >
                        会员免费看
                      </div>
                    )}
                  </>
                )}
                {course.is_free === 1 && (
                  <div className={styles["has-button"]}>本课程免费</div>
                )}
                {course.is_free !== 1 && isBuy && (
                  <div className={styles["has-button"]}>课程已购买</div>
                )}
              </div>
            </div>
          </div>
          <div className="course-tabs" id="NavBar">
            {tabs.map((item: any) => (
              <div
                key={item.id}
                className={
                  currentTab === item.id ? "active item-tab" : "item-tab"
                }
                onClick={() => tabChange(item.id)}
              >
                {item.name}
                {currentTab === item.id && <div className="actline"></div>}
              </div>
            ))}
          </div>
        </div>
        {currentTab === 2 && (
          <div className={styles["coursr-desc"]}>
            <div
              className="u-content md-content"
              id="desc"
              dangerouslySetInnerHTML={{ __html: course.render_desc }}
            ></div>
          </div>
        )}
        {currentTab === 3 && (
          <div className={styles["course-chapter-box"]}>
            {chapters.length > 0 && (
              <VideoChapterListComp
                chapters={chapters}
                course={course}
                videos={videos}
                isBuy={isBuy}
                buyVideos={buyVideos}
                switchVideo={(item: any) => goPlay(item)}
              />
            )}
            {chapters.length === 0 && videos[0] && (
              <VideoListComp
                course={course}
                videos={videos[0]}
                isBuy={isBuy}
                buyVideos={buyVideos}
                switchVideo={(item: any) => goPlay(item)}
              />
            )}
          </div>
        )}
        {currentTab === 4 && (
          <CourseComments
            rid={cid}
            isBuy={isBuy}
            isAllowComment={course.is_allow_comment}
            rt={1}
          />
        )}
        {currentTab === 5 && (
          <div className={styles["attach-list-box"]}>
            {attach.length === 0 && <Empty></Empty>}
            {attach.length > 0 &&
              attach.map((item: any) => (
                <div className={styles["attach-item"]} key={item.id}>
                  <div className={styles["attach-name"]}>{item.name}</div>
                  <a
                    onClick={() => download(item.id)}
                    className={styles["download-attach"]}
                  >
                    下载附件
                  </a>
                </div>
              ))}
          </div>
        )}
      </div>
    </>
  );
};

export default VodDetailPage;
