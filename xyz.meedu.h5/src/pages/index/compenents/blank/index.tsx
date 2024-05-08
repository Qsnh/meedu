import styles from "./index.module.scss";
import React from "react";

interface PropInterface {
  height: number;
  bgColor: string;
}

export const IndexBlank: React.FC<PropInterface> = ({ height, bgColor }) => {
  return (
    <div
      className={styles["blank-box"]}
      style={{ height: height + "px", backgroundColor: bgColor }}
    ></div>
  );
};
