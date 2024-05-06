import { useRoutes } from "react-router-dom";
import routes from "./routes";
import "./App.scss";
import { Suspense } from "react";
import LoadingPage from "./pages/loading";

function App() {
  const Views = () => useRoutes(routes);

  return (
    <Suspense fallback={<LoadingPage />}>
      <Views />
    </Suspense>
  );
}

export default App;
