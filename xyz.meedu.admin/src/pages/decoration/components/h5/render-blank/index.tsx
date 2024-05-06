import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";

interface PropInterface {
  config: any;
}

export const RenderBlank: React.FC<PropInterface> = ({ config }) => {
  const [loading, setLoading] = useState<boolean>(false);

  return (
    <div
      className={styles["blank-box"]}
      style={{ height: config.height, backgroundColor: config.bgcolor }}
    ></div>
  );
};
