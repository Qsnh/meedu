import { useEffect, useState, useRef } from "react";
import styles from "./order.module.scss";
import { useNavigate } from "react-router-dom";
import { user } from "../../api/index";
import { changeTime } from "../../utils";
import gifIcon from "../../assets/img/Spinload.gif";
import icon from "../../assets/img/icon-back.png";

const MemberOrdersPage = () => {
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const listRef = useRef([]);
  const pageRef = useRef(1);
  const finishedRef = useRef(false);

  useEffect(() => {
    document.title = "我的订单";
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
      .Orders({
        page: pageRef.current,
        page_size: 10,
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
    <div id="content" className={styles["container"]}>
      <div className="navheader borderbox">
        <img
          className="back"
          onClick={() => {
            navigate("/member");
          }}
          src={icon}
        />
        <div className="title">我的订单</div>
      </div>
      {(listRef.current.length > 0 || loading) && (
        <>
          {listRef.current.map((item: any) => (
            <div className={styles["order-item"]} key={item.id}>
              <div className={styles["title"]}>
                <div className={styles["date"]}>
                  {changeTime(item.created_at)}
                </div>
                <div className={styles["status"]}>{item.status_text}</div>
              </div>
              <div className={styles["body"]}>
                <div className={styles["goods"]}>
                  <div className={styles["name"]}>
                    {item.goods[0].goods_name}
                  </div>
                  <div className={styles["payment"]}>{item.payment_text}</div>
                </div>
                <div className={styles["charge"]}>
                  <span className={styles["unit"]}>￥</span>
                  {item.charge}
                </div>
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

export default MemberOrdersPage;
