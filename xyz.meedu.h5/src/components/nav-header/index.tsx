import { useNavigate } from "react-router-dom";
import icon from "../../assets/img/icon-back.png";

interface PropsInterafce {
  text: string;
  noBorder?: boolean;
}

export default function NavHeader(props: PropsInterafce) {
  const navigate = useNavigate();

  return (
    <div
      className="navheader borderbox"
      style={{ borderBottom: props.noBorder ? "none" : "1px solid #f1f2f6" }}
    >
      <img
        className="back"
        onClick={() => {
          if (window.history.length <= 2) {
            navigate("/");
          } else {
            navigate(-1);
          }
        }}
        src={icon}
      />
      {props.text && <div className="title">{props.text}</div>}
    </div>
  );
}
