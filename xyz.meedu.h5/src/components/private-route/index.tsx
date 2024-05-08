import React from "react";
import { getToken } from "../../utils/index";
import { Navigate } from "react-router-dom";

interface PropInterface {
  Component: any;
}

const PrivateRoute: React.FC<PropInterface> = ({ Component }) => {
  let url =
    "/login?redirect=" +
    encodeURIComponent(window.location.pathname + window.location.search);

  return getToken() ? Component : <Navigate to={url} replace />;
};
export default PrivateRoute;
