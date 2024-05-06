import React, { useState, useEffect } from "react";
import styles from "./pay.module.scss";
import { order } from "../../api/index";
import { useSelector } from "react-redux";
import { useNavigate, useLocation } from "react-router-dom";
import { QRCode, message } from "antd";
import wepayIcon from "../../assets/img/commen/icon-wexinpay.png";
import cradIcon from "../../assets/img/commen/icon-card.png";

var timer: any = null;
const OrderPayPage = () => {
  document.title = "支付中";
  const navigate = useNavigate();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState<boolean>(true);
  const [payment, setPayment] = useState(result.get("payment"));
  const [id, setId] = useState(Number(result.get("id")));
  const [price, setPrice] = useState(Number(result.get("price")));
  const [orderId, setOrderId] = useState(Number(result.get("orderId")));
  const [goodsId, setGoodsId] = useState(Number(result.get("goods_id")));
  const [goodsType, setGoodsType] = useState(result.get("type"));
  const [courseId, setCourseId] = useState(Number(result.get("course_id")));
  const [courseType, setCourseType] = useState(result.get("course_type"));
  const [text, setText] = useState<string>("");
  const [qrode, setQrode] = useState<string>("loading");
  const user = useSelector((state: any) => state.loginUser.value.user);
  const isLogin = useSelector((state: any) => state.loginUser.value.isLogin);

  useEffect(() => {
    if (orderId && payment) {
      initData();
    }
    return () => {
      timer && clearInterval(timer);
    };
  }, [orderId, payment]);

  const initData = () => {
    timer = setInterval(checkOrder, 2000);
    if (payment === "wechat") {
      order
        .payWechatScan({
          order_id: orderId,
        })
        .then((res: any) => {
          setQrode(res.data.code_url);
          setLoading(false);
        })
        .catch((e) => {
          setLoading(false);
          timer && clearInterval(timer);
          navigate("/");
        });
    } else if (payment === "handPay") {
      order
        .handPay({
          order_id: orderId,
        })
        .then((res: any) => {
          setText(res.data.text);
          setLoading(false);
        })
        .catch((e) => {
          setLoading(false);
          timer && clearInterval(timer);
          navigate("/");
        });
    }
  };

  const checkOrder = () => {
    order.checkOrderStatus({ order_id: orderId }).then((res: any) => {
      let status = res.data.status;
      if (status === 9) {
        message.success("已成功支付");
        setTimeout(() => {
          goBack();
        }, 300);
      } else if (status === 7) {
        message.error("已取消");
        setTimeout(() => {
          goBack();
        }, 300);
      }
    });
  };

  const goBack = () => {
    timer && clearInterval(timer);
    if (goodsType === "role") {
      navigate("/member", { replace: true });
    } else if (goodsType === "book") {
      navigate("/book/detail/" + id);
    } else if (goodsType === "vod") {
      navigate("/courses/detail/" + id);
    } else if (goodsType === "live") {
      navigate("/live/detail/" + id);
    } else if (goodsType === "topic") {
      navigate("/topic/detail/" + id);
    } else if (goodsType === "video") {
      navigate("/courses/video/" + id);
    } else if (goodsType === "path") {
      navigate("/learnPath/detail/" + id);
    } else if (goodsType === "paper") {
      navigate("/exam/papers/detail/" + id);
    } else if (goodsType === "practice") {
      navigate("/exam/practice/detail/" + id);
    } else if (goodsType === "mockpaper") {
      navigate("/exam/mockpaper/detail/" + id);
    } else if (goodsType === "k12") {
      navigate("/k12/detail?id=" + id);
    } else if (goodsType === "tg") {
      if (courseType === "course") {
        navigate("/courses/detail/" + courseId);
      } else if (courseType === "live") {
        navigate("/live/detail/" + courseId);
      } else if (courseType === "book") {
        navigate("/book/detail/" + courseId);
      } else if (courseType === "learnPath") {
        navigate("/learnPath/detail/" + courseId);
      } else {
        navigate("/tg/detail?id=" + courseId);
      }
    } else if (goodsType === "ms") {
      if (courseType === "course") {
        navigate("/courses/detail/" + courseId);
      } else if (courseType === "live") {
        navigate("/live/detail/" + courseId);
      } else if (courseType === "book") {
        navigate("/book/detail/" + courseId);
      } else if (courseType === "learnPath") {
        navigate("/learnPath/detail/" + courseId);
      } else {
        navigate("/ms/detail?id=" + courseId);
      }
    }
  };

  const goLogin = () => {
    timer && clearInterval(timer);
    let url = encodeURIComponent(
      window.location.pathname + window.location.search
    );
    navigate("/login?redirect=" + url);
  };

  const confirm = () => {
    if (!isLogin) {
      goLogin();
      return;
    }
    goBack();
  };

  return (
    <div className={styles["content"]}>
      {payment === "wechat" && (
        <div className={styles["pay-box"]}>
          <div className={styles["pay-info"]}>
            <div className={styles["pay-top"]}>
              <div className={styles["icon"]}>
                <img src={wepayIcon} />
                微信扫码支付
              </div>
              <div className={styles["close"]} onClick={() => goBack()}>
                取消支付
              </div>
            </div>
            <div className={styles["paycode"]}>
              <QRCode
                size={200}
                value={qrode}
                status={loading ? "loading" : "active"}
              />
              <div className={styles["info"]}>
                <div className={styles["orderNum"]}>订单号：{orderId}</div>
                <div className={styles["price"]}>
                  <span>需支付</span>
                  <span className={styles["red"]}>
                    ￥<strong>{price}</strong>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div className={styles["btn-confirm"]} onClick={() => confirm()}>
            已完成支付
          </div>
        </div>
      )}
      {payment === "handPay" && (
        <div className={styles["pay-box"]}>
          <div className={styles["pay-info"]}>
            <div className={styles["pay-top"]}>
              <div className={styles["icon"]}>
                <img src={cradIcon} />
                手动支付
              </div>
              <div className={styles["close"]} onClick={() => goBack()}>
                取消支付
              </div>
            </div>
            <div className={styles["paycode2"]}>
              <div className={styles["hand-box"]}>
                <div className={styles["tit"]}>收款信息及说明</div>
                <div
                  className={styles["text"]}
                  dangerouslySetInnerHTML={{ __html: text }}
                ></div>
              </div>
              <div className={styles["orderNum"]}>订单号：{orderId}</div>
              <div className={styles["price"]}>
                <span>需支付</span>
                <span className={styles["red"]}>
                  ￥<strong>{price}</strong>
                </span>
              </div>
            </div>
          </div>
          <div className={styles["btn-confirm"]} onClick={() => confirm()}>
            已完成支付
          </div>
        </div>
      )}
    </div>
  );
};

export default OrderPayPage;
