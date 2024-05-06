import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { system } from "../../../../../api";
import { NoticeList } from "./list";

interface PropInterface {
  reload: boolean;
}

export const RenderNotice: React.FC<PropInterface> = ({ reload }) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [title, setTitle] = useState<any>(null);
  const [showListWin, setShowListWin] = useState<boolean>(false);

  useEffect(() => {
    getData();
  }, [reload]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .announcementList({
        page: 1,
        size: 1,
      })
      .then((res: any) => {
        if (res.data.data.length > 0) {
          setTitle(res.data.data[0].title);
        }
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const close = () => {
    setShowListWin(false);
    getData();
  };

  return (
    <div className="float-left">
      <div
        className={styles["notice-box"]}
        onClick={() => setShowListWin(true)}
      >
        {title || "未配置公告"}
      </div>
      <NoticeList open={showListWin} onClose={() => close()}></NoticeList>
    </div>
  );
};
