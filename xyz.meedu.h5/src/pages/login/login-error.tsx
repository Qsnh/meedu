import { useState } from "react";
import styles from "./login-error.module.scss";
import { useLocation, useNavigate } from "react-router-dom";
import icon from "../../assets/img/icon-error.png";

const LoginErrorPage = () => {
  const navigate = useNavigate();
  const result = new URLSearchParams(useLocation().search);
  const [msg, setMsg] = useState(result.get("msg") || "");

  return (
    <div className={styles["pay-success-box"]}>
      <div className={styles["icon"]}>
        <img src={icon} />
      </div>
      <div className={styles["text"]}>{msg}</div>
      <div className={styles["btn-box"]}>
        <div
          className={styles["button"]}
          onClick={() => {
            navigate("/", { replace: true });
          }}
        >
          返回首页
        </div>
      </div>
    </div>
  );
};

export default LoginErrorPage;
