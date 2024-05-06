import { Button } from "antd";
import { useSelector } from "react-redux";

interface PropInterface {
  type: "link" | "text" | "primary" | "default" | "danger";
  text: string;
  p: any;
  class: string;
  icon: any;
  onClick: () => void;
  disabled: any;
  loading?: boolean;
}

export const PerButton = (props: PropInterface) => {
  const user = useSelector((state: any) => state.loginUser.value.user);
  const isThrough = () => {
    if (!user.permissions) {
      return false;
    }
    if (Array.isArray(props.p)) {
      let key = false;
      if (props.p) {
        for (let i = 0; i < props.p.length; i++) {
          if (typeof user.permissions[props.p[i]] !== "undefined") {
            key = true;
          }
        }
      }
      return key;
    } else {
      return typeof user.permissions[props.p] !== "undefined";
    }
  };
  return (
    <>
      {isThrough() && props.type === "link" && (
        <Button
          size="small"
          className={props.class === "c-red" ? "c-red-link" : props.class}
          type="link"
          icon={props.icon}
          onClick={() => {
            props.onClick();
          }}
          disabled={props.disabled}
        >
          {props.text}
        </Button>
      )}
      {isThrough() && props.type !== "link" && props.type === "danger" && (
        <Button
          className={props.class}
          type="primary"
          icon={props.icon}
          onClick={() => {
            props.onClick();
          }}
          disabled={props.disabled}
          danger
        >
          {props.text}
        </Button>
      )}
      {isThrough() && props.type !== "link" && props.type !== "danger" && (
        <Button
          className={props.class}
          type={props.type}
          icon={props.icon}
          onClick={() => {
            props.onClick();
          }}
          disabled={props.disabled}
          loading={props.loading}
        >
          {props.text}
        </Button>
      )}
    </>
  );
};
