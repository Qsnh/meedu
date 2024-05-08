import { useState, useEffect } from "react";
import { Modal, message, Tooltip } from "antd";
import styles from "./h5.module.scss";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { viewBlock } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import {
  UpOutlined,
  DownOutlined,
  CopyOutlined,
  DeleteOutlined,
  LeftOutlined,
  ExclamationCircleFilled,
} from "@ant-design/icons";
import { ConfigSetting } from "./components/h5/config/index";
import { RenderSliders } from "./components/h5/render-sliders";
import { RenderGridNav } from "./components/h5/render-grid-nav";
import { RenderBlank } from "./components/h5/render-blank";
import { RenderGzhV1 } from "./components/h5/render-gzh-v1";
import { RenderImageGroup } from "./components/h5/render-image-group";
import { RenderMpWechat } from "./components/h5/render-mp-wechat";
import { RenderVod } from "./components/h5/render-vod";
import sliderIcon from "../../assets/images/decoration/h5/slider.png";
import navIcon from "../../assets/images/decoration/h5/grid-nav.png";
import blankIcon from "../../assets/images/decoration/h5/blank.png";
import groupIcon from "../../assets/images/decoration/h5/image-group.png";
import vodIcon from "../../assets/images/decoration/h5/h5-vod-v1.png";
import gzhIocn from "../../assets/images/decoration/h5/h5-gognzhoanghao-v1.png";
import statusIcon from "../../assets/images/decoration/h5/status-bar.png";
import searchIcon from "../../assets/images/decoration/h5/search-bar.png";
const { confirm } = Modal;

const DecorationH5Page = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);
  const [platform] = useState("h5");
  const [page] = useState("h5-page-index");
  const [blocks, setBlocks] = useState<any>([]);
  const [curBlock, setCurBlock] = useState<any>(null);
  const [lastSort, setLastSort] = useState(0);

  const enabledAddons = useSelector(
    (state: any) => state.enabledAddonsConfig.value.enabledAddons
  );

  useEffect(() => {
    document.title = "移动端装修";
    dispatch(titleAction("移动端装修"));
  }, []);

  useEffect(() => {
    getData();
  }, [page, platform]);

  useEffect(() => {
    let sort = 0;
    if (blocks.length > 0) {
      sort = blocks[blocks.length - 1].sort + 1;
    }
    setLastSort(sort);
  }, [blocks]);

  const getData = (toBottom = false) => {
    if (loading) {
      return;
    }
    setLoading(true);
    viewBlock
      .list({
        platform: platform,
        page: page,
      })
      .then((res: any) => {
        setBlocks(res.data);
        setLoading(false);
        setCurBlock(null);
        if (toBottom) {
          setCurBlock(blocks.length);
          const $div: any = document.getElementById("h5-dec-preview-box");
          $div.scrollTop = $div.scrollHeight;
        }
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const dragChange = (e: any, sign: string) => {
    let screenWidth = document.body.clientWidth;
    let priewLeft = 0.5 * screenWidth - 188;
    let priewright = 0.5 * screenWidth + 187;
    if (e.clientX < priewLeft) {
      return;
    }
    if (e.clientX > priewright) {
      return;
    }
    if (e.clientY < 143) {
      return;
    }
    if (loading) {
      return;
    }
    setLoading(true);
    // 默认数据
    let defaultConfig = null;
    if (sign === "grid-nav") {
      defaultConfig = {
        line_count: 4,
        items: [
          {
            src: null,
            name: "xxx",
          },
          {
            src: null,
            name: "xxx",
          },
          {
            src: null,
            name: "xxx",
          },
          {
            src: null,
            name: "xxx",
          },
        ],
      };
    } else if (sign === "slider") {
      defaultConfig = [
        {
          src: null,
          url: null,
        },
      ];
    } else if (sign === "h5-vod-v1") {
      defaultConfig = {
        title: "录播课程",
        items: [
          {
            id: null,
            title: "xxx",
            thumb: null,
          },
        ],
      };
    } else if (sign === "h5-live-v1") {
      defaultConfig = {
        title: "直播课程",
        items: [
          {
            id: null,
            title: "直播课程一",
            thumb: null,
          },
          {
            id: null,
            title: "直播课程二",
            thumb: null,
          },
        ],
      };
    } else if (sign === "h5-book-v1") {
      defaultConfig = {
        title: "电子书",
        items: [
          {
            id: null,
            name: "电子书一",
            thumb: null,
          },
        ],
      };
    } else if (sign === "h5-topic-v1") {
      defaultConfig = {
        title: "图文",
        items: [
          {
            id: null,
            title: "图文一",
            thumb: null,
          },
        ],
      };
    } else if (sign === "h5-learnPath-v1") {
      defaultConfig = {
        title: "学习路径",
        items: [
          {
            id: null,
            name: "路径一",
            thumb: null,
          },
        ],
      };
    } else if (sign === "h5-tg-v1") {
      defaultConfig = {
        title: "团购",
        items: [
          {
            id: null,
            goods_title: "团购商品一",
            goods_thumb: null,
          },
        ],
      };
    } else if (sign === "h5-ms-v1") {
      defaultConfig = {
        title: "秒杀",
        items: [
          {
            id: null,
            goods_title: "秒杀一",
            goods_thumb: null,
          },
        ],
      };
    } else if (sign === "blank") {
      defaultConfig = {
        height: 10,
        bgcolor: "#FFFFFF",
      };
    } else if (sign === "mp-wechat") {
      defaultConfig = {
        name: "微信公众号名称",
        desc: "微信公众号简介",
      };
    } else if (sign === "image-group") {
      defaultConfig = {
        v: "v-4",
        items: [
          {
            src: null,
            url: null,
          },
          {
            src: null,
            url: null,
          },
          {
            src: null,
            url: null,
          },
          {
            src: null,
            url: null,
          },
        ],
      };
    } else if (sign === "h5-gzh-v1") {
      defaultConfig = {
        title: "公众号",
        name: "公众号名称",
        logo: null,
        desc: "公众号引导",
        qrcode: null,
      };
    }

    viewBlock
      .store({
        platform: platform,
        page: page,
        sign: sign,
        sort: lastSort,
        config: defaultConfig,
      })
      .then((res: any) => {
        setLoading(false);
        getData(true);
        message.success("添加成功");
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const blockDestroy = (index: number, item: any) => {
    confirm({
      title: "警告",
      icon: <ExclamationCircleFilled />,
      content: "确认操作？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        viewBlock
          .destroy(item.id)
          .then(() => {
            setCurBlock(null);
            setLoading(false);
            message.success("删除成功");
            getData();
          })
          .catch((e) => {
            setLoading(false);
          });
      },
      onCancel() {
        console.log("Cancel");
      },
    });
  };

  const blockCopy = (index: number, item: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    viewBlock
      .store({
        platform: item.platform,
        page: item.page,
        sign: item.sign,
        sort: blocks[blocks.length - 1].sort + 1,
        config: item.config_render,
      })
      .then(() => {
        setLoading(false);
        message.success("成功");
        getData(true);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const moveTop = async (index: number, item: any) => {
    if (index === 0) {
      message.warning("已经是第一个啦");
      return;
    }
    let changeItem = blocks[index - 1];

    await viewBlock.update(item.id, {
      sort: changeItem.sort,
      config: item.config_render,
    });
    await viewBlock.update(changeItem.id, {
      sort: item.sort,
      config: changeItem.config_render,
    });
    setCurBlock(null);
    getData();
  };

  const moveBottom = async (index: number, item: any) => {
    if (index === blocks.length - 1) {
      message.warning("已经是最后一个啦");
      return;
    }
    let changeItem = blocks[index + 1];

    await viewBlock.update(item.id, {
      sort: changeItem.sort,
      config: item.config_render,
    });
    await viewBlock.update(changeItem.id, {
      sort: item.sort,
      config: changeItem.config_render,
    });
    setCurBlock(null);
    getData();
  };

  return (
    <div className={styles["bg"]}>
      <div className={styles["top-box"]}>
        <div className={styles["btn-back"]} onClick={() => navigate(-1)}>
          <LeftOutlined style={{ marginRight: 4 }} />
          返回
        </div>
        <div className={styles["line"]}></div>
        <div className={styles["name"]}>移动端首页</div>
      </div>
      <div className="main-body">
        <div className={styles["blocks-box"]}>
          <div className={styles["title"]}>拖动添加板块</div>
          <div className={styles["blocks"]}>
            <div
              className={styles["block-item"]}
              draggable
              onDragEnd={(e: any) => {
                dragChange(e, "slider");
              }}
            >
              <div className={styles["btn"]}>
                <div className={styles["icon"]}>
                  <img
                    draggable={false}
                    src={sliderIcon}
                    width={44}
                    height={44}
                  />
                </div>
                <div className={styles["name"]}>幻灯片</div>
              </div>
            </div>
            <div
              className={styles["block-item"]}
              draggable
              onDragEnd={(e: any) => {
                dragChange(e, "grid-nav");
              }}
            >
              <div className={styles["btn"]}>
                <div className={styles["icon"]}>
                  <img draggable={false} src={navIcon} width={44} height={44} />
                </div>
                <div className={styles["name"]}>宫格导航</div>
              </div>
            </div>
            <div
              className={styles["block-item"]}
              draggable
              onDragEnd={(e: any) => {
                dragChange(e, "blank");
              }}
            >
              <div className={styles["btn"]}>
                <div className={styles["icon"]}>
                  <img
                    draggable={false}
                    src={blankIcon}
                    width={44}
                    height={44}
                  />
                </div>
                <div className={styles["name"]}>空白快</div>
              </div>
            </div>
            <div
              className={styles["block-item"]}
              draggable
              onDragEnd={(e: any) => {
                dragChange(e, "image-group");
              }}
            >
              <div className={styles["btn"]}>
                <div className={styles["icon"]}>
                  <img
                    draggable={false}
                    src={groupIcon}
                    width={44}
                    height={44}
                  />
                </div>
                <div className={styles["name"]}>图片魔方</div>
              </div>
            </div>
            <div
              className={styles["block-item"]}
              draggable
              onDragEnd={(e: any) => {
                dragChange(e, "h5-vod-v1");
              }}
            >
              <div className={styles["btn"]}>
                <div className={styles["icon"]}>
                  <img draggable={false} src={vodIcon} width={44} height={44} />
                </div>
                <div className={styles["name"]}>录播</div>
              </div>
            </div>
            <div
              className={styles["block-item"]}
              draggable
              onDragEnd={(e: any) => {
                dragChange(e, "h5-gzh-v1");
              }}
            >
              <div className={styles["btn"]}>
                <div className={styles["icon"]}>
                  <img draggable={false} src={gzhIocn} width={44} height={44} />
                </div>
                <div className={styles["name"]}>公众号</div>
              </div>
            </div>
          </div>
        </div>
        <div
          className="h5-dec-preview-box"
          id="h5-dec-preview-box"
          onDragEnter={(e: any) => {
            e.preventDefault();
          }}
          onDragOver={(e: any) => {
            e.preventDefault();
          }}
        >
          <div className="status-bar">
            <img src={statusIcon} style={{ width: "100%" }} height={26} />
          </div>
          <div className="search-bar">
            <img src={searchIcon} style={{ width: "100%" }} height={50} />
          </div>
          {blocks.length > 0 &&
            blocks.map((item: any, index: number) => (
              <div className="float-left" key={index}>
                <div
                  className={curBlock === index ? "active item" : "item"}
                  onClick={() => setCurBlock(index)}
                >
                  {item.sign === "slider" && (
                    <RenderSliders config={item.config_render}></RenderSliders>
                  )}
                  {item.sign === "grid-nav" && (
                    <RenderGridNav config={item.config_render}></RenderGridNav>
                  )}
                  {item.sign === "h5-vod-v1" && (
                    <RenderVod config={item.config_render}></RenderVod>
                  )}
                  {item.sign === "blank" && (
                    <RenderBlank config={item.config_render}></RenderBlank>
                  )}
                  {item.sign === "mp-wechat" && (
                    <RenderMpWechat
                      config={item.config_render}
                    ></RenderMpWechat>
                  )}
                  {item.sign === "image-group" && (
                    <RenderImageGroup
                      config={item.config_render}
                    ></RenderImageGroup>
                  )}
                  {item.sign === "h5-gzh-v1" && (
                    <RenderGzhV1 config={item.config_render}></RenderGzhV1>
                  )}
                  {curBlock === index && (
                    <div className="item-options">
                      <Tooltip placement="top" title="删除模块">
                        <div
                          className="btn-item"
                          onClick={() => blockDestroy(index, item)}
                        >
                          <DeleteOutlined />
                        </div>
                      </Tooltip>
                      <Tooltip placement="top" title="复制模块">
                        <div
                          className="btn-item"
                          onClick={() => blockCopy(index, item)}
                        >
                          <CopyOutlined />
                        </div>
                      </Tooltip>
                      {index !== 0 && (
                        <Tooltip placement="top" title="模块上移">
                          <div
                            className="btn-item"
                            onClick={() => moveTop(index, item)}
                          >
                            <UpOutlined />
                          </div>
                        </Tooltip>
                      )}
                      {index !== blocks.length - 1 && (
                        <Tooltip placement="top" title="模块下移">
                          <div
                            className="btn-item"
                            onClick={() => moveBottom(index, item)}
                          >
                            <DownOutlined />
                          </div>
                        </Tooltip>
                      )}
                    </div>
                  )}
                </div>
              </div>
            ))}
        </div>
        {curBlock !== null && (
          <div className={styles["config-box"]}>
            <ConfigSetting
              block={blocks[curBlock]}
              onUpdate={() => getData()}
            ></ConfigSetting>
          </div>
        )}
      </div>
    </div>
  );
};

export default DecorationH5Page;
