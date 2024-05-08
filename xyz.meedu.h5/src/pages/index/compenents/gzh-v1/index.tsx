import styles from "./index.module.scss";
import React, { useState } from "react";
import icon from "../../../../assets/img/topright.png";

interface PropInterface {
  render: any;
}

export const IndexGzhV1: React.FC<PropInterface> = ({ render }) => {
  const [dialogStatus, setDialogStatus] = useState<boolean>(false);

  const cancel = () => {
    setDialogStatus(false);
  };

  const follow = () => {
    setDialogStatus(true);
  };

  return (
    <>
      {render ? (
        <div className={styles["gzh-box"]}>
          {dialogStatus ? (
            <div className={styles["mask"]} onClick={() => cancel()}>
              <div
                className={styles["modal"]}
                onClick={(e) => {
                  e.stopPropagation();
                  follow();
                }}
              >
                <img className={styles["top-right"]} src={icon} />
                <div className={styles["title"]}>关注公众号</div>
                <div className={styles["body"]}>
                  <div className={styles["qrcode"]}>
                    {render.qrcode && <img src={render.qrcode} />}
                  </div>
                </div>
                <div className={styles["tip"]}>长按二维码识别或截图保存</div>
              </div>
            </div>
          ) : null}
          <div className={styles["gzh-left"]}>
            <div className={styles["avatar"]}>
              {render.logo && <img src={render.logo} />}
            </div>
            <div className={styles["info"]}>
              <span className={styles["name"]}>{render.name}</span>
              <span className={styles["desc"]}>{render.desc}</span>
            </div>
          </div>
          <div className={styles["gzh-right"]}>
            <div className={styles["btn"]} onClick={() => follow()}>
              关注
            </div>
          </div>
        </div>
      ) : null}
    </>
  );
};
