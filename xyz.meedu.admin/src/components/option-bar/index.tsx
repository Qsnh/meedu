import styles from "./index.module.scss";
import { useNavigate } from "react-router-dom";
import icon from "../../assets/images/config/icon-option.png";

interface PropInterface {
  text: string;
  value: string;
}

export const OptionBar = (props: PropInterface) => {
  const navigate = useNavigate();
  const goRouter = () => {
    navigate(props.value);
  };

  return (
    <div className={styles["options-link"]}>
      <div className={styles["link"]} onClick={() => goRouter()}>
        <img src={icon} />
        {props.text}
      </div>
    </div>
  );
};
