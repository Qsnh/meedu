import { useUpdate } from "ahooks";
import { useEffect, useRef } from "react";
import { useLocation, useOutlet } from "react-router-dom";

function KeepAlive() {
  const componentList = useRef(new Map());
  const outLet = useOutlet();
  const { pathname } = useLocation();
  const forceUpdate = useUpdate();

  useEffect(() => {
    if (!componentList.current.has(pathname)) {
      componentList.current.set(pathname, outLet);
    }
    forceUpdate();
  }, [pathname]);

  return (
    <div>
      {Array.from(componentList.current).map(([key, component]) => (
        <div key={key} style={{ display: pathname === key ? "block" : "none" }}>
          {component}
        </div>
      ))}
    </div>
  );
}

export default KeepAlive;
