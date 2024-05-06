import React from "react";
import styles from "./index.module.scss";

interface PropInterface {
  border: any;
  value: string;
  width: number;
  height: number;
  isContain?: boolean;
}

export const ThumbBar: React.FC<PropInterface> = ({
  border,
  value,
  width,
  height,
  isContain,
}) => {
  return (
    <div className={styles["content-box"]}>
      <div className="flex justify-center" style={{ width: "100%" }}>
        {isContain ? (
          <div
            style={{
              backgroundColor: "#f5f5f5",
              borderRadius: border ? border + "px" : "none",
              backgroundImage: "url(" + value + ")",
              width: width + "px",
              height: height + "px",
              backgroundRepeat: "no-repeat",
              backgroundSize: "contain",
              backgroundPosition: "center center",
            }}
          ></div>
        ) : (
          <div
            style={{
              borderRadius: border ? border + "px" : "none",
              backgroundImage: "url(" + value + ")",
              width: width + "px",
              height: height + "px",
              backgroundPosition: "center center",
              backgroundSize: "cover",
              backgroundRepeat: "no-repeat",
            }}
          ></div>
        )}
      </div>
    </div>
  );
};
