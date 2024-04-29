import { useState, useEffect, useRef } from "react";
import styles from "./index.module.scss";
import { Table } from "antd";
import type { ColumnsType } from "antd/es/table";
import { useDispatch, useSelector } from "react-redux";
import * as echarts from "echarts";
import { stats } from "../../../api/index";
import { titleAction } from "../../../store/user/loginUserSlice";
import { DayWeekMonth } from "../../../components/index";
import moment from "moment";

interface DataType {
  id: React.Key;
  user_id: number;
  user: any;
  count: number;
  total: number;
}

const StatsMemberPage = () => {
  let chartRef = useRef(null);
  const dispatch = useDispatch();
  const [loading, setLoading] = useState<boolean>(false);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(10);
  const [total, setTotal] = useState(0);
  const [list, setList] = useState<any>([]);
  const [start_at, setStartAt] = useState(moment().format("YYYY-MM-DD"));
  const [end_at, setEndAt] = useState(
    moment().add(1, "days").format("YYYY-MM-DD")
  );
  const [topData, setTopData] = useState<any>([]);
  const [firstUserGraph, setFirstUserGraph] = useState<any>([]);

  useEffect(() => {
    document.title = "学员数据";
    dispatch(titleAction("学员数据"));
    getStatData();
    getUserGraphData(
      moment().format("YYYY-MM-DD"),
      moment().add(1, "days").format("YYYY-MM-DD")
    );
    return () => {
      window.onresize = null;
    };
  }, []);

  useEffect(() => {
    getUserTopData();
  }, [page, size, start_at, end_at]);

  const getStatData = () => {
    stats.memberList({}).then((res: any) => {
      setList(res.data);
    });
  };

  const getUserTopData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    stats
      .userTops({
        start_at: start_at,
        end_at: end_at,
        page: page,
        size: size,
      })
      .then((res: any) => {
        setTopData(res.data.data);
        setTotal(res.data.total);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const newSumrate = (num1: number, num2: number) => {
    if (typeof num1 !== "number" || typeof num2 !== "number") {
      return 0;
    }
    if (num1 === 0) {
      // 今天未有增长
      return 0;
    }
    if (num2 === 0) {
      // 昨天无增长，今天有增长 => 100%
      return 100;
    }

    let value: any = ((num1 - num2) / num2).toFixed(2);

    return Math.floor(value * 100);
  };

  const sumrate = (num1: number, num2: number) => {
    if (typeof num1 !== "number" || typeof num2 !== "number") {
      return 0;
    }
    if (num2 === num1) {
      return 100;
    }

    let value: any = (num2 / (num1 - num2)).toFixed(2);

    return Math.floor(value * 100);
  };

  const formatNumber = (num: number) => {
    if (!num) {
      return 0;
    }
    return Number(num).toLocaleString();
  };

  const numberForHuman = (num: number) => {
    if (num >= 100000000) {
      return (num / 100000000).toFixed(2) + "亿";
    } else if (num >= 10000000) {
      return (num / 10000000).toFixed(2) + "千万";
    } else if (num >= 1000000) {
      return (num / 1000000).toFixed(2) + "百万";
    } else if (num >= 10000) {
      return (num / 10000).toFixed(2) + "万";
    }
    return num;
  };

  const paginationPageChange = (page: number) => {
    setPage(page);
  };

  const changeTimeUserTop = (start_at: any, end_at: any) => {
    setStartAt(start_at);
    setEndAt(end_at);
    paginationPageChange(1);
  };

  const paginationProps = {
    current: page, //当前页码
    pageSize: size,
    total: total, // 总条数
    onChange: (page: number, pageSize: number) =>
      handlePageChange(page, pageSize), //改变页码的函数
    showSizeChanger: true,
  };

  const handlePageChange = (page: number, pageSize: number) => {
    setPage(page);
    setSize(pageSize);
  };

  const columns: ColumnsType<DataType> = [
    {
      title: "TOP10付费学员",
      render: (_, record: any) => (
        <>
          {record.user.length === 0 && <span className="c-red">已删除</span>}
          {record.user.length !== 0 && <span>{record.user.nick_name}</span>}
        </>
      ),
    },
    {
      title: "支付订单数",
      width: 250,
      render: (_, record: any) => <span>{record.count}</span>,
    },
    {
      title: "支付总金额",
      width: 250,
      render: (_, record: any) => <span>{record.total}</span>,
    },
  ];

  const getUserGraphData = (start_at: any, end_at: any) => {
    let params = {
      start_at: start_at,
      end_at: end_at,
    };
    stats.userGraph(params).then((res: any) => {
      setFirstUserGraph(res.data["first-non-first"]);
      drawChart(res.data["first-non-first"]);
    });

    return () => {
      window.onresize = null;
    };
  };

  const drawChart = (params: any) => {
    let num = params.first_count + params.non_first_count;
    let data = [
      {
        name: "新成交学员",
        value: params.first_count,
      },
      {
        name: "老成交学员",
        value: params.non_first_count,
      },
    ];
    let dom: any = chartRef.current;
    let myChart = echarts.init(dom);
    myChart.setOption({
      legend: [
        {
          selectedMode: true, // 图例选择的模式，控制是否可以通过点击图例改变系列的显示状态。默认开启图例选择，可以设成 false 关闭。
          bottom: "10%",
          left: "center",
          textStyle: {
            // 图例的公用文本样式。
            fontSize: 14,
            color: " #333333",
          },
          data: ["新成交学员", "老成交学员"],
        },
      ],
      tooltip: {
        show: true, // 是否显示提示框
      },
      title: {
        text: "", //主标题
        left: "center", // 水平对齐方式
        bottom: 0,
        itemGap: 4, // 主副标题相隔间距
        textStyle: {
          // 主标题样式
          fontSize: 16,
          fontWeight: 400,
        },
      },
      series: [
        {
          type: "pie",
          radius: ["40%", "60%"], // 环比 圈的大小
          center: ["50%", "40%"], // 图形在整个canvas中的位置
          color: ["#3A7BFF", "#FF9742"], // item的取色盘
          avoidLabelOverlap: false,
          itemStyle: {
            borderColor: "#fff", // 白边
            borderWidth: 2,
          },
          emphasis: {
            // 高亮item的样式
            disabled: true,
          },
          label: {
            show: true,
            position: "center",
            formatter: "付费" + num + "人", // 可以自定义，也可以{a}{b}{c}这种
          },
          labelLine: {
            show: false,
          },
          data: data,
        },
      ],
    });

    window.onresize = () => {
      myChart.resize();
    };
  };

  return (
    <>
      <div className={styles["el_content"]}>
        <div className={styles["el_top_row1"]}>
          <div className={styles["el_row_item"]}>
            <span className={styles["item_title"]}>今日录播课学习学员</span>
            <p>{formatNumber(list.today_watch_count || 0)}</p>
            <div className={styles["item_info"]}>
              <span>昨日：{numberForHuman(list.yesterday_watch_count)}</span>
              <span>
                较昨日：
                {newSumrate(
                  list.today_watch_count,
                  list.yesterday_watch_count
                ) < 0 && (
                  <strong className="c-danger">
                    {newSumrate(
                      list.today_watch_count,
                      list.yesterday_watch_count
                    )}
                    %
                  </strong>
                )}
                {newSumrate(
                  list.today_watch_count,
                  list.yesterday_watch_count
                ) >= 0 && (
                  <strong>
                    {newSumrate(
                      list.today_watch_count,
                      list.yesterday_watch_count
                    )}
                    %
                  </strong>
                )}
              </span>
            </div>
          </div>
          <div className={styles["el_row_item"]}>
            <span className={styles["item_title"]}>今日新注册学员</span>
            <p>{formatNumber(list.today_count || 0)}</p>
            <div className={styles["item_info"]}>
              <span>昨日：{numberForHuman(list.yesterday_count)}</span>
              <span>
                较昨日：
                {newSumrate(list.today_count, list.yesterday_count) < 0 && (
                  <strong className="c-danger">
                    {newSumrate(list.today_count, list.yesterday_count)}%
                  </strong>
                )}
                {newSumrate(list.today_count, list.yesterday_count) >= 0 && (
                  <strong>
                    {newSumrate(list.today_count, list.yesterday_count)}%
                  </strong>
                )}
              </span>
            </div>
          </div>
          <div className={styles["el_row_item"]}>
            <span className={styles["item_title"]}>总学员数</span>
            <p>{formatNumber(list.user_count || 0)}</p>
            <div className={styles["item_info"]}>
              <span>昨日：{numberForHuman(list.yesterday_count)}</span>
              <span>
                较上周：
                {sumrate(list.user_count, list.week_count) < 0 && (
                  <strong className="c-danger">
                    {sumrate(list.user_count, list.week_count)}%
                  </strong>
                )}
                {sumrate(list.user_count, list.week_count) >= 0 && (
                  <strong>{sumrate(list.user_count, list.week_count)}%</strong>
                )}
              </span>
              <span>
                较上月：
                {sumrate(list.user_count, list.month_count) < 0 && (
                  <strong className="c-danger">
                    {sumrate(list.user_count, list.month_count)}%
                  </strong>
                )}
                {sumrate(list.user_count, list.month_count) >= 0 && (
                  <strong>{sumrate(list.user_count, list.month_count)}%</strong>
                )}
              </span>
            </div>
          </div>
        </div>
        <div className={styles["el_top_row2"]}>
          <div className={styles["el_row_left"]}>
            <div className={styles["header"]}>
              <div className={styles["item_title"]}>
                <span>Top10付费学员</span>
              </div>
              <div className={styles["controls"]}>
                <DayWeekMonth
                  active={false}
                  onChange={(start_at, end_at) => {
                    changeTimeUserTop(start_at, end_at);
                  }}
                ></DayWeekMonth>
              </div>
            </div>
            <div className="float-left mt-15">
              <Table
                loading={loading}
                columns={columns}
                dataSource={topData}
                rowKey={(record) => record.user_id}
                pagination={paginationProps}
              />
            </div>
          </div>
          <div className={styles["el_row_right"]}>
            <div className={styles["el_row_right_item"]}>
              <div className={styles["header"]}>
                <div className={styles["item_title"]}>
                  <span>新老学员成交趋势</span>
                </div>
                <div className={styles["controls"]}>
                  <DayWeekMonth
                    active={false}
                    onChange={(start_at, end_at) => {
                      getUserGraphData(start_at, end_at);
                    }}
                  ></DayWeekMonth>
                </div>
              </div>
              <div
                ref={chartRef}
                style={{
                  width: "100%",
                  height: 273,
                  marginTop: 16,
                  position: "relative",
                }}
              ></div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default StatsMemberPage;
