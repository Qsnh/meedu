import React from "react";
import styles from "./index.module.scss";
import icon from "../../assets/img/commen/icon-top.png";

export const BackTop: React.FC = () => {
  return (
    <div className={styles["backTop"]} onClick={() => window.scrollTo(0, 0)}>
      <img src={icon} />
      <span>顶部</span>
    </div>
  );
};
