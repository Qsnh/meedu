import React, { useState } from "react";
import { useSelector } from "react-redux";
import styles from "./index.module.scss";
import { TencentFaceCheck } from "../../../../components";
import faceSuccessIcon from "../../../../assets/img/commen/faceSuccess.png";
import noFacecheckIcon from "../../../../assets/img/commen/no-facecheck.png";
interface PropInterface {
  refresh: () => void;
}

export const ProfileComp: React.FC<PropInterface> = ({ refresh }) => {
  const [faceCheckVisible, setFaceCheckVisible] = useState<boolean>(false);
  const user = useSelector((state: any) => state.loginUser.value.user);

  const showFaceCheck = () => {
    setFaceCheckVisible(true);
  };

  const faceChecksuccess = () => {
    setFaceCheckVisible(false);
    refresh();
  };

  return (
    <div className={styles["pro-box"]}>
      <TencentFaceCheck
        open={faceCheckVisible}
        active={true}
        onCancel={() => setFaceCheckVisible(false)}
        success={() => faceChecksuccess()}
      />
      <div className={styles["result"]}>
        {user.is_face_verify && (
          <img className={styles["thumb"]} src={faceSuccessIcon} />
        )}
        {!user.is_face_verify && (
          <img className={styles["thumb"]} src={noFacecheckIcon} />
        )}
      </div>
      {user.is_face_verify && (
        <div className={styles["profile"]}>
          <div className={styles["profile-item"]}>
            <span className={styles["label"]}>姓名</span>
            <span>{user.profile_real_name}</span>
          </div>
          <div className={styles["profile-item"]}>
            <span className={styles["label"]}>身份证号</span>
            <span>{user.profile_id_number}</span>
          </div>
        </div>
      )}
      {!user.is_face_verify && (
        <div className={styles["btn-box"]}>
          <div
            className={styles["button-submit"]}
            onClick={() => showFaceCheck()}
          >
            开始认证
          </div>
        </div>
      )}
    </div>
  );
};
