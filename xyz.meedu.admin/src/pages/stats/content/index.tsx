import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Radio, Table, Tooltip } from "antd";
import type { ColumnsType } from "antd/es/table";
import { useSearchParams } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { stats } from "../../../api/index";
import { titleAction } from "../../../store/user/loginUserSlice";
import moment from "moment";
import { DayWeekMonth } from "../../../components/index";
import { InfoCircleOutlined } from "@ant-design/icons";

interface DataType {
  id: React.Key;
  goods_name: string;
  orders_count: number;
  orders_paid_sum: number;
}

interface LocalSearchParamsInterface {
  page?: number;
  size?: number;
  goodsType?: string;
}

const StatsContentPage = () => {
  const dispatch = useDispatch();
  const [searchParams, setSearchParams] = useSearchParams({
    page: "1",
    size: "10",
    goodsType: "COURSE",
  });
  const page = parseInt(searchParams.get("page") || "1");
  const size = parseInt(searchParams.get("size") || "10");
  const goodsType = searchParams.get("goodsType") || "COURSE";

  const [loading, setLoading] = useState<boolean>(false);
  const [total, setTotal] = useState(0);
  const [list, setList] = useState<any>([]);
  const [refresh, setRefresh] = useState(false);
  const [start_at, setStartAt] = useState(
    moment().subtract(6, "days").format("YYYY-MM-DD")
  );
  const [end_at, setEndAt] = useState(
    moment().add(1, "days").format("YYYY-MM-DD")
  );
  const [typeList, setTypeList] = useState<any>([]);
  const enabledAddons = useSelector(
    (state: any) => state.enabledAddonsConfig.value.enabledAddons
  );

  useEffect(() => {
    document.title = "商品数据";
    dispatch(titleAction("商品数据"));
  }, []);

  useEffect(() => {
    getData();
  }, [page, size, start_at, end_at, goodsType, refresh]);

  useEffect(() => {
    let typeList = [
      {
        name: "录播课",
        key: "COURSE",
      },
    ];

    typeList.push({
      name: "VIP会员",
      key: "ROLE",
    });
    setTypeList(typeList);
  }, [enabledAddons]);

  const resetLocalSearchParams = (params: LocalSearchParamsInterface) => {
    setSearchParams(
      (prev) => {
        if (typeof params.goodsType !== "undefined") {
          prev.set("goodsType", params.goodsType);
        }
        if (typeof params.page !== "undefined") {
          prev.set("page", params.page + "");
        }
        if (typeof params.size !== "undefined") {
          prev.set("size", params.size + "");
        }
        return prev;
      },
      { replace: true }
    );
  };

  const paginationPageChange = (page: number) => {
    resetLocalSearchParams({
      page: page,
    });
    setRefresh(!refresh);
  };

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    stats
      .contentList({
        page: page,
        size: size,
        start_at: start_at,
        end_at: end_at,
        goods_type: goodsType,
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

  const paginationReset = () => {
    setStartAt(moment().subtract(6, "days").format("YYYY-MM-DD"));
    setEndAt(moment().add(1, "days").format("YYYY-MM-DD"));
    setRefresh(!refresh);
  };

  const changeTimeContentTop = (start_at: any, end_at: any) => {
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
    resetLocalSearchParams({
      page: page,
      size: pageSize,
    });
  };

  const columns: ColumnsType<DataType> = [
    {
      title: (
        <div className="d-flex">
          <span className="mr-5">Top10销售额</span>
          <Tooltip
            placement="rightTop"
            title="团购秒杀活动销量不计入此列表统计"
          >
            <InfoCircleOutlined />
          </Tooltip>
        </div>
      ),
      render: (_, record: any) => <span>{record.goods_name}</span>,
    },
    {
      title: "支付订单数",
      width: 250,
      render: (_, record: any) => <span>{record.orders_count}</span>,
    },
    {
      title: "支付总金额",
      width: 250,
      render: (_, record: any) => <span>{record.orders_paid_sum}</span>,
    },
  ];

  return (
    <div className={styles["el_content"]}>
      <div className={styles["el_top_row1"]}>
        <div className={styles["el_row_item"]}>
          <div className={styles["header"]}>
            <div className={styles["tabs"]}>
              <Radio.Group
                size="large"
                defaultValue={goodsType}
                buttonStyle="solid"
                onChange={(e) => {
                  resetLocalSearchParams({
                    page: 1,
                    size: 10,
                    goodsType: e.target.value,
                  });
                  paginationPageChange(1);
                }}
              >
                {typeList.length > 0 &&
                  typeList.map((item: any) => (
                    <Radio.Button key={item.key} value={item.key}>
                      {item.name}
                    </Radio.Button>
                  ))}
              </Radio.Group>
            </div>
            <div className={styles["controls"]}>
              <DayWeekMonth
                active={true}
                onChange={(start_at, end_at) => {
                  changeTimeContentTop(start_at, end_at);
                }}
              ></DayWeekMonth>
            </div>
          </div>
          <div className="float-left mt-15">
            <Table
              loading={loading}
              columns={columns}
              dataSource={list}
              rowKey={(record) => record.id}
              pagination={paginationProps}
            />
          </div>
        </div>
      </div>
    </div>
  );
};
export default StatsContentPage;
