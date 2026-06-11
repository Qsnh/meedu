import { useEffect, useState } from "react";
import { useRoutes } from "react-router-dom";
import { useDispatch } from "react-redux";
import { Spin } from "antd";
import routes from "./routes";
import "./App.scss";
import { Suspense } from "react";
import LoadingPage from "./pages/loading";
import { setup as setupApi } from "./api";
import { setNeedsInit } from "./store/system/systemSetupSlice";
import { clearToken } from "./utils";

function App() {
  const Views = () => useRoutes(routes);
  const dispatch = useDispatch();
  const [gateReady, setGateReady] = useState(false);
  const [gateError, setGateError] = useState(false);

  useEffect(() => {
    let cancelled = false;
    setupApi
      .getSetupStatus()
      .then((res: any) => {
        if (cancelled) return;
        const needsInit = Boolean(res?.data?.needs_init);
        dispatch(setNeedsInit(needsInit));
        if (needsInit) {
          // 清除可能残留的 token，避免旧 token 把用户挡在 setup 之外
          clearToken();
          if (
            window.location.pathname !== "/setup" &&
            window.location.pathname !== "/error"
          ) {
            window.location.replace("/setup");
            return;
          }
        } else {
          if (window.location.pathname === "/setup") {
            window.location.replace("/login");
            return;
          }
        }
        setGateReady(true);
      })
      .catch(() => {
        if (cancelled) return;
        setGateError(true);
      });
    return () => {
      cancelled = true;
    };
  }, [dispatch]);

  if (gateError) {
    return (
      <div
        style={{
          minHeight: "100vh",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
          flexDirection: "column",
          gap: 16,
        }}
      >
        <div>系统状态获取失败，请刷新重试</div>
      </div>
    );
  }

  if (!gateReady) {
    return (
      <div
        style={{
          minHeight: "100vh",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
        }}
      >
        <Spin size="large" />
      </div>
    );
  }

  return (
    <Suspense fallback={<LoadingPage />}>
      <Views />
    </Suspense>
  );
}

export default App;
