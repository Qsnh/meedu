import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { system } from "../../../../../api";
import { DownOutlined } from "@ant-design/icons";
import { NavsList } from "./list";

interface PropInterface {
  reload: boolean;
}

export const RenderNavs: React.FC<PropInterface> = ({ reload }) => {
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
      .navsList({
        platform: "PC",
      })
      .then((res: any) => {
        setList(res.data);
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
      <div className={styles["navs"]} onClick={() => setShowListWin(true)}>
        {list.length > 0 &&
          list.map((item: any, index: number) => (
            <div className={styles["nav-item"]} key={index}>
              {item.name}
              {item.children.length > 0 && (
                <>
                  <DownOutlined style={{ marginLeft: 4 }} />
                  <div className={styles["nav-children"]}>
                    {item.children.map((it: any, index2: number) => (
                      <div className={styles["nav-children-item"]} key={index2}>
                        {it.name}
                      </div>
                    ))}
                  </div>
                </>
              )}
            </div>
          ))}
      </div>
      <NavsList open={showListWin} onClose={() => close()}></NavsList>
    </div>
  );
};
