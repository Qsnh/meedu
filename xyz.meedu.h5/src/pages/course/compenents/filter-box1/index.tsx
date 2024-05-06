import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { useNavigate } from "react-router-dom";
import backIcon from "../../../../assets/img/icon-back.png";
import icon from "../../../../assets/img/icon-filter.png";

interface PropsInterafce {
  categories1: any[];
  categories2: any[];
  cid1: string;
  cid2: number;
  onChange: (scene: string, cid: number) => void;
}

export default function FilterBox1(props: PropsInterafce) {
  const navigate = useNavigate();
  const [filterShowStatus, setFilterShowStatus] = useState(false);
  const [id1, setId1] = useState(props.cid1);
  const [id2, setId2] = useState(Number(props.cid2));

  const back = () => {
    if (window.history.length <= 1) {
      navigate("/");
      return false;
    } else {
      navigate(-1);
    }
  };

  const setCid = (id: number) => {
    setId2(id);
    setFilterShowStatus(false);
    props.onChange(id1, id);
  };

  const setScene = (scene: string) => {
    setId1(scene);
    props.onChange(scene, id2);
  };

  const toggleFilterShowStatus = () => {
    setFilterShowStatus(!filterShowStatus);
  };

  return (
    <>
      <div className={styles["meedu-filter-box"]}>
        <div className={styles["filter-box"]}>
          <div className={styles["filter-back"]}>
            <img
              className={styles["back"]}
              onClick={() => back()}
              src={backIcon}
              alt="back"
            />
          </div>
          <div className={styles["filter-title"]}>录播课程</div>
          <div className={styles["filter-button"]}>
            <div
              className={
                id2 !== 0
                  ? `${styles["button-text"]} ${styles["active"]}`
                  : styles["button-text"]
              }
              onClick={() => toggleFilterShowStatus()}
            >
              <span>筛选</span>
              <img src={icon} />
            </div>
            {filterShowStatus && (
              <div className={styles["category2-box"]}>
                <div
                  className={
                    id2 === 0
                      ? `${styles["item"]} ${styles["active"]}`
                      : styles["item"]
                  }
                  onClick={() => setCid(0)}
                >
                  全部
                </div>
                {props.categories2.map((item: any) => (
                  <div
                    className={
                      id2 === item.id
                        ? `${styles["item"]} ${styles["active"]}`
                        : styles["item"]
                    }
                    onClick={() => setCid(item.id)}
                    key={item.id}
                  >
                    {item.name}
                  </div>
                ))}
              </div>
            )}
            {filterShowStatus && (
              <div
                className={styles["meedu-shadow-box"]}
                onClick={() => toggleFilterShowStatus()}
              ></div>
            )}
          </div>
        </div>
        <div className={styles["category1-box"]}>
          {props.categories1.map((item: any, index: number) => (
            <div
              className={
                id1 === item.id
                  ? `${styles["item"]} ${styles["active"]}`
                  : styles["item"]
              }
              onClick={() => setScene(item.id)}
              key={"scene" + index}
            >
              {item.name}
            </div>
          ))}
        </div>
      </div>
    </>
  );
}
