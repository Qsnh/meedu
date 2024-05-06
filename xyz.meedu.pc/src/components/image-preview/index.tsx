import React from "react";
import styles from "./index.module.scss";

interface PropInterface {
  url: string;
  close: () => void;
}

export const ImagePreview: React.FC<PropInterface> = ({ url, close }) => {
  return (
    <div className={styles["image-preview-shadow-box"]} onClick={() => close()}>
      <img className={styles["img"]} src={url} />
    </div>
  );
};
