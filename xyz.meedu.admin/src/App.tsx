import { useEffect, useState, Suspense } from "react";
import { useRoutes } from "react-router-dom";
import routes from "./routes";
import "./App.scss";
import LoadingPage from "./pages/loading";
import { setup as setupApi } from "./api";
import { clearToken } from "./utils";

function App() {
  const Views = () => useRoutes(routes);
  const [gateReady, setGateReady] = useState(false);

  useEffect(() => {
    // 已经停留在 /error 时不再触发门检，避免网络异常下的重定向循环
    if (window.location.pathname === "/error") {
      setGateReady(true);
      return;
    }
    let cancelled = false;
    setupApi
      .getSetupStatus()
      .then((res: any) => {
        if (cancelled) return;
        const needsInit = Boolean(res?.data?.needs_init);
        const pathname = window.location.pathname;
        if (needsInit) {
          // 清除可能残留的 token，避免旧 token 把用户挡在 setup 之外
          clearToken();
          if (pathname !== "/setup" && pathname !== "/error") {
            window.location.replace("/setup");
            return;
          }
        } else if (pathname === "/setup") {
          window.location.replace("/login");
          return;
        }
        setGateReady(true);
      })
      .catch(() => {
        if (cancelled) return;
        window.location.replace(
          "/error?msg=" + encodeURIComponent("系统状态获取失败，请刷新重试")
        );
      });
    return () => {
      cancelled = true;
    };
  }, []);

  if (!gateReady) {
    return <LoadingPage />;
  }

  return (
    <Suspense fallback={<LoadingPage />}>
      <Views />
    </Suspense>
  );
}

export default App;
