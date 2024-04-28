import styles from "./index.module.scss";
import icon from "../../assets/img/img-placeholder.png";

interface PropInterface {
  type: string;
}

export const None: React.FC<PropInterface> = ({ type }) => {
  return (
    <div
      className={
        type === "white"
          ? `${styles["none"]} ${styles["active"]}`
          : type === "gray"
          ? `${styles["none"]} ${styles["gray"]}`
          : styles["none"]
      }
    >
      <div className={styles["empty-box"]}>
        <div className={styles["image-empty-item"]}>
          <img src={icon} />
        </div>
      </div>
    </div>
  );
};
