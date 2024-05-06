import styles from "./index.module.scss";
import { useNavigate } from "react-router-dom";
import icon from "../../assets/img/icon-error.png";

const ErrorPage = () => {
  const navigate = useNavigate();

  return (
    <div className={styles["pay-success-box"]}>
      <div className={styles["icon"]}>
        <img src={icon} />
      </div>
      <div className={styles["text"]}> 404</div>
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

export default ErrorPage;
