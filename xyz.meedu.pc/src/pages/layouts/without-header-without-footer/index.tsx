import { Suspense } from "react";
import { Outlet } from "react-router-dom";
import LoadingPage from "../../loading";

const WithoutHeaderWithoutFooter = () => {
  return (
    <Suspense fallback={<LoadingPage height="100vh" />}>
      <Outlet />
    </Suspense>
  );
};

export default WithoutHeaderWithoutFooter;
