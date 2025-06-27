import React, { useState, useEffect } from "react";
import { useNavigate, useLocation } from "react-router-dom";
import styles from "./index.module.scss";
import { useDispatch, useSelector } from "react-redux";
import type { RootState } from "../../store";
import { saveUnread } from "../../store/user/loginUserSlice";
import { user as member } from "../../api/index";

interface PropInterface {
  cid: number;
  refresh: boolean;
}

export const NavMember: React.FC<PropInterface> = ({ cid, refresh }) => {
  const navigate = useNavigate();
  const dispatch = useDispatch();
  const [id, setId] = useState(cid);
  const [menus, setMenus] = useState<any>([]);
  const [hasMessage, setHasMessage] = useState<boolean>(false);
  const configFunc = useSelector(
    (state: RootState) => state.systemConfig.value.configFunc
  );
  const isLogin = useSelector((state: RootState) => state.loginUser.value.isLogin);
  const freshUnread = useSelector(
    (state: RootState) => state.loginUser.value.freshUnread
  );

  useEffect(() => {
    if (configFunc) {
      let menus = [
        {
          name: "用户",
          status: true,
          childrens: [
            {
              name: "所有订单",
              id: 6,
              path: "/member/orders",
              status: true,
            },
            {
              name: "我的消息",
              id: 7,
              path: "/member/messages",
              status: true,
            },
            {
              name: "我的积分",
              id: 18,
              path: "/member/credit1-free",
              status: true,
            },
          ],
        },
      ];
      setMenus(menus);
    }
  }, [configFunc]);

  useEffect(() => {
    if (isLogin) {
      getUnread();
    }
  }, [isLogin, refresh]);

  const setScene = (val: any) => {
    navigate(val);
  };

  const getUnread = () => {
    member.unReadNum().then((res: any) => {
      let num = res.data;
      if (num === 0) {
        setHasMessage(false);
        dispatch(saveUnread(false));
      } else {
        setHasMessage(true);
      }
    });
  };

  return (
    <div className={styles["nav-box"]}>
      <div className={styles["nav-content"]}>
        <div
          className={id === 0 ? styles["active-spItem"] : styles["spItem"]}
          onClick={() => navigate("/member")}
        >
          用户中心
        </div>
        {menus.map((item: any, index: number) => (
          <div key={index}>
            {item.status && (
              <div className={styles["menus-item"]}>
                {item.childrens.length > 0 &&
                  item.childrens.map((child: any) => (
                    <div key={child.id} className={styles["item"]}>
                      {child.status && (
                        <div
                          className={
                            id === child.id
                              ? styles["active-item-children"]
                              : styles["item-children"]
                          }
                          onClick={() => setScene(child.path)}
                        >
                          {child.name}
                          {hasMessage && child.id === 7 && (
                            <div className={styles["point"]}></div>
                          )}
                        </div>
                      )}
                    </div>
                  ))}
              </div>
            )}
          </div>
        ))}
      </div>
    </div>
  );
};
