import { useEffect, useState } from "react";
import { Row, Col, Modal, Empty, message, Pagination } from "antd";
import { media } from "../../api";
import styles from "./index.module.scss";
import { UploadImageSub } from "../upload-image-button/upload-image-sub";
import selectedIcon from "../../assets/home/selected.png";

interface Option {
  id: string | number;
  name: string;
  children?: Option[];
}

interface ImageItem {
  id: number;
  category_id: number;
  name: string;
  extension: string;
  size: number;
  disk: string;
  file_id: string;
  path: string;
  url: string;
  created_at: string;
}

interface PropsInterface {
  open: boolean;
  from: number;
  onCancel: () => void;
  onSelected: (url: string) => void;
}

export const SelectImage = (props: PropsInterface) => {
  const [from, setFrom] = useState(0);
  const [imageList, setImageList] = useState<ImageItem[]>([]);
  const [refresh, setRefresh] = useState(false);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(15);
  const [total, setTotal] = useState(0);
  const [selected, setSelected] = useState<string>("");
  const fromRows = [
    { key: 0, name: "全部图片" },
    {
      key: 1,
      name: "幻灯片",
    },
    {
      key: 2,
      name: "课程封面",
    },
    {
      key: 3,
      name: "课程详情页",
    },
    {
      key: 4,
      name: "文章配图",
    },
  ];

  useEffect(() => {
    setFrom(props.from);
  }, [props.from]);

  // 获取图片列表
  const getImageList = () => {
    media
      .imageList({ page: page, size: size, from: from })
      .then((res: any) => {
        setTotal(res.data.data.total);
        setImageList(res.data.data.data);
      })
      .catch((err) => {
        console.log("错误,", err);
      });
  };
  // 重置列表
  const resetImageList = () => {
    setPage(1);
    setImageList([]);
    setRefresh(!refresh);
  };

  // 加载图片列表
  useEffect(() => {
    if (props.open) {
      getImageList();
    }
  }, [props.open, from, refresh, page, size]);

  return (
    <>
      {props.open ? (
        <Modal
          title="选择图片"
          closable={false}
          onCancel={() => {
            props.onCancel();
          }}
          centered
          open={true}
          width={881}
          maskClosable={false}
          onOk={() => {
            if (!selected) {
              message.error("请选择图片后确定");
              return;
            }
            props.onSelected(selected);
          }}
        >
          <Row style={{ width: 830, minHeight: 520, marginTop: 24 }}>
            <div
              style={{ position: "absolute", right: 30, top: 15, zIndex: 15 }}
            >
              <UploadImageSub
                from={from}
                onUpdate={() => {
                  resetImageList();
                }}
              ></UploadImageSub>
            </div>
            <Col span={5}>
              <div className={styles["category-box"]}>
                {fromRows.map((item: any) => (
                  <div
                    key={item.key}
                    className={
                      item.key === from
                        ? styles["category-act-item"]
                        : styles["category-item"]
                    }
                    onClick={() => setFrom(item.key)}
                  >
                    {item.name}
                  </div>
                ))}
              </div>
            </Col>
            <Col span={19}>
              {imageList.length === 0 && (
                <Col span={24}>
                  <Empty description="暂无图片" />
                </Col>
              )}
              <div className={styles["image-list-box"]}>
                {imageList.map((item) => (
                  <div
                    key={item.id}
                    className={
                      selected.indexOf(item.url) !== -1
                        ? styles["image-active-item"]
                        : styles["image-item"]
                    }
                    onClick={() => {
                      setSelected(item.url);
                    }}
                  >
                    {selected.indexOf(item.url) !== -1 && (
                      <div className={styles["sel"]}>
                        <img src={selectedIcon} />
                      </div>
                    )}
                    <div className={styles["image-render"]}>
                      <div
                        className={styles["image-view"]}
                        style={{ backgroundImage: `url(${item.url})` }}
                      ></div>
                    </div>
                    <div className={styles["image-name"]}>
                      <div className={styles["name"]}>{item.name}</div>
                    </div>
                  </div>
                ))}
              </div>
              {imageList.length > 0 && (
                <Col
                  span={24}
                  style={{
                    display: "flex",
                    flexDirection: "row-reverse",
                    marginTop: 30,
                  }}
                >
                  <Pagination
                    onChange={(currentPage, currentSize) => {
                      setPage(currentPage);
                      setSize(currentSize);
                    }}
                    pageSize={size}
                    defaultCurrent={page}
                    total={total}
                  />
                </Col>
              )}
            </Col>
          </Row>
        </Modal>
      ) : null}
    </>
  );
};
