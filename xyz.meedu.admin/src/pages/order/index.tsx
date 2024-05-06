import { useState, useEffect } from "react";
import {
  Table,
  Select,
  message,
  Drawer,
  Input,
  Button,
  DatePicker,
  Space,
  Tabs,
  Dropdown,
} from "antd";
import { useNavigate, useSearchParams } from "react-router-dom";
import type { ColumnsType } from "antd/es/table";
import type { MenuProps } from "antd";
import { useDispatch } from "react-redux";
import { order } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import { PerButton } from "../../components";
import { dateFormat } from "../../utils/index";
import { DownOutlined } from "@ant-design/icons";
import filterIcon from "../../assets/img/icon-filter.png";
import filterHIcon from "../../assets/img/icon-filter-h.png";
import aliIcon from "../../assets/img/ali-pay.png";
import wepayIcon from "../../assets/img/wepay.png";
import cardIcon from "../../assets/img/card.png";
import { RefundDialog } from "./components/refund-dailog";
import moment from "moment";
import * as XLSX from "xlsx";
import dayjs from "dayjs";

const { RangePicker } = DatePicker;

interface DataType {
  id: React.Key;
  charge: number;
  updated_at: string;
}

interface LocalSearchParamsInterface {
  page?: number;
  size?: number;
  goods_name?: string;
  order_id?: string;
  is_refund?: number;
  status?: string;
  payment?: any;
  created_at?: any;
}

const OrderPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [searchParams, setSearchParams] = useSearchParams({
    page: "1",
    size: "10",
    goods_name: "",
    order_id: "",
    is_refund: "-1",
    status: "",
    payment: "[]",
    created_at: "[]",
  });
  const page = parseInt(searchParams.get("page") || "1");
  const size = parseInt(searchParams.get("size") || "10");
  const [goods_name, setGoodsName] = useState(
    searchParams.get("goods_name") || ""
  );
  const [order_id, setOrderId] = useState(searchParams.get("order_id") || "");
  const [is_refund, setIsRefund] = useState(
    Number(searchParams.get("is_refund") || -1)
  );
  const status = searchParams.get("status");
  const [payment, setPayment] = useState<any>(
    JSON.parse(searchParams.get("payment") || "[]")
  );
  const [created_at, setCreatedAt] = useState<any>(
    JSON.parse(searchParams.get("created_at") || "[]")
  );
  const [createdAts, setCreatedAts] = useState<any>(
    created_at.length > 0
      ? [dayjs(created_at[0], "YYYY-MM-DD"), dayjs(created_at[1], "YYYY-MM-DD")]
      : []
  );

  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);
  const [drawer, setDrawer] = useState(false);
  const [showStatus, setShowStatus] = useState(false);
  const [countMap, setCountMap] = useState<any>({ 1: 0, 5: 0, 7: 0, 9: 0 });
  const [users, setUsers] = useState<any>({});
  const [orderTotal, setOrderTotal] = useState(0);
  const [visiable, setVisiable] = useState<boolean>(false);
  const [orderItem, setOrderItem] = useState({});
  const [types, setTypes] = useState<any>([
    {
      label: "全部",
      key: "",
    },
    {
      label: "已支付",
      key: "9",
    },
    {
      label: "支付中",
      key: "5",
    },
    {
      label: "未支付",
      key: "1",
    },
    {
      label: "已取消",
      key: "7",
    },
  ]);
  const payments = [
    {
      value: "alipay",
      label: "支付宝支付",
    },
    {
      value: "wechat",
      label: "微信支付",
    },

    {
      value: "handPay",
      label: "线下打款",
    },
  ];
  const refunds = [
    {
      label: "是否有退款",
      value: -1,
    },
    {
      label: "有退款",
      value: 1,
    },
    {
      label: "无退款",
      value: 0,
    },
  ];

  useEffect(() => {
    document.title = "全部订单";
    dispatch(titleAction("全部订单"));
  }, []);

  useEffect(() => {
    if (countMap === null) {
      setOrderTotal(0);
    } else {
      let total = 0;
      for (let i = 1; i < types.length; i++) {
        total += countMap[types[i].key];
      }
      setOrderTotal(total);
    }
  }, [countMap, types]);

  useEffect(() => {
    let statusRows = [
      {
        label: "全部(" + orderTotal + ")",
        key: "",
      },
      {
        label: "已支付(" + countMap[9] + ")",
        key: "9",
      },
      {
        label: "支付中(" + countMap[5] + ")",
        key: "5",
      },
      {
        label: "未支付(" + countMap[1] + ")",
        key: "1",
      },
      {
        label: "已取消(" + countMap[7] + ")",
        key: "7",
      },
    ];
    setTypes(statusRows);
  }, [orderTotal, countMap]);

  useEffect(() => {
    getData();
  }, [page, size, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    let time = [...created_at];
    if (time.length > 0) {
      time[1] += " 23:59:59";
    }
    setLoading(true);
    order
      .list({
        page: page,
        size: size,
        sort: "id",
        order: "desc",
        order_id: order_id,
        goods_name: goods_name,
        is_refund: is_refund,
        status: status,
        created_at: time,
        payment: payment,
      })
      .then((res: any) => {
        setList(res.data.orders.data);
        setTotal(res.data.orders.total);
        setCountMap(res.data.countMap);
        setUsers(res.data.users);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  useEffect(() => {
    if (
      (created_at && created_at.length > 0) ||
      is_refund !== -1 ||
      order_id ||
      (payment && payment.length > 0) ||
      goods_name
    ) {
      setShowStatus(true);
    } else {
      setShowStatus(false);
    }
  }, [created_at, is_refund, order_id, goods_name, status, payment]);

  const resetLocalSearchParams = (params: LocalSearchParamsInterface) => {
    setSearchParams(
      (prev) => {
        if (typeof params.order_id !== "undefined") {
          prev.set("order_id", params.order_id);
        }
        if (typeof params.goods_name !== "undefined") {
          prev.set("goods_name", params.goods_name);
        }
        if (typeof params.is_refund !== "undefined") {
          prev.set("is_refund", params.is_refund + "");
        }
        if (typeof params.status !== "undefined") {
          prev.set("status", params.status);
        }
        if (typeof params.payment !== "undefined") {
          prev.set("payment", JSON.stringify(params.payment));
        }
        if (typeof params.created_at !== "undefined") {
          prev.set("created_at", JSON.stringify(params.created_at));
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

  const resetList = () => {
    resetLocalSearchParams({
      page: 1,
      size: 10,
      order_id: "",
      goods_name: "",
      is_refund: -1,
      payment: [],
      created_at: [],
    });
    setList([]);
    setOrderId("");
    setGoodsName("");
    setIsRefund(-1);
    setPayment([]);
    setCreatedAt([]);
    setCreatedAts([]);
    setRefresh(!refresh);
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
      title: "ID",
      width: 120,
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "学员",
      width: 210,
      render: (_, record: any) => (
        <>
          {users[record.user_id] && (
            <div className="user-item d-flex">
              <div className="avatar">
                <img
                  src={users[record.user_id].avatar}
                  width="40"
                  height="40"
                />
              </div>
              <div className="ml-10">{users[record.user_id].nick_name}</div>
            </div>
          )}
          {!users[record.user_id] && <span className="c-red">学员不存在</span>}
        </>
      ),
    },
    {
      title: "商品名称",
      width: 250,
      render: (_, record: any) => (
        <>
          {record.goods.map((item: any) => (
            <span key={item.goods_id}>{item.goods_name}</span>
          ))}
        </>
      ),
    },
    {
      title: "支付金额",
      width: 150,
      dataIndex: "charge",
      render: (charge: number) => <span>¥{charge}</span>,
    },
    {
      title: "优惠码金额",
      width: 150,
      render: (_, record: any) => <span>{getRecharge(record)}</span>,
    },
    {
      title: "支付渠道",
      width: 100,
      render: (_, record: any) => (
        <>
          {record.payment === "alipay" && (
            <img src={aliIcon} width="30" height="30" />
          )}
          {record.payment === "wechat" && (
            <img src={wepayIcon} width="30" height="30" />
          )}
          {record.payment === "wechat_h5" && (
            <img src={wepayIcon} width="30" height="30" />
          )}
          {record.payment === "wechat-jsapi" && (
            <img src={wepayIcon} width="30" height="30" />
          )}
          {record.payment === "wechatApp" && (
            <img src={wepayIcon} width="30" height="30" />
          )}
          {record.payment === "handPay" && (
            <img src={cardIcon} width="30" height="30" />
          )}
          {record.payment === "" && <span>-</span>}
        </>
      ),
    },
    {
      title: "支付状态",
      width: 100,
      render: (_, record: any) => (
        <>
          {record.status_text === "已支付" && (
            <span className="c-green">· {record.status_text}</span>
          )}
          {record.status_text === "未支付" && (
            <span className="c-red">· {record.status_text}</span>
          )}
          {record.status_text === "支付中" && (
            <span className="c-yellow">· {record.status_text}</span>
          )}
          {record.status_text === "已取消" && (
            <span className="c-gray">· {record.status_text}</span>
          )}
        </>
      ),
    },
    {
      title: "退款",
      render: (_, record: any) => (
        <>
          {record.is_refund === 0 ? (
            <span>-</span>
          ) : record.refund ? (
            <span>{showRefund(record.refund)}</span>
          ) : (
            ""
          )}
        </>
      ),
    },
    {
      title: "订单创建时间",
      width: 200,
      dataIndex: "updated_at",
      render: (updated_at: string) => <span>{dateFormat(updated_at)}</span>,
    },
    {
      title: "操作",
      width: 120,
      render: (_, record: any) => {
        const items: MenuProps["items"] = [
          {
            key: "1",
            label: (
              <PerButton
                type="link"
                text="退款"
                class="c-primary"
                icon={null}
                p="order.refund"
                onClick={() => {
                  refund(record);
                }}
                disabled={record.status !== 9}
              />
            ),
          },
        ];
        return (
          <Space>
            <PerButton
              type="link"
              text="查看"
              class="c-primary"
              icon={null}
              p="order.detail"
              onClick={() => {
                navigate("/order/detail?id=" + record.id);
              }}
              disabled={null}
            />
            <Dropdown menu={{ items }}>
              <Button
                type="link"
                className="c-primary"
                onClick={(e) => e.preventDefault()}
              >
                <Space size="small" align="center">
                  更多
                  <DownOutlined />
                </Space>
              </Button>
            </Dropdown>
          </Space>
        );
      },
    },
  ];

  const getRecharge = (item: any) => {
    let amount = 0;
    for (let i = 0; i < item.paid_records.length; i++) {
      if (item.paid_records[i].paid_type === 1) {
        amount += item.paid_records[i].paid_total;
      }
    }
    return amount > 0 ? "¥" + amount : "-";
  };

  const showRefund = (item: any) => {
    let amount = 0;
    for (let i = 0; i < item.length; i++) {
      if (item[i].status === 1 || item[i].status === 5) {
        amount += item[i].amount / 100;
      }
    }
    return "¥" + amount.toFixed(2);
  };

  const refund = (item: any) => {
    setOrderItem(item);
    setVisiable(true);
  };

  const importexcel = () => {
    if (loading) {
      return;
    }
    let time = [...created_at];
    if (time.length > 0) {
      time[1] += " 23:59:59";
    }
    setLoading(true);
    let params = {
      page: 1,
      size: total,
      order_id: order_id,
      goods_name: goods_name,
      is_refund: is_refund,
      status: status,
      created_at: time,
      payment: payment,
    };
    order.list(params).then((res: any) => {
      if (res.data.orders.total === 0) {
        message.error("数据为空");
        setLoading(false);
        return;
      }
      let status;
      if (Number(status) === 9) {
        status = "已支付";
      } else if (Number(status) === 5) {
        status = "支付中";
      } else if (Number(status) === 1) {
        status = "未支付";
      } else if (Number(status) === 7) {
        status = "已取消";
      } else {
        status = "全部";
      }
      let filename = "全部订单（" + status + "）.xlsx";
      let sheetName = "sheet1";
      let users = res.data.users;
      let data = [
        [
          "ID",
          "学员ID",
          "学员",
          "商品名称",
          "支付金额",
          "优惠码金额",
          "支付渠道",
          "支付状态",
          "退款",
          "订单创建时间",
        ],
      ];
      res.data.orders.data.forEach((item: any) => {
        data.push([
          item.id,
          item.user_id,
          users[item.user_id] ? users[item.user_id].nick_name : "用户已删除",
          item.goods[0] ? item.goods[0].goods_name : "商品已删除",
          "¥" + item.charge,
          getRecharge(item),
          item.payment_text,
          item.status_text,
          item.is_refund === 0 ? "-" : showRefund(item.refund),
          item.updated_at
            ? moment(item.updated_at).format("YYYY-MM-DD HH:mm")
            : "",
        ]);
      });

      const jsonWorkSheet = XLSX.utils.json_to_sheet(data);
      const workBook: XLSX.WorkBook = {
        SheetNames: [sheetName],
        Sheets: {
          [sheetName]: jsonWorkSheet,
        },
      };
      XLSX.writeFile(workBook, filename);
      setLoading(false);
    });
  };

  const onChange = (key: string) => {
    resetLocalSearchParams({
      page: 1,
      status: key,
    });
    setRefresh(!refresh);
  };

  const disabledDate = (current: any) => {
    return current && current >= moment().add(0, "days"); // 选择时间要大于等于当前天。若今天不能被选择，去掉等号即可。
  };

  return (
    <div className="meedu-main-body">
      <RefundDialog
        open={visiable}
        order={orderItem}
        onCancel={() => setVisiable(false)}
        onSuccess={() => {
          setVisiable(false);
          setRefresh(!refresh);
        }}
      ></RefundDialog>
      <div className="float-left j-b-flex mb-30">
        <div className="d-flex">
          <PerButton
            type="primary"
            text="退款订单"
            class=""
            icon={null}
            p="order.refund.list"
            onClick={() => navigate("/order/refund")}
            disabled={null}
          />
          <Button
            className="ml-10"
            type="primary"
            onClick={() => importexcel()}
          >
            导出表格
          </Button>
        </div>
        <div className="d-flex">
          <Input
            value={order_id}
            onChange={(e) => {
              setOrderId(e.target.value);
            }}
            allowClear
            style={{ width: 150 }}
            placeholder="订单编号"
          />
          <Input
            value={goods_name}
            onChange={(e) => {
              setGoodsName(e.target.value);
            }}
            allowClear
            style={{ width: 150, marginLeft: 10 }}
            placeholder="商品全称"
          />
          <Select
            style={{ width: 150, marginLeft: 10 }}
            value={payment}
            onChange={(e) => {
              setPayment(e);
            }}
            allowClear
            placeholder="支付渠道"
            options={payments}
          />
          <Button className="ml-10" onClick={resetList}>
            清空
          </Button>
          <Button
            className="ml-10"
            type="primary"
            onClick={() => {
              resetLocalSearchParams({
                page: 1,
                order_id: order_id,
                goods_name: goods_name,
                payment: typeof payment !== "undefined" ? payment : [],
                is_refund: typeof is_refund !== "undefined" ? is_refund : -1,
                created_at: created_at,
              });
              setRefresh(!refresh);
              setDrawer(false);
            }}
          >
            筛选
          </Button>
          <div
            className="drawerMore d-flex ml-10"
            onClick={() => setDrawer(true)}
          >
            {showStatus && (
              <>
                <img src={filterHIcon} />
                <span className="act">已选</span>
              </>
            )}
            {!showStatus && (
              <>
                <img src={filterIcon} />
                <span>更多</span>
              </>
            )}
          </div>
        </div>
      </div>
      <div className="float-left">
        <Tabs
          defaultActiveKey={status || ""}
          items={types}
          onChange={onChange}
        />
      </div>
      <div className="float-left">
        <Table
          loading={loading}
          columns={columns}
          dataSource={list}
          rowKey={(record) => record.id}
          pagination={paginationProps}
        />
      </div>
      {drawer ? (
        <Drawer
          title="更多筛选"
          onClose={() => setDrawer(false)}
          maskClosable={false}
          open={true}
          footer={
            <Space className="j-b-flex">
              <Button
                onClick={() => {
                  resetList();
                  setDrawer(false);
                }}
              >
                清空
              </Button>
              <Button
                onClick={() => {
                  resetLocalSearchParams({
                    page: 1,
                    order_id: order_id,
                    goods_name: goods_name,
                    payment: typeof payment !== "undefined" ? payment : [],
                    is_refund:
                      typeof is_refund !== "undefined" ? is_refund : -1,
                    created_at: created_at,
                  });
                  setRefresh(!refresh);
                  setDrawer(false);
                }}
                type="primary"
              >
                筛选
              </Button>
            </Space>
          }
          width={360}
        >
          <div className="float-left">
            <Input
              value={order_id}
              onChange={(e) => {
                setOrderId(e.target.value);
              }}
              allowClear
              placeholder="订单编号"
            />
            <Input
              value={goods_name}
              onChange={(e) => {
                setGoodsName(e.target.value);
              }}
              allowClear
              style={{ marginTop: 20 }}
              placeholder="商品全称"
            />
            <Select
              style={{ width: "100%", marginTop: 20 }}
              value={payment}
              onChange={(e) => {
                setPayment(e);
              }}
              allowClear
              placeholder="支付渠道"
              options={payments}
            />
            <Select
              style={{ width: "100%", marginTop: 20 }}
              value={is_refund}
              onChange={(e) => {
                setIsRefund(e);
              }}
              allowClear
              placeholder="退款方式"
              options={refunds}
            />
            <RangePicker
              disabledDate={disabledDate}
              format={"YYYY-MM-DD"}
              value={createdAts}
              style={{ marginTop: 20 }}
              onChange={(date, dateString) => {
                setCreatedAts(date);
                setCreatedAt(dateString);
              }}
              placeholder={["订单添加-开始时间", "订单添加-结束时间"]}
            />
          </div>
        </Drawer>
      ) : null}
    </div>
  );
};

export default OrderPage;
