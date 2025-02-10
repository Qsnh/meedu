import { useEffect, useState } from "react";
import { viewBlock } from "../../api/index";
import styles from "./index.module.scss";
import { useSelector } from "react-redux";
import { IndexSlider } from "./compenents/index-slider";
import { IndexBlank } from "./compenents/blank";
import { IndexGridNav } from "./compenents/grid-nav";
import { IndexImageGroup } from "./compenents/image-group";
import { IndexGzhV1 } from "./compenents/gzh-v1";
import { IndexVodV1 } from "./compenents/vod-v1";
import { SearchBox, TechSupport } from "../../components";
import wechatShare from "../../js/wechat-share";

const IndexPage = () => {
  const [loading, setLoading] = useState(true);
  const [blocks, setBlocks] = useState<BlocksInterface[]>([]);
  const systemConfig = useSelector((state: any) => state.systemConfig.value);
  const isLogin = useSelector((state: any) => state.loginUser.value.isLogin);
  const user = useSelector((state: any) => state.loginUser.value);

  useEffect(() => {
    document.title = systemConfig.name || "首页";
  }, [systemConfig]);

  useEffect(() => {
    setLoading(true);
    getData();
    // 微信H5分享
    wechatShare.methods.wechatH5Share(null, null, null, isLogin ? user.id : 0);
  }, [isLogin, user]);

  const getData = () => {
    viewBlock
      .PageBlocks({
        platform: "h5",
        page_name: "h5-page-index",
      })
      .then((res: any) => {
        setBlocks(res.data);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <>
      <div className={styles["container"]}>
        {!loading && <SearchBox />}
        {blocks.length > 0 &&
          blocks.map((item: any) => (
            <div className={styles["box"]} key={item.id}>
              {item.sign === "blank" ? (
                <IndexBlank
                  height={item.config_render.height}
                  bgColor={item.config_render.bgcolor}
                />
              ) : null}
              {item.sign === "slider" ? (
                <IndexSlider render={item.config_render} />
              ) : null}
              {item.sign === "grid-nav" ? (
                <IndexGridNav
                  render={item.config_render.items}
                  lineCount={item.config_render.line_count}
                  isLogin={isLogin}
                />
              ) : null}
              {item.sign === "image-group" ? (
                <IndexImageGroup
                  render={item.config_render.items}
                  v={item.config_render.v}
                />
              ) : null}
              {item.sign === "h5-gzh-v1" ? (
                <IndexGzhV1 render={item.config_render} />
              ) : null}
              {item.sign === "h5-vod-v1" ? (
                <IndexVodV1
                  render={item.config_render.items}
                  name={item.config_render.title}
                />
              ) : null}
            </div>
          ))}
        {!loading && <TechSupport />}
      </div>
    </>
  );
};

export default IndexPage;
