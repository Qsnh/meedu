import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { announcement } from "../../api/index";
import styles from "./index.module.scss";

export const AnnouncementBanner = () => {
  const navigate = useNavigate();
  const [data, setData] = useState<any>(null);
  const [visible, setVisible] = useState<boolean>(true);
  const [loading, setLoading] = useState<boolean>(true);

  useEffect(() => {
    getData();
  }, []);

  const getData = () => {
    announcement
      .latest()
      .then((res: any) => {
        if (res.data && res.data.id) {
          setData(res.data);
          setVisible(true);
        } else {
          setVisible(false);
        }
        setLoading(false);
      })
      .catch(() => {
        setVisible(false);
        setLoading(false);
      });
  };

  const handleClick = () => {
    if (data && data.id) {
      navigate(`/announcement?id=${data.id}`);
    }
  };

  if (loading || !visible || !data) {
    return null;
  }

  return (
    <div className={styles["announcement-banner"]} onClick={handleClick}>
      <div className={styles["icon"]}>
        <svg
          viewBox="0 0 1024 1024"
          version="1.1"
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
        >
          <path
            d="M853.333333 234.666667H512V85.333333c0-23.466667-19.2-42.666667-42.666667-42.666666s-42.666667 19.2-42.666666 42.666666v149.333334H170.666667c-46.933333 0-85.333333 38.4-85.333334 85.333333v533.333333c0 46.933333 38.4 85.333333 85.333334 85.333334h682.666666c46.933333 0 85.333333-38.4 85.333334-85.333334V320c0-46.933333-38.4-85.333333-85.333334-85.333333z m-640 85.333333h597.333334c23.466667 0 42.666667 19.2 42.666666 42.666667v106.666666H170.666667V362.666667c0-23.466667 19.2-42.666667 42.666666-42.666667z m640 469.333333H170.666667c-23.466667 0-42.666667-19.2-42.666667-42.666666V554.666667h768v192c0 23.466667-19.2 42.666667-42.666667 42.666666z"
            fill="#fa8c16"
          />
        </svg>
      </div>
      <div className={styles["text"]}>{data.title}</div>
      <div className={styles["arrow"]}>
        <svg
          viewBox="0 0 1024 1024"
          version="1.1"
          xmlns="http://www.w3.org/2000/svg"
          width="12"
          height="12"
        >
          <path
            d="M384 256l256 256-256 256"
            fill="#999999"
            stroke="#999999"
            strokeWidth="64"
          />
        </svg>
      </div>
    </div>
  );
};
