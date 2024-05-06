import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { order } from "../../api/index";
import { Input, message, Button } from "antd";
import { ThumbBar } from "../../components";
import { useSelector } from "react-redux";
import { useNavigate, useLocation } from "react-router-dom";
import defaultPaperIcon from "../../assets/img/commen/default-paper.png";
import defaultVipIcon from "../../assets/img/commen/default-vip.png";
import zfbIcon from "../../assets/img/commen/icon-zfb.png";
import wepayIcon from "../../assets/img/commen/icon-wepay.png";
import cradIcon from "../../assets/img/commen/icon-crad.png";
import { getAppUrl, getToken } from "../../utils/index";

const OrderPage = () => {
  document.title = "收银台";
  const navigate = useNavigate();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState<boolean>(false);
  const [payment, setPayment] = useState<string>("");
  const [payments, setPayments] = useState<any>([]);
  const [paymentScene] = useState<string>("pc");
  const [promoCode, setPromoCode] = useState<string>("");
  const [promoCodeModel, setPromoCodeModel] = useState<any>(null);
  const [pcCheckLoading, setPcCheckLoading] = useState(false);
  const [aliStatus, setAliStatus] = useState<boolean>(false);
  const [weStatus, setWeStatus] = useState<boolean>(false);
  const [handStatus, setHandStatus] = useState<boolean>(false);
  const [hasThumb, setHasThumb] = useState<boolean>(false);
  const [configTip, setConfigTip] = useState<number>(999);
  const [discount, setDiscount] = useState<number>(0);
  const [goodsType] = useState(result.get("goods_type"));
  const [goodsId] = useState(Number(result.get("goods_id")));
  const [goodsThumb] = useState<string>(String(result.get("goods_thumb")));
  const [goodsName] = useState(result.get("goods_name"));
  const [goodsLabel] = useState(result.get("goods_label"));
  const [courseId] = useState(Number(result.get("course_id")));
  const [courseType] = useState(result.get("course_type"));
  const [total] = useState<number>(Number(result.get("goods_charge")));
  const [totalVal, setTotalVal] = useState<number>(0);
  const configFunc = useSelector(
    (state: any) => state.systemConfig.value.configFunc
  );
  const systemConfig = useSelector(
    (state: any) => state.systemConfig.value.config
  );

  useEffect(() => {
    initData();
  }, [goodsType]);

  useEffect(() => {
    let val = total - discount;
    val = val < 0 ? 0 : val;
    setTotalVal(val);
  }, [total, discount]);

  useEffect(() => {
    let data = [];
    if (aliStatus) {
      data.push({
        name: "支付宝",
        sign: "alipay",
      });
    }
    if (weStatus) {
      data.push({
        name: "微信支付",
        sign: "wechat",
      });
    }
    if (handStatus) {
      data.push({
        name: "手动打款",
        sign: "handPay",
      });
    }
    setPayments(data);
  }, [aliStatus, weStatus, handStatus]);

  const initData = () => {
    if (goodsType === "role") {
      setHasThumb(true);
    } else if (goodsType === "vod") {
      setHasThumb(true);
    } else if (goodsType === "live") {
      setHasThumb(true);
    } else if (goodsType === "video") {
      setHasThumb(true);
    }
    params();
  };

  const params = () => {
    order
      .payments({
        scene: "pc",
      })
      .then((res: any) => {
        let payments = res.data;
        for (let i = 0; i < payments.length; i++) {
          setPayment(payments[0].sign);
          if (payments[i].sign === "alipay") {
            setAliStatus(true);
          } else if (payments[i].sign === "wechat") {
            setWeStatus(true);
          } else if (payments[i].sign === "handPay") {
            setHandStatus(true);
          }
        }
      });
  };

  const checkPromoCode = () => {
    if (loading) {
      return;
    }
    if (!promoCode) {
      return;
    }
    setPcCheckLoading(true);
    if (
      configFunc.share &&
      (promoCode.substr(0, 1) === "u" || promoCode.substr(0, 1) === "U")
    ) {
      setConfigTip(0);
      return;
    }
    setConfigTip(999);
    setLoading(true);
    order
      .promoCodeCheck(promoCode)
      .then((res: any) => {
        if (res.data.can_use !== 1) {
          setConfigTip(0);
        } else {
          setConfigTip(1);
          setPromoCodeModel(res.data.promo_code);
          let value = parseInt(res.data.promo_code.invited_user_reward);
          setDiscount(value);
        }
        setLoading(false);
        setPcCheckLoading(false);
      })
      .catch((e) => {
        setLoading(false);
        setConfigTip(999);
        setPcCheckLoading(false);
      });
  };

  const payHandler = () => {
    if (!payment) {
      message.error("请选择支付方式");
      return;
    }
    if (loading) {
      return;
    }
    setLoading(true);
    if (goodsType === "vod") {
      // 点播课程
      order
        .createCourseOrder({
          course_id: goodsId,
          promo_code: promoCode,
        })
        .then((res: any) => {
          orderCreatedHandler(res.data);
        })
        .catch((e) => {
          setLoading(false);
        });
    } else if (goodsType === "video") {
      // 视频
      order
        .createVideoOrder({
          video_id: goodsId,
          promo_code: promoCode,
        })
        .then((res: any) => {
          orderCreatedHandler(res.data);
        })
        .catch((e) => {
          setLoading(false);
        });
    } else if (goodsType === "role") {
      order
        .createRoleOrder({
          role_id: goodsId,
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

  const orderCreatedHandler = (data: any) => {
    setLoading(false);
    // 判断是否继续走支付平台支付
    if (data.status_text === "已支付") {
      // 优惠全部抵扣
      message.success("支付成功");

      setTimeout(() => {
        navigate(-1);
      }, 1000);
    } else {
      if (payment === "alipay") {
        let host = getAppUrl();
        let redirect = encodeURIComponent(host + "/success");
        let indexUrl = encodeURIComponent(host + "/");
        window.location.href =
          systemConfig.url +
          "/api/v2/order/pay/redirect?order_id=" +
          data.order_id +
          "&payment_scene=" +
          paymentScene +
          "&scene=" +
          paymentScene +
          "&payment=" +
          payment +
          "&token=" +
          getToken() +
          "&redirect=" +
          redirect +
          "&cancel_redirect=" +
          indexUrl;
      } else if (payment === "handPay" || payment === "wechat") {
        navigate(
          "/order/pay?orderId=" +
            data.order_id +
            "&price=" +
            totalVal +
            "&payment=" +
            payment +
            "&type=" +
            goodsType +
            "&id=" +
            goodsId +
            "&course_id=" +
            courseId +
            "&course_type=" +
            courseType
        );
      } else {
        payFailure();
      }
    }
  };

  const payFailure = () => {
    message.error("无法支付");
    setLoading(false);
  };

  return (
    <div className="container">
      <div className={styles["box"]}>
        <div className={styles["tit"]}>订阅信息</div>
        <div className={styles["goods-box"]}>
          {hasThumb && (
            <div className={styles["goods-thumb"]}>
              {goodsType === "book" ? (
                <ThumbBar
                  value={goodsThumb}
                  width={90}
                  height={120}
                  border={4}
                ></ThumbBar>
              ) : goodsType === "mockpaper" ||
                goodsType === "paper" ||
                goodsType === "practice" ? (
                <img
                  style={{ width: 160, height: 120, borderRadius: 4 }}
                  src={defaultPaperIcon}
                />
              ) : goodsType === "role" ? (
                <img
                  style={{ width: 160, height: 120, borderRadius: 4 }}
                  src={defaultVipIcon}
                />
              ) : (
                <ThumbBar
                  value={goodsThumb}
                  width={160}
                  height={120}
                  border={4}
                ></ThumbBar>
              )}
            </div>
          )}
          <div className={styles["goods-info"]}>
            <div className={styles["goods-name"]}>{goodsName}</div>
            <div className={styles["goods-label"]}>{goodsLabel}</div>
          </div>
          <div className={styles["goods-charge"]}>
            <span className={styles["small"]}>￥</span>
            {total}
          </div>
        </div>
        {goodsType !== "ms" && goodsType !== "tg" && (
          <>
            <div className={styles["tit"]}>优惠码</div>
            <div className={styles["promocode-box"]}>
              <Input
                className={styles["input"]}
                value={promoCode}
                placeholder="请输入优惠码"
                onChange={(e) => {
                  setPromoCode(e.target.value);
                }}
                disabled={pcCheckLoading}
              ></Input>
              <div
                className={styles["btn-confirm"]}
                onClick={() => checkPromoCode()}
              >
                验证
              </div>
              {configTip === 0 && (
                <div className={styles["tip"]}>
                  此优惠码无效，请重新输入验证
                </div>
              )}
              {configTip === 1 && (
                <div className={styles["tip"]}>
                  此优惠码有效，已减免{discount <= total ? discount : total}元
                </div>
              )}
            </div>
          </>
        )}
        <div className={styles["tit"]}>支付方式</div>
        <div className={styles["credit2-box"]}>
          {payments.map((item: any) => (
            <div
              key={item.sign}
              className={
                item.sign === payment
                  ? styles["payment-active-item"]
                  : styles["payment-item"]
              }
              onClick={() => setPayment(item.sign)}
            >
              {item.sign === "alipay" && <img src={zfbIcon} />}
              {item.sign === "wechat" && <img src={wepayIcon} />}
              {item.sign === "handPay" && <img src={cradIcon} />}
            </div>
          ))}
        </div>
        <div className={styles["line"]}></div>
        <div className={styles["price-box"]}>
          {goodsType !== "ms" && goodsType !== "tg" && (
            <>
              <span>优惠码已减</span>
              <span className={styles["red"]}>
                {discount <= total ? discount : total}
              </span>
              <span>元，</span>
            </>
          )}
          <span>需支付</span>
          <span className={styles["red"]}>
            ￥<span className={styles["big"]}>{totalVal}</span>
          </span>
        </div>
        <div className={styles["order-tip"]}>请在15分钟内支付完成</div>
        <Button
          type="primary"
          loading={loading}
          className={styles["btn-submit"]}
          onClick={() => payHandler()}
        >
          提交订单
        </Button>
      </div>
    </div>
  );
};

export default OrderPage;
