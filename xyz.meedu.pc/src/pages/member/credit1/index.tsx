import React, { useState, useEffect } from "react";
import { Row, Col, Spin, Pagination } from "antd";
import styles from "./index.module.scss";
import { useOutletContext } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { Empty } from "../../../components";
import { user as member, system } from "../../../api/index";
import { changeTime } from "../../../utils/index";
import { loginAction } from "../../../store/user/loginUserSlice";
import { saveConfigAction } from "../../../store/system/systemConfigSlice";
import type { MemberLayoutContextValue } from "../layout";

const MemberCredit1FreePage = () => {
  document.title = "我的积分";
  const dispatch = useDispatch();
  const { setActiveId } = useOutletContext<MemberLayoutContextValue>();
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [refresh, setRefresh] = useState(false);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(10);
  const [total, setTotal] = useState(0);
  const user = useSelector((state: any) => state.loginUser.value.user);
  const config = useSelector((state: any) => state.systemConfig.value.config);

  useEffect(() => {
    getData();
    getUser();
    getConfig();
  }, [page, size, refresh]);

  useEffect(() => {
    setActiveId(18);
  }, [setActiveId]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    member.credit1Records({ page: page, page_size: size }).then((res: any) => {
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

  const getUser = () => {
    member.detail().then((res: any) => {
      let loginData = res.data;
      dispatch(loginAction(loginData));
    });
  };

  const getConfig = () => {
    system.config().then((res: any) => {
      let config = res.data;
      dispatch(saveConfigAction(config));
    });
  };

  return (
    <div className={styles["right-box"]}>
      <div className={styles["exchange-box"]}>
        <div className={styles["exchange-content"]}>
          <div className={styles["tit"]}>我的积分：</div>
          <div className={styles["credit"]}>{user.credit1}积分</div>
        </div>
      </div>
      <div className={styles["rules"]}>
        <div className={styles["project-box"]}>
          <div className={styles["btn-title"]}>积分明细</div>
          {loading && (
            <Row>
              <div className="float-left d-j-flex mt-50">
                <Spin size="large" />
              </div>
            </Row>
          )}
          {!loading && list.length === 0 && (
            <Col span={24}>
              <Empty />
            </Col>
          )}
          {!loading && list.length > 0 && (
            <>
              {list.map((item: any, index: number) => (
                <div key={index} className={styles["project-item"]}>
                  <div className={styles["title"]}>{item.remark}</div>
                  <div className={styles["value"]}>
                    {item.sum > 0 ? (
                      <span>+{item.sum}</span>
                    ) : (
                      <span>{item.sum}</span>
                    )}
                  </div>
                  <div className={styles["info"]}>
                    <span>{changeTime(item.created_at)}</span>
                  </div>
                </div>
              ))}
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
                  window.scrollTo(0, 0);
                }}
                pageSize={size}
                defaultCurrent={page}
                total={total}
                showSizeChanger={false}
              />
            </Col>
          )}
        </div>
        <div className={styles["rules-content"]}>
          <div className={styles["btn-title"]}>积分获取</div>
          {config.credit1_reward.register !== 0 && (
            <div className={styles["rules-item"]}>
              <p>• 注册登录 +{config.credit1_reward.register} 积分</p>
            </div>
          )}
          {config.credit1_reward.watched_video !== 0 && (
            <div className={styles["rules-item"]}>
              <p>• 看完视频 +{config.credit1_reward.watched_video} 积分</p>
            </div>
          )}
          {config.credit1_reward.watched_vod_course !== 0 && (
            <div className={styles["rules-item"]}>
              <p>• 看完课程 +{config.credit1_reward.watched_vod_course} 积分</p>
            </div>
          )}
          {config.credit1_reward.paid_order !== 0 && (
            <div className={styles["rules-item"]}>
              <p>
                • 下单成功 +实付金额*
                {Math.floor(Number(config.credit1_reward.paid_order) * 100)}%
                积分
              </p>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default MemberCredit1FreePage;
