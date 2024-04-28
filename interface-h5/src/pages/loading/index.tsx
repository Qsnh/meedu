import { SpinLoading } from "antd-mobile";

const LoadingPage = () => {
  return (
    <div
      style={{
        width: "100vw",
        height: "100vh",
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
      }}
    >
      <SpinLoading color="primary" />
    </div>
  );
};

export default LoadingPage;
