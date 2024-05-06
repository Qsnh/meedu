import React, { useState } from "react";
import styles from "./index.module.scss";

interface PropInterface {
  scenes: any[];
  defaultKey: string;
  onSelected: (id: string) => void;
}

export const FilterScenes: React.FC<PropInterface> = ({
  scenes,
  defaultKey,
  onSelected,
}) => {
  const [sceneId, setSceneId] = useState<string>(defaultKey);

  return (
    <div className={styles["category-box"]}>
      <div className={styles["box"]}>
        {scenes.map((item: any) => (
          <div
            key={item.id}
            className={
              sceneId === item.id ? styles["active-item"] : styles["item"]
            }
            onClick={() => {
              setSceneId(item.id);
              onSelected(item.id);
            }}
          >
            <span>{item.name}</span>
          </div>
        ))}
      </div>
    </div>
  );
};
