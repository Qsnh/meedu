import React from "react";
import styles from "./index.module.scss";
import icon from "../../assets/img/watermark@2x.png"

export const TechSupport: React.FC = () => {
  return (
    <div className={styles["tech-support"]}>
      <div className={styles["inline-img"]}>
        <img src={icon} />
      </div>
    </div>
  );
};
