import { Outlet } from "react-router-dom";
import { Footer } from "../../../components";
import { Suspense } from "react";
import LoadingPage from "../../loading";

const WithoutHeaderWithFooter = () => {
  return (
    <>
      <Suspense fallback={<LoadingPage height="100vh" />}>
        <Outlet />
      </Suspense>
      <Footer status={true}></Footer>
    </>
  );
};

export default WithoutHeaderWithFooter;
