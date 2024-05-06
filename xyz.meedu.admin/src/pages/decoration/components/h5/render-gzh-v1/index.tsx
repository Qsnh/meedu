import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import noneIcon from "../../../../../assets/images/decoration/h5/none-img.png";

interface PropInterface {
  config: any;
}

export const RenderGzhV1: React.FC<PropInterface> = ({ config }) => {
  const [loading, setLoading] = useState<boolean>(false);

  return (
    <div className={styles["gzh-box"]}>
      <div className={styles["gzh-left"]}>
        <div className={styles["avatar"]}>
          {config.logo ? (
            <img src={config.logo} width={50} height={50} />
          ) : (
            <img src={noneIcon} width={50} height={50} />
          )}
        </div>
        <div className={styles["info"]}>
          <div className={styles["name"]}>{config.name}</div>
          <div className={styles["desc"]}>{config.desc}</div>
        </div>
      </div>
      <div className={styles["gzh-right"]}>
        <div className={styles["btn"]}>关注</div>
      </div>
    </div>
  );
};
