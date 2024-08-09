import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { useSelector } from "react-redux";
import icon from "../../assets/img/new/agree.png";

interface PropInterface {
  type: string;
  agree: (agree: boolean) => void;
}

export const Protocol: React.FC<PropInterface> = ({ type, agree }) => {
  const [isAgree, setIsAgree] = useState(false);
  const config = useSelector((state: any) => state.systemConfig.value);

  useEffect(() => {
    agree(isAgree);
  }, [isAgree]);

  const agreeHandle = () => {
    setIsAgree(!isAgree);
  };

  const openPage = (url: string) => {
    window.open(url);
  };

  return (
    <>
      <div
        className={
          type === "wechat"
            ? `${styles["protocol"]} ${styles["active"]}`
            : styles["protocol"]
        }
        onClick={() => agreeHandle()}
      >
        {isAgree ? (
          <div className={styles["checkbox-dot"]}>
            <img src={icon} width={20} height={20} />
          </div>
        ) : (
          <div className={styles["checkbox-circle"]}></div>
        )}
        <div className={styles["protocol-text"]}>
          勾选同意
          <span
            className={styles["href"]}
            onClick={(e) => {
              e.stopPropagation();
              openPage(config.user_protocol);
            }}
          >
            《用户协议》
          </span>
          和
          <span
            className={styles["href"]}
            onClick={(e) => {
              e.stopPropagation();
              openPage(config.user_private_protocol);
            }}
          >
            《隐私协议》
          </span>
        </div>
      </div>
    </>
  );
};
