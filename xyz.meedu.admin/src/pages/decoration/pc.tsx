import { useState, useEffect } from "react";
import { Modal, message, Button, Tooltip } from "antd";
import styles from "./pc.module.scss";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { viewBlock } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import {
  CloseOutlined,
  UpOutlined,
  DownOutlined,
  CopyOutlined,
  DeleteOutlined,
  LeftOutlined,
  ExclamationCircleFilled,
} from "@ant-design/icons";
import { RenderNavs } from "./components/pc/render-navs";
import { RenderSliders } from "./components/pc/render-sliders";
import { RenderNotice } from "./components/pc/render-notice";
import { RenderLinks } from "./components/pc/render-links";
import { RenderVod } from "./components/pc/render-vod";
import { RenderCode } from "./components/pc/render-code";
import { NavsList } from "./components/pc/render-navs/list";
import { SlidersList } from "./components/pc/render-sliders/list";
import { NoticeList } from "./components/pc/render-notice/list";
import { LinksList } from "./components/pc/render-links/list";
import { ConfigSetting } from "./components/h5/config/index";
import navIcon from "../../assets/images/decoration/h5/icon-nav.png";
import announceIcon from "../../assets/images/decoration/h5/icon-announce.png";
import bannerIcon from "../../assets/images/decoration/h5/icon-banner.png";
import linkIcon from "../../assets/images/decoration/h5/icon-link.png";
import vodIcon from "../../assets/images/decoration/h5/h5-vod-v1.png";
import codeIocn from "../../assets/images/decoration/h5/code.png";
const { confirm } = Modal;

const DecorationPCPage = () => {
  const enabledAddons = useSelector(
    (state: any) => state.enabledAddonsConfig.value.enabledAddons
  );

  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);
  const [platform] = useState("pc");
  const [page] = useState("pc-page-index");
  const [blocks, setBlocks] = useState<any>([]);
  const [curBlockIndex, setCurBlockIndex] = useState<any>(null);
  const [showNavWin, setShowNavWin] = useState<boolean>(false);
  const [showListWin, setShowListWin] = useState<boolean>(false);
  const [showNoticeWin, setShowNoticeWin] = useState<boolean>(false);
  const [showLinkWin, setShowLinkWin] = useState<boolean>(false);
  const [previewWidth, setPreviewWidth] = useState(1200);
  const [lastSort, setLastSort] = useState(0);

  useEffect(() => {
    document.title = "电脑端装修";
    dispatch(titleAction("电脑端装修"));
    let screenWidth = document.body.clientWidth;
    if (screenWidth > 1500) {
      setPreviewWidth(1200);
    } else {
      setPreviewWidth(1000);
    }
  }, []);

  useEffect(() => {
    window.addEventListener("resize", getScreenWidth, false);
    getData();
    return () => {
      window.removeEventListener("resize", getScreenWidth, false);
    };
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
        if (toBottom) {
          setCurBlockIndex(blocks.length);
          const $div: any = document.getElementById("pc-dec-preview-box");
          $div.scrollTop = $div.scrollHeight;
        }
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const getScreenWidth = () => {
    let screenWidth = document.body.clientWidth;
    if (screenWidth > 1500) {
      setPreviewWidth(1200);
    } else {
      setPreviewWidth(1000);
    }
  };

  const close = () => {
    setShowListWin(false);
    setShowLinkWin(false);
    setShowNavWin(false);
    setShowNoticeWin(false);
  };

  const dragChange = (e: any, sign: string) => {
    if (
      e.clientX < 249 ||
      e.clientX > 249 + previewWidth ||
      e.clientY < 143 ||
      loading
    ) {
      return;
    }
    setLoading(true);
    let defaultConfig = null;
    if (sign === "pc-vod-v1") {
      defaultConfig = {
        title: "录播课程",
        items: [
          {
            id: null,
            title: "录播课程",
            thumb: null,
            user_count: 0,
            charge: 0,
          },
          {
            id: null,
            title: "录播课程",
            thumb: null,
            user_count: 0,
            charge: 0,
          },
          {
            id: null,
            title: "录播课程",
            thumb: null,
            user_count: 0,
            charge: 0,
          },
          {
            id: null,
            title: "录播课程",
            thumb: null,
            user_count: 0,
            charge: 0,
          },
        ],
      };
    } else if (sign === "pc-live-v1") {
      defaultConfig = {
        title: "直播课程",
        items: [
          {
            id: null,
            title: "直播课程",
            thumb: null,
            charge: 0,
            videos_count: 0,
            teacher: {
              name: "教师xx",
            },
          },
          {
            id: null,
            title: "直播课程",
            thumb: null,
            charge: 0,
            videos_count: 0,
            teacher: {
              name: "教师xx",
            },
          },
          {
            id: null,
            title: "直播课程",
            thumb: null,
            charge: 0,
            videos_count: 0,
            teacher: {
              name: "教师xx",
            },
          },
          {
            id: null,
            title: "直播课程",
            thumb: null,
            charge: 0,
            videos_count: 0,
            teacher: {
              name: "教师xx",
            },
          },
        ],
      };
    } else if (sign === "pc-book-v1") {
      defaultConfig = {
        title: "电子书",
        items: [
          {
            id: null,
            name: "电子书",
            thumb: null,
            charge: 0,
          },
          {
            id: null,
            name: "电子书",
            thumb: null,
            charge: 0,
          },
          {
            id: null,
            name: "电子书",
            thumb: null,
            charge: 0,
          },
          {
            id: null,
            name: "电子书",
            thumb: null,
            charge: 0,
          },
        ],
      };
    } else if (sign === "pc-topic-v1") {
      defaultConfig = {
        title: "图文",
        items: [
          {
            id: null,
            title: "图文一",
            thumb: null,
            view_times: 0,
            category: {
              name: "未知分类",
            },
          },
          {
            id: null,
            title: "图文一",
            thumb: null,
            view_times: 0,
            category: {
              name: "未知分类",
            },
          },
          {
            id: null,
            title: "图文一",
            thumb: null,
            view_times: 0,
            category: {
              name: "未知分类",
            },
          },
          {
            id: null,
            title: "图文一",
            thumb: null,
            view_times: 0,
            category: {
              name: "未知分类",
            },
          },
        ],
      };
    } else if (sign === "pc-learnPath-v1") {
      defaultConfig = {
        title: "学习路径",
        items: [
          {
            id: null,
            name: "路径一",
            thumb: null,
            charge: 0,
            steps_count: 0,
            courses_count: 0,
            desc: "简单介绍",
          },
          {
            id: null,
            name: "路径一",
            thumb: null,
            charge: 0,
            steps_count: 0,
            courses_count: 0,
            desc: "简单介绍",
          },
        ],
      };
    } else if (sign === "pc-tg-v1") {
      defaultConfig = {
        title: "团购",
        items: [
          {
            id: null,
            goods_title: "团购商品一",
            goods_thumb: null,
            charge: 0,
            original_charge: 0,
          },
          {
            id: null,
            goods_title: "团购商品一",
            goods_thumb: null,
            charge: 0,
            original_charge: 0,
          },
          {
            id: null,
            goods_title: "团购商品一",
            goods_thumb: null,
            charge: 0,
            original_charge: 0,
          },
          {
            id: null,
            goods_title: "团购商品一",
            goods_thumb: null,
            charge: 0,
            original_charge: 0,
          },
        ],
      };
    } else if (sign === "pc-ms-v1") {
      defaultConfig = {
        title: "秒杀",
        items: [
          {
            id: null,
            goods_title: "秒杀商品",
            goods_thumb: null,
            charge: 0,
            original_charge: 0,
          },
          {
            id: null,
            goods_title: "秒杀商品",
            goods_thumb: null,
            charge: 0,
            original_charge: 0,
          },
          {
            id: null,
            goods_title: "秒杀商品",
            goods_thumb: null,
            charge: 0,
            original_charge: 0,
          },
          {
            id: null,
            goods_title: "秒杀商品",
            goods_thumb: null,
            charge: 0,
            original_charge: 0,
          },
        ],
      };
    } else if (sign === "code") {
      defaultConfig = {
        html: null,
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
            setCurBlockIndex(null);
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
    setCurBlockIndex(null);
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
    setCurBlockIndex(null);
    getData();
  };

  const reloadData = (toBottom = false) => {
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
        setCurBlockIndex(null);
        setLoading(false);
        if (toBottom) {
          const $div: any = document.getElementById("pc-dec-preview-box");
          $div.scrollTop = $div.scrollHeight;
        }
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <div className={styles["bg"]}>
      <div className={styles["top-box"]}>
        <div className={styles["btn-back"]} onClick={() => navigate(-1)}>
          <LeftOutlined style={{ marginRight: 4 }} />
          返回
        </div>
        <div className={styles["line"]}></div>
        <div className={styles["name"]}>电脑端首页</div>
      </div>
      <div className={styles["blocks-box"]}>
        <div className={styles["title"]}>拖动添加板块</div>
        <div className={styles["tip"]}>拖动下列图标到右侧预览区</div>
        <div className={styles["blocks"]}>
          <div
            className={styles["block-item"]}
            draggable
            onDragEnd={(e: any) => {
              dragChange(e, "pc-vod-v1");
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
              dragChange(e, "code");
            }}
          >
            <div className={styles["btn"]}>
              <div className={styles["icon"]}>
                <img draggable={false} src={codeIocn} width={44} height={44} />
              </div>
              <div className={styles["name"]}>代码块</div>
            </div>
          </div>
        </div>
      </div>
      <div className={styles["navs-box"]}>
        <div className={styles["nav-item"]} onClick={() => setShowNavWin(true)}>
          <img src={navIcon} width={30} height={30} />
          导航管理
        </div>
        <div
          className={styles["nav-item"]}
          onClick={() => setShowNoticeWin(true)}
        >
          <img src={announceIcon} width={30} height={30} />
          公告管理
        </div>
        <div
          className={styles["nav-item"]}
          onClick={() => setShowListWin(true)}
        >
          <img src={bannerIcon} width={30} height={30} />
          轮播图片
        </div>
        <div
          className={styles["nav-item"]}
          onClick={() => setShowLinkWin(true)}
        >
          <img src={linkIcon} width={30} height={30} />
          友情链接
        </div>
        <div className={styles["tip"]}>点击预览区直接编辑板块</div>
      </div>
      <div
        className="pc-dec-preview-box"
        id="pc-dec-preview-box"
        onDragEnter={(e: any) => {
          e.preventDefault();
        }}
        onDragOver={(e: any) => {
          e.preventDefault();
        }}
      >
        <div className="pc-box" style={{ width: previewWidth }}>
          {/* 导航栏 */}
          <RenderNavs reload={showNavWin} />

          {/* 幻灯片 */}
          <RenderSliders reload={showListWin} width={previewWidth} />

          {/* 公告  */}
          <RenderNotice reload={showNoticeWin} />

          {blocks.length > 0 &&
            blocks.map((item: any, index: number) => (
              <div className="float-left" key={index}>
                <div
                  className={curBlockIndex === index ? "active item" : "item"}
                  onClick={() => setCurBlockIndex(index)}
                >
                  {item.sign === "pc-vod-v1" && (
                    <RenderVod config={item.config_render} />
                  )}
                  {item.sign === "code" && (
                    <RenderCode config={item.config_render} />
                  )}
                  {curBlockIndex === index && (
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

          {/* 友情链接  */}
          <RenderLinks reload={showLinkWin} />
        </div>
      </div>
      {curBlockIndex !== null && (
        <div className={styles["config-box"]}>
          <div className="float-left mb-15">
            <Button
              className="ml-15 mt-15"
              icon={<CloseOutlined />}
              onClick={() => {
                setCurBlockIndex(null);
              }}
            >
              关闭配置
            </Button>
          </div>
          <ConfigSetting
            block={blocks[curBlockIndex]}
            onUpdate={() => reloadData()}
          />
        </div>
      )}
      <NavsList open={showNavWin} onClose={() => close()} />
      <SlidersList open={showListWin} onClose={() => close()} />
      <NoticeList open={showNoticeWin} onClose={() => close()} />
      <LinksList open={showLinkWin} onClose={() => close()} />
    </div>
  );
};

export default DecorationPCPage;
