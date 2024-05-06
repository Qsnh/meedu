import { Outlet } from "react-router-dom";
import { Header } from "../../../components";
import { Suspense } from "react";
import LoadingPage from "../../loading";

const WithHeaderWithoutFooter = () => {
  return (
    <>
      <Header></Header>
      <Suspense fallback={<LoadingPage height="100vh" />}>
        <Outlet />
      </Suspense>
    </>
  );
};

export default WithHeaderWithoutFooter;
