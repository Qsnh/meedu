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
        <div className="d-flex">
          <div className="flex-1">
            {config.items[0].src ? (
              <img src={config.items[0].src} style={{ width: "100%" }} />
            ) : (
              <img src={emptyIcon} style={{ width: "100%" }} />
            )}
          </div>
          {config.items[1] && (
            <div className="flex-1">
              {config.items[1].src ? (
                <img src={config.items[1].src} style={{ width: "100%" }} />
              ) : (
                <img src={emptyIcon} style={{ width: "100%" }} />
              )}
            </div>
          )}
        </div>
      )}
      {config.v === "v-3" && (
        <div className="d-flex">
          <div className="flex-1">
            {config.items[0].src ? (
              <img src={config.items[0].src} style={{ width: "100%" }} />
            ) : (
              <img src={emptyIcon} style={{ width: "100%" }} />
            )}
          </div>
          {config.items[1] && (
            <div className="flex-1">
              {config.items[1].src ? (
                <img src={config.items[1].src} style={{ width: "100%" }} />
              ) : (
                <img src={emptyIcon} style={{ width: "100%" }} />
              )}
            </div>
          )}
          {config.items[2] && (
            <div className="flex-1">
              {config.items[2].src ? (
                <img src={config.items[2].src} style={{ width: "100%" }} />
              ) : (
                <img src={emptyIcon} style={{ width: "100%" }} />
              )}
            </div>
          )}
        </div>
      )}
      {config.v === "v-4" && (
        <div className="d-flex">
          <div className="flex-1">
            {config.items[0].src ? (
              <img src={config.items[0].src} style={{ width: "100%" }} />
            ) : (
              <img src={emptyIcon} style={{ width: "100%" }} />
            )}
          </div>
          {config.items[1] && (
            <div className="flex-1">
              {config.items[1].src ? (
                <img src={config.items[1].src} style={{ width: "100%" }} />
              ) : (
                <img src={emptyIcon} style={{ width: "100%" }} />
              )}
            </div>
          )}
          {config.items[2] && (
            <div className="flex-1">
              {config.items[2].src ? (
                <img src={config.items[2].src} style={{ width: "100%" }} />
              ) : (
                <img src={emptyIcon} style={{ width: "100%" }} />
              )}
            </div>
          )}
          {config.items[3] && (
            <div className="flex-1">
              {config.items[3].src ? (
                <img src={config.items[3].src} style={{ width: "100%" }} />
              ) : (
                <img src={emptyIcon} style={{ width: "100%" }} />
              )}
            </div>
          )}
        </div>
      )}
      {config.v === "v-1-2" && (
        <div className="d-flex">
          <div className="flex-1" style={{ height: 150 }}>
            {config.items[0].src ? (
              <img
                src={config.items[0].src}
                style={{ width: "100%" }}
                height={150}
              />
            ) : (
              <img src={emptyIcon} style={{ width: "100%" }} height={150} />
            )}
          </div>
          <div className="flex-1">
            {config.items[1] && (
              <div className="float-left" style={{ height: 75 }}>
                {config.items[1].src ? (
                  <img
                    src={config.items[1].src}
                    style={{ width: "100%" }}
                    height={75}
                  />
                ) : (
                  <img src={emptyIcon} style={{ width: "100%" }} height={75} />
                )}
              </div>
            )}
            {config.items[2] && (
              <div className="float-left" style={{ height: 75 }}>
                {config.items[2].src ? (
                  <img
                    src={config.items[2].src}
                    style={{ width: "100%" }}
                    height={75}
                  />
                ) : (
                  <img src={emptyIcon} style={{ width: "100%" }} height={75} />
                )}
              </div>
            )}
          </div>
        </div>
      )}
    </div>
  );
};
