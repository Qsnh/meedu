import React, { useState, useEffect } from "react";
import { Tag, Tooltip } from "antd";
import styles from "./index.module.scss";

interface PropInterface {
  tags: any[];
}

export const TagsTooltip: React.FC<PropInterface> = ({ tags }) => {
  const [current, setCurrent] = useState(0);

  useEffect(() => {
    let value = "";
    for (let i = 0; i < tags.length; i++) {
      value += tags[i].name;
      if (value.length > 8 && window.innerWidth >= 1700) {
        setCurrent(1);
        break;
      } else if (value.length > 7 && window.innerWidth >= 1600) {
        setCurrent(1);
        break;
      } else if (value.length > 4 && window.innerWidth < 1600) {
        setCurrent(1);
        break;
      }
    }
  }, [tags]);
  return (
    <div className={styles["cursor-pointer"]}>
      <Tooltip
        placement="top"
        title={
          <>
            {tags.map((item: any, index: number) => (
              <Tag
                color="processing"
                key={"title" + index}
                className="ml-5 mb-5"
              >
                {item.name}
              </Tag>
            ))}
          </>
        }
        color="#ffffff"
      >
        <>
          {current > 0 &&
            tags.slice(0, current).map((item: any, index: number) => (
              <div key={"ecli" + index}>
                <Tag color="processing" className="ml-5 mb-5">
                  {item.name}
                </Tag>
                ...
              </div>
            ))}
          {current === 0 && (
            <>
              {tags.map((item: any, index: number) => (
                <Tag
                  key={"no" + index}
                  color="processing"
                  className="ml-5 mb-5"
                >
                  {item.name}
                </Tag>
              ))}
            </>
          )}
        </>
      </Tooltip>
    </div>
  );
};
