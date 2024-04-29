import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { viewBlock, home } from "../../api/index";
import { useNavigate } from "react-router-dom";
import { useSelector } from "react-redux";
import { Row, Carousel, Skeleton } from "antd";
import { VodComp } from "./components/vod-v1";

const IndexPage = () => {
  document.title = "首页";
  const navigate = useNavigate();
  const [signStatus, setSignStatus] = useState<boolean>(false);
  const [loading, setLoading] = useState<boolean>(false);
  const [blocksLoading, setBlocksLoading] = useState<boolean>(false);
  const [sliders, setSliders] = useState<any>([]);
  const [blocks, setBlocks] = useState<any>([]);
  const [notice, setNotice] = useState<any>({});
  const isLogin = useSelector((state: any) => state.loginUser.value.isLogin);
  const configFunc = useSelector(
    (state: any) => state.systemConfig.value.configFunc
  );

  useEffect(() => {
    getSliders();
    getPageBlocks();
    getNotice();
  }, []);

  const getSliders = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    viewBlock.sliders({ platform: "PC" }).then((res: any) => {
      setSliders(res.data);
      setLoading(false);
    });
  };

  const getPageBlocks = () => {
    if (blocksLoading) {
      return;
    }
    setBlocksLoading(true);
    viewBlock
      .pageBlocks({
        platform: "pc",
        page_name: "pc-page-index",
      })
      .then((res: any) => {
        setBlocks(res.data);
        setBlocksLoading(false);
      });
  };

  const getNotice = () => {
    home.announcement().then((res: any) => {
      setNotice(res.data);
    });
  };

  const sliderClcik = (url: string) => {
    if (url.match("https:") || url.match("http:") || url.match("www")) {
      window.location.href = url;
    } else {
      navigate(url);
    }
  };

  const contentStyle: React.CSSProperties = {
    width: "100%",
    height: "400px",
    textAlign: "center",
    borderRadius: "16px 16px 0 0",
    cursor: "pointer",
    border: "none",
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
      {!loading && sliders.length > 0 && (
        <Carousel autoplay>
          {sliders.map((item: any) => (
            <div
              key={item.sort}
              onClick={() => sliderClcik(item.url)}
              style={{ border: "none", outline: "none" }}
            >
              <img src={item.thumb} style={contentStyle} />
            </div>
          ))}
        </Carousel>
      )}
      {!loading && notice && notice.id && (
        <a
          onClick={() => navigate("/announcement?id=" + notice.id)}
          className={styles["announcement"]}
        >
          公告：{notice.title}
        </a>
      )}
      {!blocksLoading &&
        blocks.length > 0 &&
        blocks.map((item: any) => (
          <div className={styles["box"]} key={item.id}>
            {item.sign === "pc-vod-v1" && (
              <VodComp
                name={item.config_render.title}
                items={item.config_render.items}
              ></VodComp>
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
