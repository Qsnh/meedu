import React, { useState } from "react";
import styles from "./success.module.scss";
import { Link, useLocation } from "react-router-dom";
import successIcon from "../../assets/img/commen/icon-adopt.png";

const OrderSuccessPage = () => {
  document.title = "支付成功";
  const result = new URLSearchParams(useLocation().search);
  const [totalAmount, setTotalAmount] = useState(
    Number(result.get("total_amount")) || 0
  );

  return (
    <div className="container">
      <div className={styles["pay-success-box"]}>
        <div className={styles["success-info"]}>
          <img src={successIcon} />
          支付成功！
        </div>
        <div className={styles["price"]}>
          实付款：
          <span className={styles["value"]}>
            ￥<strong>{totalAmount}</strong>
          </span>
        </div>
        <div className={styles["btn-box"]}>
          <Link replace to="/">
            <div className={styles["button"]}>返回首页</div>
          </Link>
          <Link replace to="/member/orders">
            <div className={styles["find-button"]}>查看订单</div>
          </Link>
        </div>
      </div>
    </div>
  );
};

export default OrderSuccessPage;
