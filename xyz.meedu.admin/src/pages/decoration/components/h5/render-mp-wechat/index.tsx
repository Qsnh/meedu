import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import wechatIcon from "../../../../../assets/images/decoration/h5/mp-wechat-icon.png";

interface PropInterface {
  config: any;
}

export const RenderMpWechat: React.FC<PropInterface> = ({ config }) => {
  const [loading, setLoading] = useState<boolean>(false);

  return (
    <div className={styles["mp-wechat-box"]}>
      <div className={styles["mp-wechat-icon"]}>
        <img src={wechatIcon} width={50} height={50} />
      </div>
      <div className={styles["mp-wechat-body"]}>
        <div className={styles["name"]}>{config.name}</div>
        <div className={styles["desc"]}>{config.desc}</div>
      </div>
      <div className={styles["options"]}>
        <a href="javascript:void(0)">查看</a>
      </div>
    </div>
  );
};
