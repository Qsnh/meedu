import styles from "./index.module.scss";
import { CloseCircleOutlined } from "@ant-design/icons";

export const CloseIcon = () => {
  return (
    <div className={styles["btn-close-icon"]}>
      <CloseCircleOutlined />
    </div>
  );
};
