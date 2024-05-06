import { useEffect, useState } from "react";
import styles from "./index.module.scss";
import { Input, Toast } from "antd-mobile";
import { useSelector } from "react-redux";
import { useLocation, useNavigate } from "react-router-dom";
import NavHeader from "../../components/nav-header";
import { order } from "../../api/index";
import { isWechatMini, getHost, getToken } from "../../utils";
import closeIcon from "../../assets/img/close.png";
import vipIcon from "../../assets/img/default-vip.png";
import prevIcon from "../../assets/img/icon-prev.png";
import aliIcon from "../../assets/img/payali.png";
import wechatIcon from "../../assets/img/paywechat.png";
import handIcon from "../../assets/img/payhand.png";
import selIcon from "../../assets/img/selected.png";
import unSelIcon from "../../assets/img/unselected.png";

const OrderPage = () => {
  const navigate = useNavigate();
  const result = new URLSearchParams(useLocation().search);
  const config = useSelector((state: any) => state.systemConfig.value);
  const [loading, setLoading] = useState(false);
  const [openmask, setOpenmask] = useState(false);
  const [isUsed, setIsUsed] = useState(false);
  const [promoCode, setPromoCode] = useState<any>("");
  const [configTip, setConfigTip] = useState(2);
  const [total, setTotal] = useState(Number(result.get("goods_charge")));
  const [goods, setGoods] = useState<any>({});
  const [totalVal, setTotalVal] = useState(0);
  const [discount, setDiscount] = useState(0);
  const [payments, setPayments] = useState<any>([]);
  const [payment, setPayment] = useState("");
  const [paymentScene, setPaymentScene] = useState("h5");
  const [promoCodeModel, setPromoCodeModel] = useState<any>(null);

  useEffect(() => {
    document.title = "收银台";
    let value = "h5";
    if (isWechatMini()) {
      value = "wechat";
      setPaymentScene("wechat");
    } else {
      setPaymentScene("h5");
    }
    params(value);
  }, []);

  useEffect(() => {
    let obj = {
      id: Number(result.get("goods_id")),
      icon: result.get("goods_thumb")
        ? String(result.get("goods_thumb"))
        : null,
      name: String(result.get("goods_name")),
      charge: Number(result.get("goods_charge")),
      label: String(result.get("goods_label")),
      type: String(result.get("goods_type")),
    };
    setGoods(obj);
  }, [
    result.get("goods_id"),
    result.get("goods_thumb"),
    result.get("goods_name"),
    result.get("goods_charge"),
    result.get("goods_label"),
    result.get("goods_type"),
  ]);

  useEffect(() => {
    let val = total - discount;
    val = val < 0 ? 0 : val;
    setTotalVal(val);
  }, [total, discount]);

  const params = (scene: string) => {
    order
      .Payments({
        scene: scene,
      })
      .then((res: any) => {
        let box: any = [];
        let box2: any = [];
        res.data.map((item: any) => {
          if (item.sign === "wechat-jsapi") {
            box.push(item);
          } else {
            box2.push(item);
          }
        });
        box = box.concat(box2);
        setPayments(box);
        setPayment(box[0].sign);
      });
  };

  const cancel = () => {
    setPromoCode("");
    setOpenmask(false);
  };

  const openPromo = () => {
    setPromoCode("");
    setOpenmask(true);
  };

  const checkPromoCode = () => {
    if (loading) {
      return;
    }
    if (!promoCode) {
      return;
    }
    setLoading(true);
    order
      .PromoCodeCheck(promoCode)
      .then((res: any) => {
        setLoading(false);
        if (res.data.can_use !== 1) {
          setConfigTip(0);
          Toast.show("优惠码无效");
          cancel();
        } else {
          setConfigTip(1);
          let obj = res.data.promo_code;
          setPromoCodeModel(obj);
          let value = parseInt(obj.invited_user_reward);
          setDiscount(value);
          Toast.show("优惠码有效，抵扣" + value + "元");
          setOpenmask(false);
        }
      })
      .catch((e) => {
        setLoading(false);
        setConfigTip(2);
        cancel();
      });
  };

  const payHandler = () => {
    if (!payment) {
      Toast.show("请选择支付方式");
      return;
    }
    if (loading) {
      return;
    }
    setLoading(true);
    if (goods.type === "vod") {
      // 点播课程
      order
        .CreateCourseOrder({
          course_id: goods.id,
          promo_code: promoCode,
        })
        .then((res: any) => {
          orderCreatedHandler(res.data);
        })
        .catch((e) => {
          setLoading(false);
        });
    } else if (goods.type === "video") {
      // 视频
      order
        .CreateVideoOrder({
          video_id: goods.id,
          promo_code: promoCode,
        })
        .then((res: any) => {
          orderCreatedHandler(res.data);
        })
        .catch((e) => {
          setLoading(false);
        });
    } else if (goods.type === "role") {
      order
        .CreateRoleOrder({
          role_id: goods.id,
          promo_code: promoCode,
        })
        .then((res: any) => {
          orderCreatedHandler(res.data);
        })
        .catch((e) => {
          setLoading(false);
        });
    }
  };

  const orderCreatedHandler = (order: any) => {
    setLoading(false);
    // 判断是否继续走支付平台支付
    if (order.status_text === "已支付") {
      // 优惠全部抵扣
      Toast.show("支付成功");
      setTimeout(() => {
        navigate(-1);
      }, 1000);
    } else {
      if (payment === "alipay" || payment === "wechat-jsapi") {
        let host = getHost();
        let sUrl = encodeURIComponent(host + "/order/success");

        window.location.href =
          config.url +
          "/api/v2/order/pay/redirect?order_id=" +
          order.order_id +
          "&payment_scene=" +
          paymentScene +
          "&scene=" +
          paymentScene +
          "&payment=" +
          payment +
          "&token=" +
          getToken() +
          "&s_url=" +
          sUrl +
          "&f_url=" +
          encodeURIComponent(host);
      } else if (payment === "handPay") {
        navigate(
          "/order/pay?orderId=" +
            order.order_id +
            "&price=" +
            totalVal +
            "&payment=" +
            payment +
            "&type=" +
            goods.type +
            "&id=" +
            goods.id,
          { replace: true }
        );
      } else {
        Toast.show("无法支付");
      }
    }
  };

  return (
    <div className={styles["container"]}>
      <NavHeader text="收银台" />
      {openmask && (
        <div className={styles["mask"]}>
          <div className={styles["popup"]}>
            <div className={styles["cancel"]} onClick={() => cancel()}>
              <img src={closeIcon} />
            </div>
            <div className={styles["input-box"]}>
              <Input
                className={styles["input-item"]}
                placeholder="请输入优惠码"
                value={promoCode}
                onChange={(e: any) => {
                  setPromoCode(e);
                }}
              />
            </div>
            <div className={styles["confirm"]} onClick={() => checkPromoCode()}>
              验证
            </div>
          </div>
        </div>
      )}
      <div className={styles["goods-box"]}>
        <div className={styles["tit"]}>商品信息</div>
        <div className={styles["goods-item"]}>
          <div className={styles["goods-thumb"]}>
            {goods.icon ? <img src={goods.icon} /> : <img src={vipIcon} />}
          </div>
          <div className={styles["goods-info"]}>
            <div className={styles["goods-name"]}>{goods.name}</div>
            <div className={styles["goods-label"]}>{goods.label}</div>
            <div className={styles["goods-charge"]}>￥{total}</div>
          </div>
        </div>
      </div>
      <div className={styles["promocode-box"]} onClick={() => openPromo()}>
        {!isUsed && <div className={styles["info"]}>使用优惠码</div>}
        {isUsed && configTip === 0 && (
          <div className={styles["tip"]}>此优惠码无效，请重新输入验证</div>
        )}
        {isUsed && configTip === 1 && (
          <div className={styles["tip"]}>优惠码已抵扣10元{discount}元</div>
        )}
        <img src={prevIcon} />
      </div>
      <div className={styles["credit2-box"]}>
        {payments.map((item: any) => (
          <div
            className={
              item.sign === payment
                ? `${styles["payment-item"]} ${styles["active"]}`
                : styles["payment-item"]
            }
            key={item.sign}
            onClick={() => setPayment(item.sign)}
          >
            {item.sign === "alipay" && (
              <img className={styles["icon"]} src={aliIcon} />
            )}
            {(item.sign === "wechat-jsapi" || item.sign === "wechat_h5") && (
              <img className={styles["icon"]} src={wechatIcon} />
            )}
            {item.sign === "handPay" && (
              <img className={styles["icon"]} src={handIcon} />
            )}
            <span>{item.name}</span>
            <div className={styles["sel"]}>
              {item.sign === payment ? (
                <img src={selIcon} />
              ) : (
                <img src={unSelIcon} />
              )}
            </div>
          </div>
        ))}
      </div>
      <div className={styles["box-footer"]}>
        <div className={styles["price-box"]}>
          总计￥<span className={styles["big"]}>{totalVal}</span>
        </div>
        <div className={styles["btn-submit"]} onClick={() => payHandler()}>
          提交订单
        </div>
      </div>
    </div>
  );
};

export default OrderPage;
