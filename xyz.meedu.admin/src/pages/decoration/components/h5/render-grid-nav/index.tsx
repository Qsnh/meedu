import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import defaultIcon from "../../../../../assets/images/decoration/h5/default-grid-nav.png";

interface PropInterface {
  config: any;
}

export const RenderGridNav: React.FC<PropInterface> = ({ config }) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [lineCount, setLineCount] = useState(0);

  useEffect(() => {
    if (config) {
      let num = Math.ceil(config.items.length / config.line_count);
      setLineCount(num);
    }
  }, [config]);

  return (
    <div className={styles["grid-nav-box"]}>
      <div className="grid-nav">
        {Array.from({ length: lineCount }).map((_, index) => (
          <div
            className={
              config.line_count === 5
                ? styles["act-grid-line"]
                : styles["grid-line"]
            }
            key={index}
          >
            {Array.from({ length: config.line_count }).map((_, i) => {
              return (
                config.items[index * config.line_count + i] && (
                  <div className="grid-item" key={i}>
                    <div className="icon">
                      {config.items[index * config.line_count + i].src ? (
                        <img
                          src={config.items[index * config.line_count + i].src}
                          width={44}
                          height={44}
                        />
                      ) : (
                        <img src={defaultIcon} width={44} height={44} />
                      )}
                    </div>
                    <div className={styles["name"]}>
                      {config.items[index * config.line_count + i].name}
                    </div>
                  </div>
                )
              );
            })}
          </div>
        ))}
      </div>
    </div>
  );
};
