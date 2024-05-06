import React from "react";
import styles from "./index.module.scss";

interface PropInterface {
  title: string;
  text: string;
  confirmText: string;
  cancel: () => void;
  change: () => void;
}

export const ShowModel: React.FC<PropInterface> = ({
  title,
  text,
  confirmText,
  change,
  cancel,
}) => {
  return (
    <>
      <div className={styles["mask"]}>
        <div className={styles["modal"]}>
          <div className={styles["body"]}>
            <div className={styles["top"]}>{title}</div>
            <div className={styles["item"]}>{text}</div>
          </div>
          <div className={styles["bottom"]}>
            <div className={styles["btn_cancel"]} onClick={() => cancel()}>
              退出登录
            </div>
            <div className={styles["btn_primary"]} onClick={() => change()}>
              {confirmText}
            </div>
          </div>
        </div>
      </div>
    </>
  );
};
