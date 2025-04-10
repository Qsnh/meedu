import { useEffect, useState, useRef } from "react";
import { useNavigate, useLocation } from "react-router-dom";
import styles from "./index.module.scss";
import { useSelector } from "react-redux";
import { user } from "../../api/index";
import { Empty } from "../../components";
import { CoursesModel } from "./compenents/course-item";
import gifIcon from "../../assets/img/Spinload.gif";

const StudyPage = () => {
  const navigate = useNavigate();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState(false);
  const [currentNav, setCurrentNav] = useState(result.get("tab") || "study");
  const [courseType, setCourseType] = useState("vod");
  const listRef = useRef([]);
  const pageRef = useRef(1);
  const finishedRef = useRef(false);
  const isLogin = useSelector((state: any) => state.loginUser.value.isLogin);
  const navs = [
    {
      name: "在学",
      key: "study",
    },
    {
      name: "购买",
      key: "course",
    },
    {
      name: "收藏",
      key: "collect",
    },
  ];

  useEffect(() => {
    document.title = "我的课程";

    window.addEventListener("scroll", ScrollToBottomEvt, true);
    return () => {
      // 记得销毁event
      window.removeEventListener("scroll", ScrollToBottomEvt, true);
    };
  }, []);

  useEffect(() => {
    setCurrentNav(result.get("tab") || "study");
  }, [result.get("tab")]);

  useEffect(() => {
    getData();
  }, [courseType, currentNav]);

  const ScrollToBottomEvt = () => {
    const el: any = document.getElementById("content");
    const toBottom = el.scrollHeight - window.screen.height - el.scrollTop;
    if (toBottom < 10) {
      if (finishedRef.current) {
        return;
      }
      getData(true);
    }
  };

  const resetPagination = () => {
    pageRef.current = 1;
    listRef.current = [];
    finishedRef.current = false;
  };

  const getData = (more = false) => {
    if (more === false) {
      resetPagination();
    } else {
      pageRef.current++;
    }

    if (currentNav === "course") {
      getUserCourses();
    } else if (currentNav === "collect") {
      getLikeCourses();
    } else if (currentNav === "study") {
      getViewStudy();
    }
  };

  const getUserCourses = () => {
    if (loading || finishedRef.current) {
      return;
    }
    setLoading(true);
    user
      .NewCourses({
        type: courseType,
        page: pageRef.current,
        size: 10,
      })
      .then((res: any) => {
        let data = res.data.data;
        if (pageRef.current > 1 && data.length > 0) {
          let box: any = [...listRef.current];
          box.push(...data);
          listRef.current = box;
        } else if (pageRef.current === 1) {
          listRef.current = res.data.data;
        }
        setTimeout(() => {
          setLoading(false);
          if (data.length < 10) {
            finishedRef.current = true;
          }
        }, 200);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const getLikeCourses = () => {
    if (loading || finishedRef.current) {
      return;
    }
    setLoading(true);
    user
      .CoursesCollects({
        type: courseType,
        page: pageRef.current,
        size: 10,
      })
      .then((res: any) => {
        let data = res.data.data;
        if (pageRef.current > 1 && data.length > 0) {
          let box: any = [...listRef.current];
          box.push(...data);
          listRef.current = box;
        } else if (pageRef.current === 1) {
          listRef.current = res.data.data;
        }
        setTimeout(() => {
          setLoading(false);
          if (data.length < 10) {
            finishedRef.current = true;
          }
        }, 200);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const getViewStudy = () => {
    if (loading || finishedRef.current) {
      return;
    }
    setLoading(true);
    user
      .LearnedCourses({
        type: courseType,
        page: pageRef.current,
        size: 10,
      })
      .then((res: any) => {
        let data = res.data.data;
        if (pageRef.current > 1 && data.length > 0) {
          let box: any = [...listRef.current];
          box.push(...data);
          listRef.current = box;
        } else if (pageRef.current === 1) {
          listRef.current = res.data.data;
        }
        setTimeout(() => {
          setLoading(false);
          if (data.length < 10) {
            finishedRef.current = true;
          }
        }, 200);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const goDetail = (item: any) => {
    navigate("/course/" + item.id);
  };

  const goLogin = () => {
    navigate(
      "/login?redirect=" +
        encodeURIComponent(window.location.pathname + window.location.search)
    );
  };

  return (
    <div id="content" className={styles["container"]}>
      {isLogin ? (
        <>
          <div className={styles["top-nav"]}>
            {navs.map((item: any) => (
              <div
                className={
                  item.key === currentNav
                    ? `${styles["nav-item"]} ${styles["active"]}`
                    : styles["nav-item"]
                }
                key={item.key}
                onClick={() => {
                  navigate("/study?tab=" + item.key, { replace: true });
                }}
              >
                <div className={styles["item-text"]}>{item.name}</div>
                <div className={styles["item-dot"]}></div>
              </div>
            ))}
          </div>
          <div className={styles["courses-box"]}>
            {(listRef.current.length > 0 || loading) && (
              <>
                {courseType === "vod" && (
                  <CoursesModel
                    list={listRef.current}
                    currenStatus={currentNav}
                  />
                )}
                <div className={styles["drop"]}>
                  {loading && !finishedRef.current && <img src={gifIcon} />}
                  {finishedRef.current && <span>已经到底了</span>}
                </div>
              </>
            )}
            {listRef.current.length === 0 && !loading && <Empty />}
          </div>
        </>
      ) : (
        <>
          <Empty />
          <div className={styles["btn-login-box"]}>
            <div className={styles["btn-login"]} onClick={() => goLogin}>
              登录查看
            </div>
          </div>
        </>
      )}
    </div>
  );
};

export default StudyPage;
