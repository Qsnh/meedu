import { useEffect, useState, useRef } from "react";
import styles from "./index.module.scss";
import { Input, Toast } from "antd-mobile";
import { useNavigate, useLocation } from "react-router-dom";
import { search } from "../../api/index";
import { None } from "../../components";
import icon from "../../assets/img/icon-back.png";
import gifIcon from "../../assets/img/Spinload.gif";

const SearchPage = () => {
  const navigate = useNavigate();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState(false);
  const [type, setType] = useState<any>(0);
  const [keywords, setKeywords] = useState<string>(
    String(result.get("keywords")) || ""
  );
  const listRef = useRef([]);
  const pageRef = useRef(1);
  const finishedRef = useRef(false);
  const types = [
    {
      key: 0,
      name: "全部",
    },
    {
      key: "vod",
      name: "录播课",
    },
    {
      key: "video",
      name: "录播视频",
    },
  ];

  useEffect(() => {
    document.title = "搜索";

    window.addEventListener("scroll", ScrollToBottomEvt, true);
    return () => {
      // 记得销毁event
      window.removeEventListener("scroll", ScrollToBottomEvt, true);
    };
  }, []);

  useEffect(() => {
    setKeywords(String(result.get("keywords")));
  }, [result.get("keywords")]);

  useEffect(() => {
    resetData();
    getData();
  }, [type]);

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

  const goSearch = () => {
    if (!keywords) {
      Toast.show("请输入关键字后再搜索");
      return;
    }
    navigate(`/search?keywords=${keywords}`, { replace: true });
  };

  const resetData = () => {
    pageRef.current = 1;
    listRef.current = [];
    finishedRef.current = false;
  };

  const getData = (more = false) => {
    if (loading || finishedRef.current) {
      return;
    }
    if (more) {
      pageRef.current++;
    }
    if (!keywords) {
      return;
    }
    setLoading(true);
    search
      .Index({
        page: pageRef.current,
        size: 10,
        type: type,
        keywords: keywords,
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

  const change = (val: string) => {
    if (val === "video") {
      return "录播视频";
    } else if (val === "vod") {
      return "录播课";
    } else if (val === "live") {
      return "直播课";
    } else if (val === "topic") {
      return "图文";
    } else if (val === "book") {
      return "电子书";
    } else if (val === "paper") {
      return "试卷";
    } else if (val === "practice") {
      return "练习";
    } else {
      return "其它";
    }
  };

  const goDetail = (val: string, id: number) => {
    if (val === "video") {
      navigate("/vod/video?id=" + id);
    } else if (val === "vod") {
      navigate("/vod/detail?id=" + id);
    } else {
      return;
    }
  };

  return (
    <div id="content" className={styles["container"]}>
      <div className="navheader borderbox">
        <img
          className="back"
          onClick={() => {
            if (window.history.length <= 2) {
              navigate("/");
            } else {
              navigate(-1);
            }
          }}
          src={icon}
        />
        <Input
          className={"input"}
          placeholder="搜索关键词"
          value={keywords}
          onChange={(e: any) => {
            setKeywords(e);
          }}
          onEnterPress={(e: any) => {
            goSearch();
          }}
        />
        <div className="btn-search" onClick={() => goSearch()}>
          搜索
        </div>
      </div>
      <div className={styles["type-box"]}>
        {types.map((item: any) => (
          <div
            className={
              type === item.key
                ? `${styles["item"]} ${styles["active"]}`
                : styles["item"]
            }
            key={item.key}
            onClick={() => setType(item.key)}
          >
            {item.name}
          </div>
        ))}
      </div>
      <div className={styles["list-box"]}>
        {listRef.current.length > 0 || loading ? (
          <>
            {listRef.current.map((item: any) => (
              <div
                className={styles["list-item"]}
                key={item.id}
                onClick={() => goDetail(item.resource_type, item.id)}
              >
                <div className={styles["item-top"]}>
                  <div className={styles["item-type"]}>
                    {change(item.resource_type)}
                  </div>
                  <div className={styles["item-tit"]}>{item.title}</div>
                </div>
                {item.short_desc && (
                  <div
                    className={styles["item-content"]}
                    dangerouslySetInnerHTML={{
                      __html: item.short_desc,
                    }}
                  ></div>
                )}
              </div>
            ))}
            <div className={styles["drop"]}>
              {loading && !finishedRef.current && <img src={gifIcon} />}
              {finishedRef.current && <span>已经到底了</span>}
            </div>
          </>
        ) : (
          <None type="gray" />
        )}
      </div>
    </div>
  );
};

export default SearchPage;
