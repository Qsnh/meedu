import React from "react";
import styles from "./index.module.scss";
import { useSelector } from "react-redux";

export const Copyright: React.FC = () => {
  const config = useSelector((state: any) => state.systemConfig.value);

  return (
    <>
      <div className={styles["copyright"]}>
        <div className={styles["item"]}>
          Copyright {new Date().getFullYear()}.
        </div>
        {config && (
          <div className={styles["item"]}>{config.webname} 版权所有</div>
        )}
      </div>
    </>
  );
};
