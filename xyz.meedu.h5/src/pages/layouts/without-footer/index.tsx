import { Suspense } from "react";
import { Outlet } from "react-router-dom";
import LoadingPage from "../../loading";

const WithoutHeaderWithoutFooter = () => {
  return (
    <Suspense fallback={<LoadingPage />}>
      <Outlet />
    </Suspense>
  );
};

export default WithoutHeaderWithoutFooter;
