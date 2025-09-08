import React, { useState, useEffect } from "react";
import { Row, Col, Spin, Pagination } from "antd";
import styles from "./index.module.scss";
import { useNavigate } from "react-router-dom";
import { NavMember, Empty, ThumbBar } from "../../../components";
import { user as member } from "../../../api/index";
import { getCommentTime } from "../../../utils/index";
import defaultPaperIcon from "../../../assets/img/commen/default-paper.png";
import defaultVipIcon from "../../../assets/img/commen/default-vip.png";
import defaultTopicIcon from "../../../assets/img/commen/default-article.png";
import defaultCourseIcon from "../../../assets/img/commen/default-lesson.png";
import defaultVideoIcon from "../../../assets/img/commen/default-video.png";
import defaultStepsIcon from "../../../assets/img/commen/default-steps.png";
import defaultLiveIcon from "../../../assets/img/commen/default-live.png";
import defaultBookIcon from "../../../assets/img/commen/default-ebook.png";

const MemberOrdersPage = () => {
  document.title = "所有订单";
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [refresh, setRefresh] = useState(false);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(10);
  const [total, setTotal] = useState(0);

  useEffect(() => {
    getData();
  }, [page, size, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    member.orders({ page: page, page_size: size }).then((res: any) => {
      setList(res.data.data);
      setTotal(res.data.total);
      setLoading(false);
    });
  };

  const resetData = () => {
    setPage(1);
    setList([]);
    setRefresh(!refresh);
  };

  const goDetail = (item: any) => {
    if (item.goods[0].goods_type === "ROLE") {
      navigate("/vip");
    } else if (item.goods[0].goods_type === "BOOK") {
      navigate("/book/detail/" + item.goods[0].goods_id);
    } else if (item.goods[0].goods_type === "COURSE") {
      navigate("/courses/detail/" + item.goods[0].goods_id);
    } else if (item.goods[0].goods_type === "直播课程") {
      navigate("/live/detail/" + item.goods[0].goods_id);
    } else if (item.goods[0].goods_type === "文章") {
      navigate("/topic/detail/" + item.goods[0].goods_id);
    } else if (item.goods[0].goods_type === "VIDEO") {
      navigate("/courses/video/" + item.goods[0].goods_id);
    } else if (item.goods[0].goods_type === "学习路径") {
      navigate("/learnPath/detail/" + item.goods[0].goods_id);
    } else if (item.goods[0].goods_type === "试卷") {
      navigate("/exam/papers/detail/" + item.goods[0].goods_id);
    } else if (item.goods[0].goods_type === "练习") {
      navigate("/exam/practice/detail/" + item.goods[0].goods_id);
    } else if (item.goods[0].goods_type === "模拟试卷") {
      navigate("/exam/mockpaper/detail/" + item.goods[0].goods_id);
    }
  };

  return (
    <div className="container">
      <div className={styles["box"]}>
        <NavMember cid={6} refresh={true}></NavMember>
        <div className={styles["project-box"]}>
          {loading && (
            <Row>
              <div className="float-left d-j-flex mt-50">
                <Spin size="large" />
              </div>
            </Row>
          )}
          {!loading && list.length === 0 && (
            <Col span={24}>
              <Empty></Empty>
            </Col>
          )}
          {!loading && list.length > 0 && (
            <div className={styles["project-content"]}>
              {list.map((item: any) => (
                <div
                  key={item.id}
                  className={styles["project-item"]}
                  onClick={() => goDetail(item)}
                >
                  {item.goods[0] && item.goods[0].goods_thumb ? (
                    <div className={styles["item-thumb"]}>
                      {item.goods[0].goods_type === "模拟试卷" ||
                      item.goods[0].goods_type === "试卷" ||
                      item.goods[0].goods_type === "练习" ? (
                        <img src={defaultPaperIcon} />
                      ) : item.goods[0].goods_type === "BOOK" ? (
                        <ThumbBar
                          value={item.goods[0].goods_thumb}
                          width={75}
                          height={100}
                          border={8}
                        />
                      ) : (
                        <ThumbBar
                          value={item.goods[0].goods_thumb}
                          width={133}
                          height={100}
                          border={8}
                        />
                      )}
                    </div>
                  ) : item.goods[0].goods_type === "ROLE" ? (
                    <div className={styles["item-thumb"]}>
                      <img src={defaultVipIcon} />
                    </div>
                  ) : item.goods[0].goods_type === "文章" ? (
                    <div className={styles["item-thumb"]}>
                      <img src={defaultTopicIcon} />
                    </div>
                  ) : item.goods[0].goods_type === "COURSE" ? (
                    <div className={styles["item-thumb"]}>
                      <img src={defaultCourseIcon} />
                    </div>
                  ) : item.goods[0].goods_type === "模拟试卷" ||
                    item.goods[0].goods_type === "试卷" ||
                    item.goods[0].goods_type === "练习" ? (
                    <div className={styles["item-thumb"]}>
                      <img src={defaultPaperIcon} />
                    </div>
                  ) : item.goods[0].goods_type === "VIDEO" ? (
                    <div className={styles["item-thumb"]}>
                      <img src={defaultVideoIcon} />
                    </div>
                  ) : item.goods[0].goods_type === "学习路径" ? (
                    <div className={styles["item-thumb"]}>
                      <img src={defaultStepsIcon} />
                    </div>
                  ) : item.goods[0].goods_type === "直播课程" ? (
                    <div className={styles["item-thumb"]}>
                      <img src={defaultLiveIcon} />
                    </div>
                  ) : item.goods[0].goods_type === "BOOK" ? (
                    <div className={styles["item-thumb"]}>
                      <img src={defaultBookIcon} />
                    </div>
                  ) : (
                    <div className={styles["item-thumb"]}></div>
                  )}
                  <div className={styles["item-info"]}>
                    <div className={styles["item-top"]}>
                      {item.goods[0] && (
                        <div className={styles["item-name"]}>
                          {item.goods[0].goods_name}
                        </div>
                      )}
                      <div className={styles["order-num"]}>
                        订单编号：{item.order_id}
                      </div>
                      <div className={styles["item-time"]}>
                        {getCommentTime(item.created_at)}
                      </div>
                    </div>
                    <div className={styles["item-bottom"]}>
                      {item.status_text === "已支付" && (
                        <div className={styles["item-price"]}>
                          实付款：￥{item.charge}
                          {item.refund_amount > 0 && (
                            <span style={{ marginLeft: 10, color: "#FF6B6B" }}>
                              已退金额：￥{item.refund_amount.toFixed(2)}
                            </span>
                          )}
                        </div>
                      )}
                      <div
                        className={
                          item.status_text === "未支付" ||
                          item.status_text === "支付中"
                            ? styles["item-act-status"]
                            : styles["item-status"]
                        }
                      >
                        {item.status_text}
                      </div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          )}
          {!loading && list.length > 0 && size < total && (
            <Col
              span={24}
              style={{
                display: "flex",
                justifyContent: "center",
                marginTop: 50,
                marginBottom: 30,
              }}
            >
              <Pagination
                onChange={(currentPage) => {
                  setPage(currentPage);
                  window.scrollTo(0, 0);
                }}
                pageSize={size}
                defaultCurrent={page}
                total={total}
              />
            </Col>
          )}
        </div>
      </div>
    </div>
  );
};

export default MemberOrdersPage;
