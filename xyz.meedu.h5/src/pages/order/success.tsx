import styles from "./success.module.scss";
import { useNavigate } from "react-router-dom";
import icon from "../../assets/img/icon-adopt.png";

const OrderSuccessPage = () => {
  const navigate = useNavigate();

  const goIndex = () => {
    navigate("/", { replace: true });
  };

  const find = () => {
    navigate("/member/order", { replace: true });
  };

  return (
    <div className={styles["pay-success-box"]}>
      <div className={styles["icon"]}>
        <img src={icon} />
      </div>
      <div className={styles["text"]}>支付成功</div>
      <div className={styles["btn-box"]}>
        <div className={styles["button"]} onClick={() => goIndex()}>
          返回首页
        </div>
        <div
          className={`${styles["button"]} ${styles["find"]}`}
          onClick={() => find()}
        >
          查看订单
        </div>
      </div>
    </div>
  );
};

export default OrderSuccessPage;
