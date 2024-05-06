import { useState, useEffect, useRef } from "react";
import styles from "./index.module.scss";
import { DatePicker, Button } from "antd";
import { useDispatch, useSelector } from "react-redux";
import { home } from "../../api/index";
import * as echarts from "echarts";
import { titleAction } from "../../store/user/loginUserSlice";

const { RangePicker } = DatePicker;

const DashboardPage = () => {
  const funDate = (aa: number) => {
    let time2 = "";
    let date1 = new Date();
    let date2 = new Date(date1);
    date2.setDate(date1.getDate() + aa);
    time2 =
      date2.getFullYear() +
      "-" +
      (date2.getMonth() + 1) +
      "-" +
      date2.getDate();
    return time2;
  };

  const chartRef = useRef(null);
  const dispatch = useDispatch();
  const [basicData, setBasicData] = useState<any>({});
  const [systemInfo, setSystemInfo] = useState<any>({});
  const [start_at, setStartAt] = useState(funDate(-7));
  const [end_at, setEndAt] = useState(
    new Date().getFullYear() +
      "-" +
      (new Date().getMonth() + 1) +
      "-" +
      new Date().getDate()
  );
  const [flagE, setFlagE] = useState(1);
  const [userCountIncRate, setUserCountIncRate] = useState(0);
  const [thisMonthPaidRate, setThisMonthPaidRate] = useState(0);
  const user = useSelector((state: any) => state.loginUser.value.user);

  useEffect(() => {
    document.title = "MeEdu后台管理";
    dispatch(titleAction("主页"));
    getStatData();
    getSystemInfo();
    getZXTdata();
  }, []);

  useEffect(() => {
    if (
      typeof basicData.today_register_user_count === "undefined" ||
      typeof basicData.user_count === "undefined" ||
      isNaN(basicData.today_register_user_count) ||
      isNaN(basicData.user_count) ||
      basicData.user_count === 0
    ) {
      setUserCountIncRate(0);
    } else {
      let value: any = (
        basicData.today_register_user_count / basicData.user_count
      ).toFixed(3);
      setUserCountIncRate(Math.floor(value * 100));
    }
    setThisMonthPaidRate(
      sumrate(basicData.this_month_paid_sum, basicData.last_month_paid_sum)
    );
  }, [basicData]);

  const getStatData = () => {
    home.index().then((res: any) => {
      setBasicData(res.data);
    });
  };

  const getSystemInfo = () => {
    home.systemInfo().then((res: any) => {
      setSystemInfo(res.data);
    });
  };

  const changeObjectKey = (obj: any) => {
    var arr = [];
    for (let i in obj) {
      arr.push(i); //返回键名
    }
    return arr;
  };

  const changeObject = (obj: any) => {
    let data = Object.values(obj);
    return data;
  };

  const getZXTdata = () => {
    let uid = "userRegister";
    if (flagE == 2) {
      uid = "orderCreated";
    } else if (flagE == 3) {
      uid = "orderPaidCount";
    } else if (flagE == 4) {
      uid = "orderPaidSum";
    } else {
      uid = "userRegister";
    }
    let databox = {
      start_at: start_at,
      end_at: end_at,
    };
    home.statistic(databox).then((res: any) => {
      drawLineChart(res.data);
    });

    return () => {
      window.onresize = null;
    };
  };

  const drawLineChart = (params: any) => {
    let dom: any = chartRef.current;
    let myChart = echarts.init(dom);
    myChart.setOption({
      tooltip: {
        trigger: "axis",
      },
      legend: {
        data: ["每日注册用户", "每日创建订单", "每日已支付订单", "每日营收"],
        x: "right",
      },
      grid: {
        left: "3%",
        right: "4%",
        bottom: "3%",
        containLabel: true,
      },
      xAxis: {
        type: "category",
        boundaryGap: false,
        data: changeObjectKey(params.order_created),
      },
      yAxis: {
        type: "value",
      },
      series: [
        {
          name: "每日注册用户",
          type: "line",
          data: changeObject(params.user_register),
        },
        {
          name: "每日创建订单",
          type: "line",
          data: changeObject(params.order_created),
        },
        {
          name: "每日已支付订单",
          type: "line",
          data: changeObject(params.order_paid),
        },
        {
          name: "每日营收",
          type: "line",
          data: changeObject(params.order_sum),
        },
      ],
    });

    window.onresize = () => {
      myChart.resize();
    };
  };

  const onChange = (date: any, dateString: any) => {
    dateString[1] += " 23:59:59";
    setStartAt(dateString[0]);
    setEndAt(dateString[1]);
  };

  const formatNumber = (num: number) => {
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
    } else if (num >= 1000) {
      return (num / 1000).toFixed(2) + "千";
    }
    return num;
  };

  const sumrate = (num1: number, num2: number) => {
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

  return (
    <>
      <div className={styles["el_content"]}>
        <div className={styles["el_top_row1"]}>
          <div className={styles["el_row_item"]}>
            <span className={styles["item_title"]}>今日收入(元)</span>
            <p>{formatNumber(basicData.today_paid_sum || 0)}</p>
            <div className={styles["item_info"]}>
              <span>昨日：{numberForHuman(basicData.yesterday_paid_sum)}</span>
              <span>
                较昨日：
                {sumrate(
                  basicData.today_paid_sum,
                  basicData.yesterday_paid_sum
                ) < 0 && (
                  <strong className="c-danger">
                    {sumrate(
                      basicData.today_paid_sum,
                      basicData.yesterday_paid_sum
                    )}
                    %
                  </strong>
                )}
                {sumrate(
                  basicData.today_paid_sum,
                  basicData.yesterday_paid_sum
                ) >= 0 && (
                  <strong>
                    {sumrate(
                      basicData.today_paid_sum,
                      basicData.yesterday_paid_sum
                    )}
                    %
                  </strong>
                )}
              </span>
            </div>
          </div>
          <div className={styles["el_row_item"]}>
            <span className={styles["item_title"]}>今日支付人数</span>
            <p>{formatNumber(basicData.today_paid_user_num || 0)}</p>
            <div className={styles["item_info"]}>
              <span>
                昨日：{numberForHuman(basicData.yesterday_paid_user_num)}
              </span>
              <span>
                较昨日：
                {sumrate(
                  basicData.today_paid_user_num,
                  basicData.yesterday_paid_user_num
                ) < 0 && (
                  <strong className="c-danger">
                    {sumrate(
                      basicData.today_paid_user_num,
                      basicData.yesterday_paid_user_num
                    )}
                    %
                  </strong>
                )}
                {sumrate(
                  basicData.today_paid_user_num,
                  basicData.yesterday_paid_user_num
                ) >= 0 && (
                  <strong>
                    {sumrate(
                      basicData.today_paid_user_num,
                      basicData.yesterday_paid_user_num
                    )}
                    %
                  </strong>
                )}
              </span>
            </div>
          </div>
          <div className={styles["el_row_item2"]}>
            <div className={styles["el_item"]}>
              <span>总学员数</span>
              <span className={styles["el_item_num"]}>
                {formatNumber(basicData.user_count || 0)}
              </span>

              <span className={styles["el_item_increase"]}>
                较昨日：
                {userCountIncRate < 0 && (
                  <strong className="c-danger">{userCountIncRate}%</strong>
                )}
                {userCountIncRate >= 0 && <strong>{userCountIncRate}%</strong>}
              </span>
            </div>
            <div className={styles["el_item"]}>
              <span>本月收入(元)</span>
              <span className={styles["el_item_num"]}>
                {formatNumber(basicData.this_month_paid_sum || 0)}
              </span>

              <span className={styles["el_item_increase"]}>
                较上月：
                {thisMonthPaidRate < 0 && (
                  <strong className="c-danger">{thisMonthPaidRate}%</strong>
                )}
                {thisMonthPaidRate >= 0 && (
                  <strong>{thisMonthPaidRate}%</strong>
                )}
              </span>
            </div>
          </div>
        </div>
        <div className={styles["el_top_row3"]}>
          <div className={styles["tit"]}>统计分析</div>
          <div className={styles["selcharttimebox"]}>
            <RangePicker format={"YYYY-MM-DD"} onChange={onChange} />
            <Button
              type="primary"
              className="ml-10"
              onClick={() => {
                getZXTdata();
              }}
            >
              筛选
            </Button>
          </div>
          <div className={styles["charts"]}>
            <div
              ref={chartRef}
              style={{
                width: "100%",
                height: 280,
                marginLeft: -30,
                position: "relative",
              }}
            ></div>
          </div>
        </div>
        <div className={styles["copyright"]}>
          <p className="mb-10">Powered By MeEdu</p>
          <p className={styles["info"]}>
            <span>PHP{systemInfo.php_version} </span>
            <span className="mx-10">API程序{systemInfo.meedu_version}</span>
            <span>后台前端程序v4.9.17</span>
          </p>
        </div>
      </div>
    </>
  );
};
export default DashboardPage;
