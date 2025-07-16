import { useEffect, useState } from "react";
import styles from "./index.module.scss";
import { Input, Toast } from "antd-mobile";
import { useSelector } from "react-redux";
import { useLocation, useNavigate } from "react-router-dom";
import NavHeader from "../../components/nav-header";
import { order } from "../../api/index";
import { getHost } from "../../utils";
import closeIcon from "../../assets/img/close.png";
import vipIcon from "../../assets/img/default-vip.png";
import prevIcon from "../../assets/img/icon-prev.png";
import { RootState } from "../../store";
import { AppConfigInterface } from "../../store/system/systemConfigSlice";

const OrderPage = () => {
  const navigate = useNavigate();
  const result = new URLSearchParams(useLocation().search);
  const config: AppConfigInterface = useSelector(
    (state: RootState) => state.systemConfig.value
  );
  const [loading, setLoading] = useState(false);
  const [openmask, setOpenmask] = useState(false);
  const [isUsed] = useState(false);
  const [promoCode, setPromoCode] = useState<any>("");
  const [configTip, setConfigTip] = useState(2);
  const [total] = useState(Number(result.get("goods_charge")));
  const [goods, setGoods] = useState<any>({});
  const [totalVal, setTotalVal] = useState(0);
  const [discount, setDiscount] = useState(0);
  const [, setPromoCodeModel] = useState<any>(null);
  const [openmask2, setOpenmask2] = useState(false);
  const [openVodProtocolMask, setOpenVodProtocolMask] = useState(false);

  useEffect(() => {
    document.title = "收银台";
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

  const submitProtocol = () => {
    setLoading(true);
    order
      .CreateOrder({
        goods_type: "ROLE",
        goods_id: goods.id,
        promo_code: promoCode,
        agree_protocol: 1,
      })
      .then((res: any) => {
        orderCreatedHandler(res.data);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  // 录播课协议确认后创建订单
  const submitVodProtocol = () => {
    setLoading(true);
    order
      .CreateOrder({
        goods_type: "COURSE",
        goods_id: goods.id,
        promo_code: promoCode,
        agree_protocol: 1, // 添加协议同意标识
      })
      .then((res: any) => {
        orderCreatedHandler(res.data);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const payHandler = () => {
    if (loading) {
      return;
    }
    if (goods.type === "role") {
      setOpenmask2(true);
      return;
    }
    
    // 录播课和视频都需要协议确认
    if (goods.type === "vod" || goods.type === "video") {
      setOpenVodProtocolMask(true);
      return;
    }
    
    // 其他类型商品的处理逻辑（如果有）
    setLoading(true);
    // ... 其他商品类型的处理
  };

  const orderCreatedHandler = (order: any) => {
    setLoading(false);
    // 判断是否继续走支付平台支付
    if (order.is_paid === true) {
      // 优惠全部抵扣
      Toast.show("支付成功");
      setTimeout(() => {
        navigate(-1);
      }, 1000);
    } else {
      let host = getHost();
      let sUrl = encodeURIComponent(host + "/order/success");
      let fUrl = encodeURIComponent(host);
      window.location.href = order.pay_url + `&s_url=${sUrl}&f_url=${fUrl}`;
    }
  };

  const openPage = (url: string) => {
    window.open(url);
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
      {openmask2 && (
        <div className={styles["mask"]}>
          <div className={styles["dialog-box"]}>
            <div className={styles["dialog-header"]}>提示</div>
            <div className={styles["dialog-content"]}>
              我已阅读并同意
              <span onClick={() => openPage(config.vip_protocol)}>
                《会员服务协议》
              </span>
            </div>
            <div className={styles["dialog-bottom"]}>
              <div
                className={styles["button2"]}
                onClick={() => setOpenmask2(false)}
              >
                取消
              </div>
              <div
                className={styles["button"]}
                onClick={() => submitProtocol()}
              >
                阅读并同意
              </div>
            </div>
          </div>
        </div>
      )}
      {/* 付费内容购买协议确认弹窗 */}
      {openVodProtocolMask && (
        <div className={styles["mask"]}>
          <div className={styles["dialog-box"]}>
            <div className={styles["dialog-header"]}>协议确认</div>
            <div className={styles["dialog-content"]}>
              购买付费内容前，请仔细阅读并同意
              <span onClick={() => openPage(config.paid_content_purchase_protocol)}>
                《付费内容购买协议》
              </span>
              ，了解您的权利和义务。
            </div>
            <div className={styles["dialog-bottom"]}>
              <div
                className={styles["button2"]}
                onClick={() => setOpenVodProtocolMask(false)}
              >
                取消
              </div>
              <div
                className={styles["button"]}
                onClick={() => submitVodProtocol()}
              >
                阅读并同意
              </div>
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
