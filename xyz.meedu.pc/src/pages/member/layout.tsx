import React, { useCallback, useMemo, useState, useEffect } from "react";
import { Outlet, useLocation } from "react-router-dom";
import styles from "./layout.module.scss";
import { NavMember } from "../../components";

export interface MemberLayoutContextValue {
  setActiveId: (id: number) => void;
  triggerNavRefresh: () => void;
}

const routeActiveMap: Record<string, number> = {
  "/member": 0,
  "/member/messages": 7,
  "/member/orders": 6,
  "/member/credit1": 18,
};

const MemberLayout: React.FC = () => {
  const [activeId, setActiveId] = useState(0);
  const [navRefreshFlag, setNavRefreshFlag] = useState(false);
  const location = useLocation();

  useEffect(() => {
    const id = routeActiveMap[location.pathname];
    if (typeof id !== "undefined") {
      setActiveId(id);
    }
  }, [location.pathname]);

  const setActiveMenu = useCallback((id: number) => {
    setActiveId(id);
  }, []);

  const triggerNavRefresh = useCallback(() => {
    setNavRefreshFlag((prev) => !prev);
  }, []);

  const contextValue = useMemo(
    () => ({
      setActiveId: setActiveMenu,
      triggerNavRefresh,
    }),
    [setActiveMenu, triggerNavRefresh]
  );

  return (
    <div className="container">
      <div className={styles["layout"]}>
        <NavMember cid={activeId} refresh={navRefreshFlag} />
        <Outlet context={contextValue} />
      </div>
    </div>
  );
};

export default MemberLayout;
