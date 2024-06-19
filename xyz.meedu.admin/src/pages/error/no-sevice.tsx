import { Result } from "antd";
import styles from "./index.module.scss";

const NoServicePage = () => {
  return <Result title="后端服务不可用" className={styles["main"]} />;
};

export default NoServicePage;
