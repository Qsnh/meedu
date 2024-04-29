import { Spin } from "antd";

const AuthLoadingPage = () => {
  document.title = "加载中";

  return (
    <div
      style={{
        width: "100%",
        minHeight: 600,
        textAlign: "center",
        boxSizing: "border-box",
        paddingTop: 150,
      }}
    >
      <Spin />
    </div>
  );
};

export default AuthLoadingPage;
