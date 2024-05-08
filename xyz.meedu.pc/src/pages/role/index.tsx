import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { role } from "../../api/index";
import { useSelector } from "react-redux";
import { useNavigate, useLocation } from "react-router-dom";
import vipIcon from "../../assets/img/commen/icon-VIP.png";

const RolePage = () => {
  document.title = "会员中心";
  const navigate = useNavigate();
  const [list, setList] = useState<any>([]);
  const isLogin = useSelector((state: any) => state.loginUser.value.isLogin);

  useEffect(() => {
    getRoles();
  }, []);

  const getRoles = () => {
    role.list().then((res: any) => {
      setList(res.data);
    });
  };

  const goLogin = () => {
    let url = encodeURIComponent(
      window.location.pathname + window.location.search
    );
    navigate("/login?redirect=" + url);
  };

  const parRoles = (id: number, name: string, charge: number) => {
    if (!isLogin) {
      goLogin();
      return;
    }
    navigate(
      "/order?goods_id=" +
        id +
        "&goods_type=role&goods_charge=" +
        charge +
        "&goods_label=VIP会员&goods_name=" +
        name
    );
  };

  return (
    <div className={styles["content"]}>
      <div className={styles["box"]}>
        <div className={styles["title"]}>
          <img src={vipIcon} />
          <span>请选择会员套餐</span>
        </div>
        <div className={styles["role-item-box"]}>
          {list.map((item: any) => (
            <div key={item.id} className={styles["role-item"]}>
              <div className={styles["name"]}>{item.name}</div>
              <div className={styles["price"]}>
                <span className={styles["small"]}>￥</span>
                {item.charge}
                <span className={styles["small"]}>/{item.expire_days}天</span>
              </div>
              <div className={styles["desc"]}>
                {item.desc_rows.map((it: any, index: number) => (
                  <p key={index}>{it}</p>
                ))}
              </div>
              <div
                className={styles["button"]}
                onClick={() => parRoles(item.id, item.name, item.charge)}
              >
                购买
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default RolePage;
