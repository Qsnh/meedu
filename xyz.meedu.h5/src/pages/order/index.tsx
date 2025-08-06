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
  const [total] = useState(Number(result.get("goods_charge")));
  const [goods, setGoods] = useState<any>({});
  const [totalVal, setTotalVal] = useState(0);
  const [openmask2, setOpenmask2] = useState(false);

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
    setTotalVal(total);
  }, [total]);

  const submitProtocol = () => {
    setLoading(true);
    order
      .CreateOrder({
        goods_type: "ROLE",
        goods_id: goods.id,
        agree_protocol: 1,
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
    setLoading(true);
    if (goods.type === "vod") {
      order
        .CreateOrder({
          goods_type: "COURSE",
          goods_id: goods.id,
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
        .CreateOrder({
          goods_type: "COURSE",
          goods_id: goods.id,
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
