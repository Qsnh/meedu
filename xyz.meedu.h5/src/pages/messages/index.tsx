import { useEffect, useState, useRef } from "react";
import styles from "./index.module.scss";
import NavHeader from "../../components/nav-header";
import { user } from "../../api/index";
import { changeTime } from "../../utils";
import gifIcon from "../../assets/img/Spinload.gif";

const MessagesPage = () => {
  const [loading, setLoading] = useState(false);
  const listRef = useRef([]);
  const pageRef = useRef(1);
  const finishedRef = useRef(false);

  useEffect(() => {
    document.title = "我的消息";
    getData();
    window.addEventListener("scroll", ScrollToBottomEvt, true);
    return () => {
      // 记得销毁event
      window.removeEventListener("scroll", ScrollToBottomEvt, true);
    };
  }, []);

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
    user
      .Messages({
        page: pageRef.current,
        page_size: 20,
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
          if (data.length < 20) {
            finishedRef.current = true;
          }
        }, 200);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const read = (item: any, index: number) => {
    if (item.read_at) {
      return;
    }
    setLoading(true);
    user
      .ReadMessage(item.id)
      .then(() => {
        let box: any = [...listRef.current];
        box[index].read_at = 1;
        listRef.current = box;
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <div id="content" className={styles["container"]}>
      <NavHeader text="我的消息" />
      {(listRef.current.length > 0 || loading) && (
        <>
          {listRef.current.map((item: any, index: number) => (
            <div
              className={
                item.read_at
                  ? `${styles["message-item"]} ${styles["readed"]}`
                  : styles["message-item"]
              }
              key={item.id}
              onClick={() => read(item, index)}
            >
              <div className={styles["content"]}>{item.data.message}</div>
              <div className={styles["date"]}>
                {changeTime(item.created_at)}
              </div>
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

export default MessagesPage;
