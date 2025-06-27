import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Layout } from "antd";
import { useSelector } from "react-redux";
import { useLocation } from "react-router-dom";
import { system } from "../../api/index";
import footlink from "../../assets/img/commen/footlink.png";
import type { RootState } from "../../store";

interface Props {
  status: boolean;
}

export const Footer = (props: Props) => {
  const config = useSelector((state: RootState) => state.systemConfig.value.config);
  const pathname = useLocation().pathname;
  const [list, setList] = useState<any>([]);
  let footerStatus = true;
  if (pathname === "/vip" || pathname === "/search") {
    footerStatus = false;
  }

  useEffect(() => {
    if (props.status) {
      getData();
    }
  }, [props.status]);

  const getData = () => {
    system.footerLink().then((res: any) => {
      setList(res.data);
    });
  };

  return (
    <Layout.Footer
      style={
        footerStatus
          ? {
              backgroundColor: "#0f0a1e",
              height: "auto",
              textAlign: "center",
              marginTop: 150,
            }
          : {
              backgroundColor: "#0f0a1e",
              height: "auto",
              textAlign: "center",
              marginTop: 0,
            }
      }
    >
      <div className={styles["footer-box"]}>
        {list.length > 0 && pathname === "/" && (
          <div>
            <div className={styles["tit"]}>友情链接</div>
            <div className={styles["links"]}>
              {list.map((item: any) => (
                <a href={item.url} key={item.id} target="_blank">
                  {item.name}
                </a>
              ))}
            </div>
          </div>
        )}
        <div className={styles["info2"]}>
          <a href="https://www.meedu.vip/" target="_blank">
            <img src={footlink} />
          </a>
        </div>
        <div className={styles["info1"]}>
          © 2021 {config?.webname || config?.name}
          {config?.icp && (
            <a href={config.icp_link} target="_blank">
              •{config.icp}
            </a>
          )}
          {config?.icp2 && (
            <a href={config.icp2_link} target="_blank">
              •{config.icp2}
            </a>
          )}
        </div>
      </div>
    </Layout.Footer>
  );
};
