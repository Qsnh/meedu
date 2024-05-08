import { InfoCircleOutlined } from "@ant-design/icons";

interface PropInterface {
  text: string;
}

export const HelperText = (props: PropInterface) => {
  return (
    <div className="helper-text">
      <InfoCircleOutlined />
      <span className="ml-5">{props.text}</span>
    </div>
  );
};
