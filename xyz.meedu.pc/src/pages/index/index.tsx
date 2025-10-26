import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { viewBlock, home } from "../../api/index";
import { useNavigate } from "react-router-dom";
import { Row, Skeleton } from "antd";
import { VodComp } from "./components/vod-v1";
import { PCSliderComp } from "./components/pc-slider";

const IndexPage = () => {
  document.title = "首页";
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);
  const [blocksLoading, setBlocksLoading] = useState<boolean>(false);
  const [blocks, setBlocks] = useState<any>([]);

  useEffect(() => {
    getPageBlocks();
  }, []);

  const getPageBlocks = () => {
    if (blocksLoading) {
      return;
    }
    setBlocksLoading(true);
    viewBlock
      .pageBlocks({
        page_name: "pc-page-index",
      })
      .then((res: any) => {
        setBlocks(res.data);
        setBlocksLoading(false);
      });
  };

  return (
    <div className="container" style={{ paddingTop: 30 }}>
      {loading && (
        <Row>
          <Skeleton.Button
            active
            style={{
              width: 1200,
              height: 400,
              borderRadius: "16px 16px 0 0",
            }}
          ></Skeleton.Button>
          <Skeleton active paragraph={{ rows: 0 }}></Skeleton>
          <div style={{ width: 1200, textAlign: "center" }}>
            <Skeleton.Button
              active
              style={{ height: 30, width: 120, marginTop: 75 }}
            ></Skeleton.Button>
          </div>
          <div
            style={{
              width: 1200,
              display: "flex",
              flexWrap: "wrap",
              justifyContent: "space-between",
              marginTop: 50,
            }}
          >
            <div
              style={{
                width: 264,
                display: "flex",
                flexDirection: "column",
              }}
            >
              <Skeleton.Button
                active
                style={{
                  width: 264,
                  height: 198,
                  borderRadius: "8px 8px 0 0",
                }}
              ></Skeleton.Button>
              <Skeleton active paragraph={{ rows: 1 }}></Skeleton>
            </div>
            <div
              style={{
                width: 264,
                display: "flex",
                flexDirection: "column",
              }}
            >
              <Skeleton.Button
                active
                style={{
                  width: 264,
                  height: 198,
                  borderRadius: "8px 8px 0 0",
                }}
              ></Skeleton.Button>
              <Skeleton active paragraph={{ rows: 1 }}></Skeleton>
            </div>
            <div
              style={{
                width: 264,
                display: "flex",
                flexDirection: "column",
              }}
            >
              <Skeleton.Button
                active
                style={{
                  width: 264,
                  height: 198,
                  borderRadius: "8px 8px 0 0",
                }}
              ></Skeleton.Button>
              <Skeleton active paragraph={{ rows: 1 }}></Skeleton>
            </div>
            <div
              style={{
                width: 264,
                display: "flex",
                flexDirection: "column",
              }}
            >
              <Skeleton.Button
                active
                style={{
                  width: 264,
                  height: 198,
                  borderRadius: "8px 8px 0 0",
                }}
              ></Skeleton.Button>
              <Skeleton active paragraph={{ rows: 1 }}></Skeleton>
            </div>
            <div
              style={{
                width: 264,
                display: "flex",
                flexDirection: "column",
                marginTop: 30,
              }}
            >
              <Skeleton.Button
                active
                style={{
                  width: 264,
                  height: 198,
                  borderRadius: "8px 8px 0 0",
                }}
              ></Skeleton.Button>
              <Skeleton active paragraph={{ rows: 1 }}></Skeleton>
            </div>
            <div
              style={{
                width: 264,
                display: "flex",
                flexDirection: "column",
                marginTop: 30,
              }}
            >
              <Skeleton.Button
                active
                style={{
                  width: 264,
                  height: 198,
                  borderRadius: "8px 8px 0 0",
                }}
              ></Skeleton.Button>
              <Skeleton active paragraph={{ rows: 1 }}></Skeleton>
            </div>
            <div
              style={{
                width: 264,
                display: "flex",
                flexDirection: "column",
                marginTop: 30,
              }}
            >
              <Skeleton.Button
                active
                style={{
                  width: 264,
                  height: 198,
                  borderRadius: "8px 8px 0 0",
                }}
              ></Skeleton.Button>
              <Skeleton active paragraph={{ rows: 1 }}></Skeleton>
            </div>
            <div
              style={{
                width: 264,
                display: "flex",
                flexDirection: "column",
                marginTop: 30,
              }}
            >
              <Skeleton.Button
                active
                style={{
                  width: 264,
                  height: 198,
                  borderRadius: "8px 8px 0 0",
                }}
              ></Skeleton.Button>
              <Skeleton active paragraph={{ rows: 1 }}></Skeleton>
            </div>
          </div>
        </Row>
      )}
      {!blocksLoading &&
        blocks.length > 0 &&
        blocks.map((item: any) => (
          <div className={styles["box"]} key={item.id}>
            {item.sign === "pc-slider" && (
              <PCSliderComp items={item.config_render}></PCSliderComp>
            )}
            {item.sign === "pc-vod-v1" && (
              <VodComp
                name={item.config_render.title}
                items={item.config_render.items}
              />
            )}
            {item.sign === "code" && (
              <div className={styles["code-box"]}>
                <div
                  dangerouslySetInnerHTML={{ __html: item.config_render.html }}
                ></div>
              </div>
            )}
          </div>
        ))}
    </div>
  );
};

export default IndexPage;
