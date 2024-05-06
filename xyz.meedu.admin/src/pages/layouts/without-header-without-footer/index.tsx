import { Suspense } from "react";
import styles from "./index.module.scss";
import { Outlet } from "react-router-dom";
import LoadingPage from "../../loading";

const WithoutHeaderWithoutFooter = () => {
  return (
    <div className={styles["layout-wrap"]}>
      <Suspense fallback={<LoadingPage height="100vh" />}>
        <Outlet />
      </Suspense>
    </div>
  );
};

export default WithoutHeaderWithoutFooter;
