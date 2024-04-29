import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { message, Modal, Image } from "antd";
import { user } from "../../../../api/index";
import closeIcon from "../../../../assets/img/commen/icon-close.png";

interface PropInterface {
  open: boolean;
  onCancel: () => void;
  success: () => void;
}

var timer: any = null;

export const BindWeixinDialog: React.FC<PropInterface> = ({
  open,
  onCancel,
  success,
}) => {
  const [qrode, setQrode] = useState<string>("");
  const [code, setCode] = useState<string>("");

  useEffect(() => {
    if (open) {
      getBindQrode();
    }
    return () => {
      timer && clearInterval(timer);
    };
  }, [open]);

  const getBindQrode = () => {
    user.wechatBind().then((res: any) => {
      setQrode(res.data.image);
      setCode(res.data.code);
      timer = setInterval(() => checkWechatBind(), 3000);
    });
  };

  const checkWechatBind = () => {
    user.detail().then((res: any) => {
      if (res.data.is_bind_wechat === 1) {
        message.success("绑定成功");
        timer && clearInterval(timer);
        success();
      }
    });
  };

  return (
    <>
      {open ? (
        <Modal
          title=""
          centered
          forceRender
          open={true}
          width={500}
          footer={null}
          onCancel={() => {
            timer && clearInterval(timer);
            onCancel();
          }}
          maskClosable={false}
          closable={false}
        >
          <div className={styles["tabs"]}>
            <div className={styles["tab-active-item"]}>绑定微信</div>
            <img
              className={styles["btn-close"]}
              onClick={() => {
                timer && clearInterval(timer);
                onCancel();
              }}
              src={closeIcon}
            />
          </div>
          <div className={styles["box"]}>
            <Image width={300} height={300} src={qrode} preview={false} />
          </div>
        </Modal>
      ) : null}
    </>
  );
};
