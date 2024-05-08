import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import moment from "moment";

interface PropInterface {
  active: boolean;
  onChange: (start_at: any, end_at: any) => void;
}

export const DayWeekMonth = (props: PropInterface) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [current, setCurrent] = useState(0);
  const [tabs, setTabs] = useState<any>([]);

  useEffect(() => {
    let tabs = [];
    if (props.active) {
      tabs = [
        { id: 7, name: "周" },
        { id: 30, name: "月" },
      ];
    } else {
      tabs = [
        { id: 1, name: "日" },
        { id: 7, name: "周" },
        { id: 30, name: "月" },
      ];
    }
    setTabs(tabs);
  }, [props.active]);

  const change = (key: number, index: number) => {
    setCurrent(index);
    let start_at = null;
    let end_at = moment().add(1, "days").format("YYYY-MM-DD");
    if (key === 1) {
      start_at = moment().format("YYYY-MM-DD");
    } else if (key === 7) {
      start_at = moment().subtract(6, "days").format("YYYY-MM-DD");
    } else if (key === 30) {
      start_at = moment().subtract(29, "days").format("YYYY-MM-DD");
    }
    props.onChange(start_at, end_at);
  };

  return (
    <>
      <div
        className={
          props.active ? styles["controls-act-box"] : styles["controls-box"]
        }
      >
        {tabs.length > 0 &&
          tabs.map((item: any, index: number) => (
            <div
              key={index}
              id={item.id}
              className={
                current === index ? styles["act-item"] : styles["item"]
              }
              onClick={() => change(item.id, index)}
            >
              {item.name}
            </div>
          ))}
      </div>
    </>
  );
};
