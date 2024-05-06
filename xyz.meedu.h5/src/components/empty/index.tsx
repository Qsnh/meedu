import React from "react";
import styles from "./index.module.scss";
import icon from "../../assets/img/img-placeholder.png";

export const Empty: React.FC = () => {
  return (
    <>
      <div className={styles["empty-box"]}>
        <div className={styles["image-empty-item"]}>
          <img src={icon} />
        </div>
      </div>
    </>
  );
};
