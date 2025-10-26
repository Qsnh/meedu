import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import emptyIcon from "../../../../../assets/images/decoration/h5/empty-image.png";

interface PropInterface {
  config: any;
}

export const RenderImageGroup: React.FC<PropInterface> = ({ config }) => {
  const [loading, setLoading] = useState<boolean>(false);

  return (
    <div className={styles["image-group-box"]}>
      {config.v === "v-1" && (
        <>
          {config.items[0].src ? (
            <img src={config.items[0].src} style={{ width: "100%" }} />
          ) : (
            <img src={emptyIcon} style={{ width: "100%" }} />
          )}
        </>
      )}
      {config.v === "v-2" && (
        <div className={styles["image-row"]}>
          <div className={styles["image-item"]}>
            {config.items[0].src ? (
              <img src={config.items[0].src} />
            ) : (
              <img src={emptyIcon} />
            )}
          </div>
          {config.items[1] && (
            <div className={styles["image-item"]}>
              {config.items[1].src ? (
                <img src={config.items[1].src} />
              ) : (
                <img src={emptyIcon} />
              )}
            </div>
          )}
        </div>
      )}
      {config.v === "v-3" && (
        <div className={styles["image-row"]}>
          <div className={styles["image-item"]}>
            {config.items[0].src ? (
              <img src={config.items[0].src} />
            ) : (
              <img src={emptyIcon} />
            )}
          </div>
          {config.items[1] && (
            <div className={styles["image-item"]}>
              {config.items[1].src ? (
                <img src={config.items[1].src} />
              ) : (
                <img src={emptyIcon} />
              )}
            </div>
          )}
          {config.items[2] && (
            <div className={styles["image-item"]}>
              {config.items[2].src ? (
                <img src={config.items[2].src} />
              ) : (
                <img src={emptyIcon} />
              )}
            </div>
          )}
        </div>
      )}
      {config.v === "v-4" && (
        <div className={styles["image-row"]}>
          <div className={styles["image-item"]}>
            {config.items[0].src ? (
              <img src={config.items[0].src} />
            ) : (
              <img src={emptyIcon} />
            )}
          </div>
          {config.items[1] && (
            <div className={styles["image-item"]}>
              {config.items[1].src ? (
                <img src={config.items[1].src} />
              ) : (
                <img src={emptyIcon} />
              )}
            </div>
          )}
          {config.items[2] && (
            <div className={styles["image-item"]}>
              {config.items[2].src ? (
                <img src={config.items[2].src} />
              ) : (
                <img src={emptyIcon} />
              )}
            </div>
          )}
          {config.items[3] && (
            <div className={styles["image-item"]}>
              {config.items[3].src ? (
                <img src={config.items[3].src} />
              ) : (
                <img src={emptyIcon} />
              )}
            </div>
          )}
        </div>
      )}
      {config.v === "v-1-2" && (
        <div className={styles["special-layout"]} style={{ height: 150 }}>
          <div className={styles["large-image"]}>
            {config.items[0].src ? (
              <img src={config.items[0].src} />
            ) : (
              <img src={emptyIcon} />
            )}
          </div>
          <div className={styles["small-images"]}>
            {config.items[1] && (
              <div className={styles["small-image-item"]}>
                {config.items[1].src ? (
                  <img src={config.items[1].src} />
                ) : (
                  <img src={emptyIcon} />
                )}
              </div>
            )}
            {config.items[2] && (
              <div className={styles["small-image-item"]}>
                {config.items[2].src ? (
                  <img src={config.items[2].src} />
                ) : (
                  <img src={emptyIcon} />
                )}
              </div>
            )}
          </div>
        </div>
      )}
    </div>
  );
};
