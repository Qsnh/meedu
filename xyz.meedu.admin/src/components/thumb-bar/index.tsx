import React from "react";

interface PropInterface {
  value: string;
  width: number;
  height: number;
  border: number;
  title: string;
}

export const ThumbBar: React.FC<PropInterface> = ({
  value,
  width,
  height,
  border,
  title,
}) => {
  return (
    <div className="d-flex" style={{ width: "100%" }}>
      {title && (
        <>
          <div className="j-flex" style={{ width: 120 }}>
            <div
              style={{
                borderRadius: 4,
                backgroundImage: "url(" + value + ")",
                width: width,
                height: height,
                backgroundPosition: "center center",
                backgroundSize: "cover",
                backgroundRepeat: "'no-repeat'",
              }}
            ></div>
          </div>
          <div
            className="ml-10"
            style={{
              maxWidth: 340,
              textOverflow: "ellipsis",
              overflow: "hidden",
              display: "-webkit-box",
              WebkitLineClamp: 3,
              lineClamp: 3,
            }}
          >
            {title}
          </div>
        </>
      )}
      {!title && (
        <>
          <div className="j-flex" style={{ width: "100%" }}>
            <div
              style={{
                borderRadius: border,
                backgroundImage: "url(" + value + ")",
                width: width,
                height: height,
                backgroundPosition: "center center",
                backgroundSize: "cover",
                backgroundRepeat: "'no-repeat'",
              }}
            ></div>
          </div>
        </>
      )}
    </div>
  );
};
