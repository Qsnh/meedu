import { useEffect, useState } from "react";
import styles from "./pay.module.scss";
import { useLocation, useNavigate } from "react-router-dom";
import { order } from "../../api/index";
import icon from "../../assets/img/icon-back.png";

const OrderPayPage = () => {
  const navigate = useNavigate();
  const result = new URLSearchParams(useLocation().search);
  const [text, setText] = useState("");
  const [orderId, setOrderId] = useState(Number(result.get("orderId")));
  const [price, setPrice] = useState(Number(result.get("price")));
  const [payment, setPayment] = useState(String(result.get("payment")));
  const [type, setType] = useState(String(result.get("type")));
  const [id, setId] = useState(Number(result.get("id")));

  useEffect(() => {
    document.title = "支付中";
    initData();
  }, [orderId]);

  const initData = () => {
    order
      .HandPay({
        order_id: orderId,
      })
      .then((res: any) => {
        setText(res.data.text);
      })
      .catch((e) => {
        navigate("/");
      });
  };

  const confirm = () => {
    navigate("/");
  };

  return (
    <div className={styles["container"]}>
      <div className="navheader borderbox">
        <img
          className="back"
          onClick={() => {
            navigate(-2);
          }}
          src={icon}
        />
        <div className="title">手动打款支付</div>
      </div>
      <div className={styles["normal-box"]}>
        <div className={styles["orderNum"]}>
          订单号：<span>{orderId}</span>
        </div>
        <div className={styles["price"]}>
          需支付：
          <span className={styles["red"]}>
            ￥<strong>{price}</strong>
          </span>
        </div>
      </div>
      <div className={styles["pay-box"]}>
        <div className={styles["tit"]}>
          收款信息<span>（手动打款需后台验证后交付订单，请耐心等待）</span>
        </div>
        <div
          className={styles["text"]}
          dangerouslySetInnerHTML={{
            __html: text,
          }}
        ></div>
      </div>
      <div className={styles["btns"]}>
        <div className={styles["btn-confirm"]} onClick={() => confirm()}>
          我已完成支付
        </div>
      </div>
    </div>
  );
};

export default OrderPayPage;
