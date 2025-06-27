import React from "react";
import styles from "./index.module.scss";
import { useSelector } from "react-redux";
import { RootState } from "../../store";
import { AppConfigInterface } from "../../store/system/systemConfigSlice";

export const Copyright: React.FC = () => {
  const config: AppConfigInterface = useSelector(
    (state: RootState) => state.systemConfig.value
  );

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
