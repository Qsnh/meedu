import { useState, useEffect } from "react";
import { useSearchParams } from "react-router-dom";
import { announcement } from "../../api/index";
import styles from "./index.module.scss";
import { useNavigate } from "react-router-dom";
import NavHeader from "../../components/nav-header";

const AnnouncementPage = () => {
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();
  const [loading, setLoading] = useState<boolean>(true);
  const [data, setData] = useState<any>(null);

  useEffect(() => {
    const id = searchParams.get("id");
    if (id) {
      getData(Number(id));
    } else {
      navigate("/");
    }
  }, [searchParams]);

  const getData = (id: number) => {
    setLoading(true);
    announcement
      .detail(id)
      .then((res: any) => {
        if (res.data) {
          setData(res.data);
          document.title = res.data.title || "公告详情";
        }
        setLoading(false);
      })
      .catch(() => {
        setLoading(false);
      });
  };

  const formatTime = (timeStr: string) => {
    if (!timeStr) return "";

    // 将 ISO 8601 格式转换为 Date 对象，自动处理时区
    const date = new Date(timeStr);

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}`;
  };

  return (
    <div className={styles["container"]}>
      <NavHeader text="公告详情" />
      <div className={styles["content"]}>
        {loading ? (
          <div className={styles["loading"]}>加载中...</div>
        ) : data ? (
          <>
            <div className={styles["title"]}>{data.title}</div>
            <div className={styles["meta"]}>
              <span className={styles["time"]}>
                {formatTime(data.created_at)}
              </span>
            </div>
            <div className={styles["line"]}></div>
            <div
              className={styles["body"]}
              dangerouslySetInnerHTML={{ __html: data.announcement }}
            ></div>
          </>
        ) : (
          <div className={styles["empty"]}>暂无数据</div>
        )}
      </div>
    </div>
  );
};

export default AnnouncementPage;
