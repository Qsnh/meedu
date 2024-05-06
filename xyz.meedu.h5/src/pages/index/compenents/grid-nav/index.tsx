import styles from "./index.module.scss";
import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";

interface PropInterface {
  render: any;
  lineCount: number;
  isLogin: boolean;
}

export const IndexGridNav: React.FC<PropInterface> = ({
  render,
  lineCount,
  isLogin,
}) => {
  const navigate = useNavigate();
  const [navs, setNavs] = useState<any>([]);

  useEffect(() => {
    let rows = [];
    let count = Number(render.length / lineCount);
    let mod = render.length % lineCount;
    let len = mod === 0 ? count : count + 1;
    for (let i = 0; i < len; i++) {
      let tmp = [];
      for (let j = 0; j < lineCount; j++) {
        let tmpItem = render[i * lineCount + j];
        if (!tmpItem) {
          break;
        }
        tmp.push(tmpItem);
      }
      rows.push(tmp);
    }

    setNavs(rows);
  }, [lineCount, render]);
  
  const goLogin = () => {
    navigate(
      "/login?redirect=" +
        encodeURIComponent(window.location.pathname + window.location.search)
    );
  };

  const goNav = (nav: any) => {
    let url = nav.href;
    if (url.substr(0, 4) === "http") {
      // 网页
      window.location.href = url;
    } else {
      if (!isLogin) {
        goLogin();
        return;
      }
      navigate(url);
    }
  };

  return (
    <>
      <div className={styles["nav-box"]}>
        {navs.map((childrenRows: any, index: number) => (
          <div
            className={
              lineCount === 5
                ? `${styles["nav-box-row"]} ${styles["active"]}`
                : styles["nav-box-row"]
            }
            key={index}
          >
            {childrenRows.map((childrenItem: any, index2: number) => (
              <div
                className={styles["nav-item"]}
                key={index2}
                onClick={() => goNav(childrenItem)}
              >
                <div className={styles["icon"]}>
                  <img src={childrenItem.src} />
                </div>
                <div className={styles["name"]}>{childrenItem.name}</div>
              </div>
            ))}
          </div>
        ))}
      </div>
    </>
  );
};
