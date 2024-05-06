import React from "react";
import { getToken, getFaceCheckKey, getBindMobileKey } from "../../utils/index";
import { Navigate } from "react-router-dom";

interface PropInterface {
  Component: any;
}

const PrivateRoute: React.FC<PropInterface> = ({ Component }) => {
  let url =
    "/login?redirect=" +
    encodeURIComponent(window.location.pathname + window.location.search);

  return getToken() ? (
    getBindMobileKey() === "ok" ? (
      <Navigate to={"/bind-mobile"} replace />
    ) : getFaceCheckKey() === "ok" ? (
      <Navigate to={"/face-check"} replace />
    ) : (
      Component
    )
  ) : (
    <Navigate to={url} replace />
  );
};
export default PrivateRoute;
