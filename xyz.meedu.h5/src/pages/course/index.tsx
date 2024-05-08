import { useEffect, useState, useRef } from "react";
import styles from "./index.module.scss";
import { course } from "../../api";
import FilterBox1 from "./compenents/filter-box1";
import { VodCourseItem } from "../../components/vod-course-item";
import gifIcon from "../../assets/img/Spinload.gif";

const CoursePage = () => {
  const [categories, setCategories] = useState<any>([]);
  const [scene, setScene] = useState("");
  const [cid, setCid] = useState(0);
  const listRef = useRef([]);
  const pageRef = useRef(1);
  const finishedRef = useRef(false);
  const [loading, setLoading] = useState(false);
  const scenes = [
    {
      id: "",
      name: "全部",
    },
    {
      id: "free",
      name: "免费",
    },
  ];

  useEffect(() => {
    document.title = "录播课程";
    getparams();
    window.addEventListener("scroll", ScrollToBottomEvt, true);
    return () => {
      // 记得销毁event
      window.removeEventListener("scroll", ScrollToBottomEvt, true);
    };
  }, []);

  useEffect(() => {
    pageRef.current = 1;
    finishedRef.current = false;
    listRef.current = [];
    getData();
  }, [scene, cid]);

  const getparams = () => {
    course.Categories().then((res: any) => {
      let categories = res.data;
      let box = [];
      for (let i = 0; i < categories.length; i++) {
        if (categories[i].children.length > 0) {
          box.push(categories[i]);
          let children = categories[i].children;
          for (let j = 0; j < children.length; j++) {
            children[j].name = "|----" + children[j].name;
            box.push(children[j]);
          }
        } else {
          box.push(categories[i]);
        }
      }
      setCategories(box);
    });
  };

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

  const getData = (more = false) => {
    if (loading || finishedRef.current) {
      return;
    }
    if (more) {
      pageRef.current++;
    }
    setLoading(true);
    course
      .List({
        page: pageRef.current,
        page_size: 10,
        category_id: cid,
        scene: scene,
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

  return (
    <div id="content" className="container">
      <FilterBox1
        categories1={scenes}
        categories2={categories}
        cid1={scene}
        cid2={cid}
        onChange={(scene: string, cid: number) => {
          setCid(cid);
          setScene(scene);
        }}
      />
      {(listRef.current.length > 0 || loading) && (
        <>
          <div className={styles["gray"]}></div>
          {listRef.current.map((course: any) => (
            <div className={styles["vod-course-item"]} key={course.id}>
              <VodCourseItem
                cid={course.id}
                thumb={course.thumb}
                title={course.title}
                charge={course.charge}
                isFree={course.is_free}
                userCount={course.user_count}
              />
            </div>
          ))}
          <div className={styles["drop"]}>
            {loading && !finishedRef.current && <img src={gifIcon} />}
            {finishedRef.current && <span>已经到底了</span>}
          </div>
        </>
      )}
    </div>
  );
};

export default CoursePage;
