import { Suspense } from "react";
import { Outlet } from "react-router-dom";
import LoadingPage from "../../loading";
import { TabBarFooter } from "../../../components/footer-bar";

const WithoutHeaderWithoutFooter = () => {
  return (
    <>
      <Suspense fallback={<LoadingPage />}>
        <Outlet />
      </Suspense>
      <TabBarFooter></TabBarFooter>
    </>
  );
};

export default WithoutHeaderWithoutFooter;
