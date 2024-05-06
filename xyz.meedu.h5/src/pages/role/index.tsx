import { useEffect, useState } from "react";
import styles from "./index.module.scss";
import { Toast } from "antd-mobile";
import { useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import NavHeader from "../../components/nav-header";
import { role } from "../../api/index";

const RolePage = () => {
  const navigate = useNavigate();
  const [list, setList] = useState<any>([]);
  const [roleId, setRoleId] = useState(0);
  const user = useSelector((state: any) => state.loginUser.value.user);

  useEffect(() => {
    document.title = "VIP会员";
    getRoles();
  }, []);

  const getRoles = () => {
    role.List().then((res: any) => {
      setList(res.data);
    });
  };

  const goOrder = () => {
    if (roleId === 0) {
      Toast.show("请选择需要购买的会员");
      return;
    }
    let role: any = {};
    for (let i = 0; i < list.length; i++) {
      if (list[i].id === roleId) {
        role = list[i];
        break;
      }
    }
    navigate(
      `/order?goods_id=${role.id}&goods_name=${role.name}&goods_label=VIP会员&goods_charge=${role.charge}&goods_type=role`
    );
  };

  return (
    <div className={styles["container"]}>
      <NavHeader text="VIP会员" />
      {user && (
        <div className={styles["user-info"]}>
          <div className={styles["avatar"]}>
            <img src={user.avatar} />
          </div>
          <div className={styles["role-info"]}>
            {user.role ? (
              <div className={styles["info"]}>
                <div>
                  您的{user.role.name}
                  {user.role_expired_at}到期
                </div>
                <div>购买后将会有效期顺延</div>
              </div>
            ) : (
              <div className={styles["info"]}>
                <div>您还不是本站会员哦</div>
                <div>免费会员</div>
              </div>
            )}
          </div>
        </div>
      )}
      <div className={styles["role-item-box"]}>
        {list.length > 0 &&
          list.map((item: any) => (
            <div
              className={
                roleId === item.id
                  ? `${styles["role-item"]} ${styles["active"]}`
                  : styles["role-item"]
              }
              key={item.id}
              onClick={() => setRoleId(item.id)}
            >
              <div className={styles["name"]}>{item.name}</div>
              <div className={styles["price"]}>
                <span className={styles["small"]}>￥</span>
                {item.charge}
              </div>
              <div className={styles["desc"]}>
                {item.desc_rows.map((descItem: any, index: number) => (
                  <div key={index}>{descItem}</div>
                ))}
              </div>
            </div>
          ))}
      </div>
      <div className={styles["bottom-bar"]} onClick={() => goOrder()}>
        购买会员
      </div>
    </div>
  );
};

export default RolePage;
