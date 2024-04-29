import React, { useState, useEffect } from "react";
import { QRCode, Modal, Button } from "antd";
import { system } from "../../api/index";
import styles from "./index.module.scss";
import closeIcon from "../../assets/img/close.png";

interface PropInterface {
  open: boolean;
  onCancel: () => void;
}

export const StudentDeviceDialog: React.FC<PropInterface> = ({
  open,
  onCancel,
}) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [qrode, setQrode] = useState<string>("");
  const [pcUrl, setPcUrl] = useState<string>("");

  useEffect(() => {
    if (open) {
      getData();
    }
  }, [open]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    system.setting().then((res: any) => {
      let configData = res.data["系统"];
      for (let index in configData) {
        if (configData[index].key === "meedu.system.pc_url") {
          let url = configData[index].value;
          setPcUrl(url);
        } else if (configData[index].key === "meedu.system.h5_url") {
          let h5Url = configData[index].value;
          setQrode(h5Url);
        }
      }
      setTimeout(() => {
        setLoading(false);
      }, 500);
    });
  };

  const goPCDevice = () => {
    window.open(pcUrl);
  };

  return (
    <>
      {open ? (
        <Modal
          footer={null}
          title="访问学员端"
          onCancel={() => {
            onCancel();
          }}
          open={true}
          width={500}
          maskClosable={false}
          centered
        >
          <div className={styles["dialog-box"]}>
            <div className={styles["dialog-body"]}>
              {qrode === "" && <div className={styles["qrcode"]}></div>}
              {qrode !== "" && <QRCode size={150} value={qrode} />}
              <label>H5端扫码访问</label>
              <Button type="primary" onClick={() => goPCDevice()}>
                直接访问PC网校
              </Button>
            </div>
          </div>
        </Modal>
      ) : null}
    </>
  );
};
