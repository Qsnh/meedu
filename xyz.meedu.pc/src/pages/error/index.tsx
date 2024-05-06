import { useState } from "react";
import styles from "./index.module.scss";
import { Link, useLocation } from "react-router-dom";
import errorIcon from "../../assets/img/commen/img-wrong.png";

const ErrorPage = () => {
  document.title = "错误";
  const result = new URLSearchParams(useLocation().search);
  const [msg, setMsg] = useState(result.get("msg"));

  return (
    <div className={styles["error"]}>
      <div className={styles["empty-box"]}>
        <Link replace to="/">
          <img src={errorIcon} />
          <div className={styles["text"]}>{msg}</div>
        </Link>
      </div>
    </div>
  );
};

export default ErrorPage;
