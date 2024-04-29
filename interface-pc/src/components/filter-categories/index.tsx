import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Skeleton } from "antd";

interface PropInterface {
  loading: boolean;
  categories: any[];
  defaultKey: number;
  defaultChild: number;
  onSelected: (cid: number, child: number) => void;
}

export const FilterCategories: React.FC<PropInterface> = ({
  categories,
  loading,
  defaultKey,
  defaultChild,
  onSelected,
}) => {
  const [init, setInit] = useState<boolean>(false);
  const [cid, setCid] = useState(defaultKey);
  const [child, setChild] = useState(defaultChild);
  const [cateIndex, setCateIndex] = useState(0);

  useEffect(() => {
    let index = 0;
    for (let i = 0; i < categories.length; i++) {
      if (categories[i].id === cid) {
        index = i;
      }
    }
    setCateIndex(index);
  }, [categories, cid]);

  return (
    <div className={styles["category-box"]}>
      <div className={styles["categories"]}>
        {loading && !init && (
          <div style={{ width: 1140, textAlign: "left" }}>
            <Skeleton.Button
              active
              style={{
                width: 1140,
                height: 34,
                marginBottom: 10,
              }}
            ></Skeleton.Button>
          </div>
        )}
        {(!loading || init) && (
          <div className={styles["box"]}>
            <div className={styles["label"]}>分类：</div>
            <div className={styles["item-box"]}>
              <div
                className={cid === 0 ? styles["active-item"] : styles["item"]}
                onClick={() => {
                  setInit(true);
                  setCid(0);
                  setChild(0);
                  onSelected(0, 0);
                }}
              >
                全部
              </div>
              {categories.map((item: any) => (
                <div
                  key={item.id}
                  className={
                    cid === item.id ? styles["active-item"] : styles["item"]
                  }
                  onClick={() => {
                    setInit(true);
                    setCid(item.id);
                    setChild(0);
                    onSelected(item.id, 0);
                  }}
                >
                  <span>{item.name}</span>
                </div>
              ))}
            </div>
          </div>
        )}
        {(!loading || init) &&
          cid !== 0 &&
          categories[cateIndex] &&
          categories[cateIndex].children &&
          categories[cateIndex].children.length > 0 && (
            <div className={styles["box2"]}>
              <div className={styles["label"]}>细分：</div>
              <div className={styles["item-box"]}>
                <div
                  className={
                    child === 0 ? styles["active-item"] : styles["item"]
                  }
                  onClick={() => {
                    setInit(true);
                    setChild(0);
                    onSelected(cid, 0);
                  }}
                >
                  全部
                </div>
                {categories[cateIndex].children.map((item: any) => (
                  <div
                    key={item.id}
                    className={
                      child === item.id ? styles["active-item"] : styles["item"]
                    }
                    onClick={() => {
                      setInit(true);
                      setChild(item.id);
                      onSelected(cid, item.id);
                    }}
                  >
                    <span>{item.name}</span>
                  </div>
                ))}
              </div>
            </div>
          )}
      </div>
    </div>
  );
};
