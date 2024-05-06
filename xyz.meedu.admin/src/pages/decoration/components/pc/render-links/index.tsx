import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { system } from "../../../../../api";
import { LinksList } from "./list";

interface PropInterface {
  reload: boolean;
}

export const RenderLinks: React.FC<PropInterface> = ({ reload }) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
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
      .linksList({
        page: 1,
        size: 1000,
      })
      .then((res: any) => {
        setList(res.data.data);
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
    <div className={styles["link-box"]}>
      <div className="float-left" onClick={() => setShowListWin(true)}>
        <div className={styles["title"]}>友情链接</div>
        <div className={styles["links"]}>
          {list.length > 0 &&
            list.map((item: any, index: number) => (
              <div className={styles["link-item"]} key={index}>
                {item.name}
              </div>
            ))}
        </div>
      </div>
      <LinksList open={showListWin} onClose={() => close()}></LinksList>
    </div>
  );
};
