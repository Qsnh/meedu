import React, { useState, useEffect } from "react";
import { QRCode, Modal, Button } from "antd";
import { system } from "../../api/index";
import styles from "./index.module.scss";
import { useSelector } from "react-redux";
import closeIcon from "../../assets/img/close.png";

interface PropInterface {
  open: boolean;
  onCancel: () => void;
}

export const StudentDeviceDialog: React.FC<PropInterface> = ({
  open,
  onCancel,
}) => {
  const systemUrl = useSelector(
    (state: any) => state.systemConfig.value.system.url
  );
  const [loading, setLoading] = useState<boolean>(false);
  const [qrode, setQrode] = useState<string>("");
  const [pcUrl, setPcUrl] = useState<string>("");

  useEffect(() => {
    if (open) {
      getData();
    }
  }, [open, systemUrl]);

  const getData = () => {
    setPcUrl(systemUrl.pc);
    setQrode(systemUrl.h5);
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
