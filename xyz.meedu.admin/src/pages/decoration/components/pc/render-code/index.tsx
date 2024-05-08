import React, { useState } from "react";
import styles from "./index.module.scss";

interface PropInterface {
  config: any;
}

export const RenderCode: React.FC<PropInterface> = ({ config }) => {
  const [loading, setLoading] = useState<boolean>(false);

  return (
    <div className="float-left">
      {config.html ? (
        <div
          dangerouslySetInnerHTML={{
            __html: config.html,
          }}
        ></div>
      ) : (
        <div className={styles["code-empty"]}>代码块</div>
      )}
    </div>
  );
};
