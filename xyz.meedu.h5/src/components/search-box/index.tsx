import styles from "./index.module.scss";
import React, { useState } from "react";
import { Input, Toast } from "antd-mobile";
import { useNavigate } from "react-router-dom";
import icon from "../../assets/img/icon-search.png";

export const SearchBox: React.FC = () => {
  const navigate = useNavigate();
  const [keywords, setKeywords] = useState<string>("");

  const search = () => {
    if (!keywords) {
      Toast.show("请输入关键字后再搜索");
      return;
    }
    navigate(`/search?keywords=${keywords}`);
  };

  return (
    <>
      <div className={styles["navTab"]}>
        <img
          className={styles["search-icon"]}
          onClick={() => search()}
          src={icon}
        />
        <Input
          className={styles["input"]}
          placeholder="搜索关键词"
          value={keywords}
          onChange={(e: any) => {
            setKeywords(e);
          }}
          onEnterPress={(e: any) => {
            search();
          }}
        />
      </div>
    </>
  );
};
