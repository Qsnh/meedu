import React, { useState, useEffect } from "react";
import { Modal, message, Button, Col, Empty, Image } from "antd";
import { useSelector } from "react-redux";
import { member } from "../../../api/index";
import styles from "./my-profile.module.scss";

interface PropInterface {
  open: boolean;
  id: number;
  onCancel: () => void;
  onSuccess: () => void;
}

export const MyProfileDialog: React.FC<PropInterface> = ({
  open,
  id,
  onCancel,
  onSuccess,
}) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [user, setUser] = useState<any>({});

  useEffect(() => {
    if (id && open) {
      getUser();
    }
  }, [id, open]);

  const getUser = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    member
      .detail(id)
      .then((res: any) => {
        setUser(res.data.data);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const resetProfile = () => {
    member.resetProfile(id).then((res: any) => {
      setUser({});
      message.success("重置成功");
      onCancel();
    });
  };

  return (
    <>
      {open && (
        <Modal
          title="实名信息"
          onCancel={() => {
            onCancel();
          }}
          open={true}
          width={800}
          maskClosable={false}
          onOk={() => {}}
          centered
          footer={null}
        >
          {user.profile ? (
            <div className={styles["dialog-body"]}>
              <div className="d-flex">
                <Button
                  type="primary"
                  onClick={() => {
                    resetProfile();
                  }}
                >
                  重置实名信息
                </Button>
              </div>
              <div className={styles["panel-info-box"]}>
                <div className={styles["panel-info-item"]}>
                  真实姓名： {user.profile ? user.profile.real_name : ""}
                </div>
                <div className={styles["panel-info-item"]}>
                  身份证号码： {user.profile ? user.profile.id_number : ""}
                </div>
              </div>
              <div className="float-left mt-30">
                <div className={styles["info-item"]}>
                  <div className={styles["info-label"]}>认证照片：</div>
                  <div className={styles["info-value"]}>
                    {user.profile && user.profile.verify_image_url ? (
                      <Image
                        width={150}
                        height={200}
                        style={{ borderRadius: 8 }}
                        src={user.profile.verify_image_url}
                      ></Image>
                    ) : (
                      <div className={styles["image"]}></div>
                    )}
                  </div>
                </div>
              </div>
            </div>
          ) : (
            <div className={styles["dialog-body"]}>
              <Col span={24}>
                <Empty description="暂无实名信息" />
              </Col>
            </div>
          )}
        </Modal>
      )}
    </>
  );
};
