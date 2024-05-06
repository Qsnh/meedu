import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Select } from "antd";
import { useSelector } from "react-redux";
import { VodComp } from "./vod-comp";

interface PropInterface {
  onChange: (value: any) => void;
}

export const H5Courses: React.FC<PropInterface> = ({ onChange }) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [courseTypes, setCourseTypes] = useState<any>([]);
  const [typeActive, setTypeActive] = useState("vod");
  const enabledAddons = useSelector(
    (state: any) => state.enabledAddonsConfig.value.enabledAddons
  );

  useEffect(() => {
    let types = [
      {
        label: "录播课程",
        value: "vod",
      },
    ];

    setCourseTypes(types);
  }, [enabledAddons]);

  return (
    <div className="float-left" style={{ position: "relative" }}>
      <div className={styles["select-box"]}>
        <div className={styles["form-label"]}>请选择课程类型</div>
        <div className="ml-15">
          <Select
            style={{ width: 200 }}
            value={typeActive}
            onChange={(e) => {
              setTypeActive(e);
            }}
            allowClear
            placeholder="课程类型"
            options={courseTypes}
          />
        </div>
      </div>
      <div className="float-left">
        {typeActive === "vod" && (
          <VodComp
            onChange={(value: any) => {
              onChange(value);
            }}
          ></VodComp>
        )}
      </div>
    </div>
  );
};
