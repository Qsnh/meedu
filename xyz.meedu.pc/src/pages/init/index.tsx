import { useState, useEffect } from "react";
import { Outlet } from "react-router-dom";
import { BackTop } from "../../components";

export const InitPage = () => {
  const [backTopStatus, setBackTopStatus] = useState(false);

  // 滚动条监听
  useEffect(() => {
    const getHeight = () => {
      let scrollTop =
        document.documentElement.scrollTop || document.body.scrollTop;
      setBackTopStatus(scrollTop >= 2000);
    };
    window.addEventListener("scroll", getHeight, true);
    return () => {
      window.removeEventListener("scroll", getHeight, true);
    };
  }, []);

  return (
    <>
      <div style={{ minHeight: 800 }}>
        <Outlet />
      </div>
      {backTopStatus ? <BackTop /> : null}
    </>
  );
};
