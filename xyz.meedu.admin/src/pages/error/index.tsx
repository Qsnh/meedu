import { useEffect, useState } from "react";
import { Result } from "antd";
import { useLocation } from "react-router-dom";
import styles from "./index.module.scss";

const ErrorPage = () => {
  const result = new URLSearchParams(useLocation().search);

  const [error, setError] = useState("");

  useEffect(() => {
    const code = result.get("code");
    let errMsg = result.get("msg") || "系统错误";
    if (code === "403") {
      errMsg = "无权限操作";
    } else if (code === "404") {
      errMsg = "资源不存在";
    } else if (code === "429") {
      errMsg = "请求次数过多，请稍后再试";
    }
    setError(errMsg);
  }, [result.get("code"), result.get("msg")]);

  return <Result title={error} className={styles["main"]} />;
};

export default ErrorPage;
