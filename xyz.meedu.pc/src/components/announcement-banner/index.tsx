import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { home } from "../../api/index";
import styles from "./index.module.scss";
import { CloseOutlined, SoundOutlined } from "@ant-design/icons";

export const AnnouncementBanner = () => {
  const navigate = useNavigate();
  const [announcement, setAnnouncement] = useState<any>(null);
  const [visible, setVisible] = useState<boolean>(true);
  const [loading, setLoading] = useState<boolean>(true);

  useEffect(() => {
    // 检查是否已经关闭过公告
    const closedAnnouncementId = localStorage.getItem("closedAnnouncementId");

    getData(closedAnnouncementId);
  }, []);

  const getData = (closedId: string | null) => {
    home
      .announcement()
      .then((res: any) => {
        if (res.data && res.data.id) {
          // 如果当前最新公告已被关闭，则不显示
          if (closedId && Number(closedId) === res.data.id) {
            setVisible(false);
          } else {
            setAnnouncement(res.data);
            setVisible(true);
          }
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
    if (announcement && announcement.id) {
      navigate(`/announcement?id=${announcement.id}`);
    }
  };

  const handleClose = (e: React.MouseEvent) => {
    e.stopPropagation();
    if (announcement && announcement.id) {
      localStorage.setItem("closedAnnouncementId", announcement.id.toString());
    }
    setVisible(false);
  };

  if (loading || !visible || !announcement) {
    return null;
  }

  return (
    <div className={styles["announcement-banner"]} onClick={handleClick}>
      <div className={styles["banner-content"]}>
        <SoundOutlined className={styles["icon"]} />
        <div className={styles["text"]}>{announcement.title}</div>
        <CloseOutlined
          className={styles["close-btn"]}
          onClick={handleClose}
        />
      </div>
    </div>
  );
};
