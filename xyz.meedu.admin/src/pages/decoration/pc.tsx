import { useState, useEffect } from "react";
import { Modal, message, Button, Tooltip } from "antd";
import styles from "./pc.module.scss";
import { useNavigate, useSearchParams } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { viewBlock, decorationPage } from "../../api/index";
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
import { RenderVod } from "./components/pc/render-vod";
import { RenderCode } from "./components/pc/render-code";
import { RenderSliderBlock } from "./components/pc/render-slider-block";
import { PCConfigSetting } from "./components/pc/config/index";
import vodIcon from "../../assets/images/decoration/h5/h5-vod-v1.png";
import codeIocn from "../../assets/images/decoration/h5/code.png";
import sliderIcon from "../../assets/images/decoration/h5/slider.png";
const { confirm } = Modal;

const DecorationPCPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();
  const pageId = parseInt(searchParams.get("page_id") || "0");

  const [loading, setLoading] = useState<boolean>(false);
  const [platform] = useState("pc");
  const [page, setPage] = useState<string>("");
  const [pageName, setPageName] = useState<string>("");
  const [blocks, setBlocks] = useState<any>([]);
  const [curBlockIndex, setCurBlockIndex] = useState<any>(null);
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
    if (pageId > 0) {
      getPageInfo();
    }
  }, [pageId]);

  useEffect(() => {
    if (page) {
      window.addEventListener("resize", getScreenWidth, false);
      getData();
      return () => {
        window.removeEventListener("resize", getScreenWidth, false);
      };
    }
  }, [page, platform]);

  const getPageInfo = () => {
    decorationPage
      .detail(pageId)
      .then((res: any) => {
        setPage(res.data.page_key);
        setPageName(res.data.name);
      })
      .catch((e) => {
        message.error("页面不存在");
        navigate("/decoration/pc/pages");
      });
  };

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
        page_id: pageId,
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
    } else if (sign === "code") {
      defaultConfig = {
        html: null,
      };
    } else if (sign === "pc-slider") {
      defaultConfig = [
        {
          src: null,
          href: null,
        },
      ];
    }

    viewBlock
      .store({
        platform: platform,
        page: page,
        page_id: pageId,
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
        page_id: pageId,
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
        page_id: pageId,
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
          返回页面管理
        </div>
        <div className={styles["line"]}></div>
        <div className={styles["name"]}>{pageName || "电脑端装修"}</div>
      </div>
      <div className={styles["blocks-box"]}>
        <div className={styles["title"]}>拖动添加板块</div>
        <div className={styles["tip"]}>拖动下列图标到右侧预览区</div>
        <div className={styles["blocks"]}>
          <div
            className={styles["block-item"]}
            draggable
            onDragEnd={(e: any) => {
              dragChange(e, "pc-slider");
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
          {blocks.length > 0 &&
            blocks.map((item: any, index: number) => (
              <div className="float-left" key={index}>
                <div
                  className={curBlockIndex === index ? "active item" : "item"}
                  onClick={() => setCurBlockIndex(index)}
                >
                  {item.sign === "pc-slider" && (
                    <RenderSliderBlock config={item.config_render} />
                  )}
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
          <PCConfigSetting
            block={blocks[curBlockIndex]}
            onUpdate={() => reloadData()}
          />
        </div>
      )}
    </div>
  );
};

export default DecorationPCPage;
