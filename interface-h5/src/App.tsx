import { Suspense } from "react";
import { useRoutes } from "react-router-dom";
import routes from "./routes";
import "./App.scss";
import LoadingPage from "./pages/loading";

const App = () => {
  const Views = () => useRoutes(routes);

  return (
    <Suspense fallback={<LoadingPage />}>
      <Views />
    </Suspense>
  );
};

export default App;
