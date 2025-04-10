import React, { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Row, Col, Skeleton, Pagination, Radio } from "antd";
import type { RadioChangeEvent } from "antd";
import { user as member, study } from "../../api/index";
import { Empty } from "../../components";
import { useSelector } from "react-redux";
import { CourseItemComp } from "./components/course-item";
import studyIcon from "../../assets/img/study/icon-mystudy.png";

const StudyCenterPage = () => {
  const [loading, setLoading] = useState<boolean>(false);
  const [current, setCurrent] = useState("vod");
  const [tabs, setTabs] = useState<any>([]);
  const [currentStatus, setCurrentStatus] = useState<any>(1);
  const [list, setList] = useState<any>([]);
  const [refresh, setRefresh] = useState(false);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(10);
  const [total, setTotal] = useState(0);
  const configFunc = useSelector(
    (state: any) => state.systemConfig.value.configFunc
  );

  useEffect(() => {
    document.title = "我的学习";
    let types = [
      {
        name: "录播课",
        value: "vod",
      },
    ];

    setTabs(types);
  }, [configFunc]);

  useEffect(() => {
    if (currentStatus == 1) {
      getViewStudy();
    } else if (currentStatus == 2) {
      getUserCourses();
    } else if (currentStatus == 3) {
      getLikeCourses();
    }
  }, [refresh, page, size, currentStatus, current]);

  const getViewStudy = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    if (current === "vod") {
      study
        .courses({
          page: page,
          size: size,
        })
        .then((res: any) => {
          setList(res.data.data);
          setTotal(res.data.total);
          setLoading(false);
        })
        .catch((e) => {
          setLoading(false);
        });
    }
  };

  const getUserCourses = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    member
      .newCourses({
        page: page,
        size: size,
      })
      .then((res: any) => {
        setList(res.data.data);
        setTotal(res.data.total);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const getLikeCourses = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    if (current === "vod") {
      member
        .collects({
          page: page,
          size: size,
        })
        .then((res: any) => {
          setList(res.data.data);
          setTotal(res.data.total);
          setLoading(false);
        })
        .catch((e) => {
          setLoading(false);
        });
    }
  };

  const onChange = (e: RadioChangeEvent) => {
    if (loading) {
      return;
    }
    setCurrentStatus(e.target.value);
  };

  return (
    <>
      <div className={styles["content"]}>
        <div className={styles["container"]}>
          <div className={styles["top-box"]}>
            <div className={styles["top-title"]}>
              <img className={styles["icon"]} src={studyIcon} />
              我的学习
            </div>
            <div className={styles["top-status"]}>
              <Radio.Group onChange={onChange} value={currentStatus}>
                <Radio value={1} style={{ marginRight: 40 }}>
                  在学
                </Radio>
                <Radio value={2} style={{ marginRight: 40 }}>
                  购买
                </Radio>
                <Radio value={3}>收藏</Radio>
              </Radio.Group>
            </div>
          </div>
          <div className={styles["list-box"]}>
            {loading && (
              <Row>
                <div
                  style={{
                    width: 1200,
                    display: "flex",
                    flexDirection: "column",
                  }}
                >
                  {Array.from({ length: 5 }).map((_, i) => (
                    <div
                      key={i}
                      style={{
                        width: 1200,
                        height: 120,
                        marginBottom: 30,
                        display: "flex",
                        flexDirection: "row",
                      }}
                    >
                      <Skeleton.Button
                        active
                        style={{
                          width: 160,
                          height: 120,
                          borderRadius: 4,
                          marginRight: 30,
                        }}
                      ></Skeleton.Button>
                      <Skeleton active paragraph={{ rows: 1 }}></Skeleton>
                    </div>
                  ))}
                </div>
              </Row>
            )}
            {!loading && list.length === 0 && (
              <Col span={24}>
                <Empty></Empty>
              </Col>
            )}
            {!loading && list.length > 0 && (
              <>
                {current === "vod" && (
                  <CourseItemComp
                    list={list}
                    currentStatus={currentStatus}
                  ></CourseItemComp>
                )}
              </>
            )}
            {!loading && list.length > 0 && size < total && (
              <Col
                span={24}
                style={{
                  display: "flex",
                  justifyContent: "center",
                  marginTop: 50,
                }}
              >
                <Pagination
                  onChange={(currentPage) => {
                    setPage(currentPage);
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
    </>
  );
};

export default StudyCenterPage;
