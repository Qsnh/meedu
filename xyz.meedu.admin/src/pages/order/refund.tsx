import { useState, useEffect } from "react";
import {
  Table,
  Modal,
  Select,
  message,
  Drawer,
  Input,
  Button,
  DatePicker,
  Space,
} from "antd";
import { useSearchParams } from "react-router-dom";
import type { ColumnsType } from "antd/es/table";
import { useDispatch } from "react-redux";
import { order } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import { PerButton, BackBartment } from "../../components";
import { dateFormat } from "../../utils/index";
import { ExclamationCircleFilled } from "@ant-design/icons";
import filterIcon from "../../assets/img/icon-filter.png";
import filterHIcon from "../../assets/img/icon-filter-h.png";
import aliIcon from "../../assets/img/ali-pay.png";
import wepayIcon from "../../assets/img/wepay.png";
import cardIcon from "../../assets/img/card.png";
import moment from "moment";
import * as XLSX from "xlsx";
import dayjs from "dayjs";
const { confirm } = Modal;
const { RangePicker } = DatePicker;

interface DataType {
  id: React.Key;
  refund_no: string;
  created_at: string;
}

interface LocalSearchParamsInterface {
  page?: number;
  size?: number;
  mobile?: string;
  refund_no?: string;
  order_no?: string;
  status?: number;
  is_local?: number;
  payment?: any;
  created_at?: any;
}

const OrderRefundPage = () => {
  const dispatch = useDispatch();
  const [searchParams, setSearchParams] = useSearchParams({
    page: "1",
    size: "10",
    mobile: "",
    refund_no: "",
    order_no: "",
    is_local: "-1",
    status: "0",
    payment: "[]",
    created_at: "[]",
  });
  const page = parseInt(searchParams.get("page") || "1");
  const size = parseInt(searchParams.get("size") || "10");
  const [mobile, setMobile] = useState(searchParams.get("mobile") || "");
  const [refund_no, setRefundNo] = useState(
    searchParams.get("refund_no") || ""
  );
  const [order_no, setOrderNo] = useState(searchParams.get("order_no") || "");
  const [is_local, setIsLocal] = useState(
    Number(searchParams.get("is_local") || -1)
  );
  const [status, setStatus] = useState(Number(searchParams.get("status") || 0));
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
  const types = [
    {
      value: -1,
      label: "退款类型",
    },
    {
      value: 0,
      label: "原渠道退回",
    },
    {
      value: 1,
      label: "线下退款（线上记录）",
    },
  ];
  const statusRows = [
    {
      value: 0,
      label: "退款状态",
    },
    {
      value: 1,
      label: "待处理",
    },
    {
      value: 5,
      label: "退款成功",
    },
    {
      value: 9,
      label: "退款异常",
    },
    {
      value: 13,
      label: "退款已关闭",
    },
  ];

  useEffect(() => {
    document.title = "退款订单";
    dispatch(titleAction("退款订单"));
  }, []);

  useEffect(() => {
    if (
      (created_at && created_at.length > 0) ||
      is_local !== -1 ||
      status !== 0 ||
      order_no ||
      (payment && payment.length > 0) ||
      refund_no ||
      mobile
    ) {
      setShowStatus(true);
    } else {
      setShowStatus(false);
    }
  }, [created_at, is_local, order_no, refund_no, status, payment, mobile]);

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
      .refundList({
        page: page,
        size: size,
        sort: "id",
        order: "desc",
        is_local: is_local,
        mobile: mobile,
        status: status,
        created_at: time,
        payment: payment,
        refund_no: refund_no,
        order_no: order_no,
      })
      .then((res: any) => {
        setList(res.data.data.data);
        setTotal(res.data.data.total);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const resetLocalSearchParams = (params: LocalSearchParamsInterface) => {
    setSearchParams(
      (prev) => {
        if (typeof params.mobile !== "undefined") {
          prev.set("mobile", params.mobile);
        }
        if (typeof params.refund_no !== "undefined") {
          prev.set("refund_no", params.refund_no);
        }
        if (typeof params.order_no !== "undefined") {
          prev.set("order_no", params.order_no);
        }
        if (typeof params.is_local !== "undefined") {
          prev.set("is_local", params.is_local + "");
        }
        if (typeof params.status !== "undefined") {
          prev.set("status", params.status + "");
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
      mobile: "",
      refund_no: "",
      order_no: "",
      status: 0,
      is_local: -1,
      payment: [],
      created_at: [],
    });
    setList([]);
    setMobile("");
    setOrderNo("");
    setRefundNo("");
    setStatus(0);
    setIsLocal(-1);
    setPayment([]);
    setCreatedAt([]);
    setCreatedAts([]);
    setRefresh(!refresh);
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
      is_local: is_local,
      mobile: mobile,
      status: status,
      created_at: time,
      payment: payment,
      refund_no: refund_no,
      order_no: order_no,
    };
    order.refundList(params).then((res: any) => {
      if (res.data.data.total === 0) {
        message.error("数据为空");
        setLoading(false);
        return;
      }
      let filename = "退款订单.xlsx";
      let sheetName = "sheet1";
      let data = [
        [
          "ID",
          "学员ID",
          "学员",
          "退款单号",
          "退款类型",
          "支付渠道",
          "退款金额",
          "状态",
          "到账时间",
          "提交时间",
        ],
      ];
      res.data.data.data.forEach((item: any) => {
        let status;
        if (item.status === 1) {
          status = "待处理";
        } else if (item.status === 5) {
          status = "退款成功";
        } else if (item.status === 9) {
          status = "退款已关闭";
        }
        data.push([
          item.id,
          item.user ? item.user.id : "用户已删除",
          item.user ? item.user.nick_name : "用户已删除",
          item.refund_no,
          item.is_local === 1 ? "线下退款" : "原渠道退回",
          item.payment === "" ? "-" : item.payment,
          "¥" + item.amount / 100,
          status,
          item.status === 5
            ? moment(item.success_at).format("YYYY-MM-DD HH:mm")
            : "",
          item.created_at
            ? moment(item.created_at).format("YYYY-MM-DD HH:mm")
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
      width: 300,
      render: (_, record: any) => (
        <>
          {record.user && record.user.length !== 0 && (
            <div className="user-item d-flex">
              <div className="avatar">
                <img src={record.user.avatar} width="40" height="40" />
              </div>
              <div className="ml-10">{record.user.nick_name}</div>
            </div>
          )}
          {(!record.user || record.user.length === 0) && (
            <span className="c-red">学员不存在</span>
          )}
        </>
      ),
    },
    {
      title: "退款单号",
      width: 300,
      dataIndex: "refund_no",
      render: (refund_no: string) => <span>{refund_no}</span>,
    },
    {
      title: "退款类型",
      width: 120,
      render: (_, record: any) => (
        <>
          {record.is_local === 1 && <span>线下退款</span>}
          {record.is_local !== 1 && <span>原渠道退回</span>}
        </>
      ),
    },
    {
      title: "支付渠道",
      width: 150,
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
      title: "退款金额",
      render: (_, record: any) => <span>¥{record.amount / 100}</span>,
    },
    {
      title: "状态",
      width: 220,
      render: (_, record: any) => (
        <>
          {record.status === 5 && (
            <>
              <span className="c-green mb-10">· 退款成功</span>
              <br />
              <span className="c-gray">{dateFormat(record.success_at)}</span>
            </>
          )}
          {record.status === 13 && <span className="c-red">· 退款已关闭</span>}
          {record.status === 1 && <span className="c-yellow">· 待处理</span>}
          {record.status === 9 && <span>· 退款异常</span>}
        </>
      ),
    },
    {
      title: "时间",
      width: 200,
      dataIndex: "created_at",
      render: (created_at: string) => <span>{dateFormat(created_at)}</span>,
    },
    {
      title: "操作",
      width: 80,
      render: (_, record: any) => (
        <PerButton
          type="link"
          text="删除"
          class="c-red"
          icon={null}
          p="order.refund.delete"
          onClick={() => {
            destory(record.id);
          }}
          disabled={null}
        />
      ),
    },
  ];

  const destory = (id: number) => {
    if (id === 0) {
      return;
    }
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除此订单记录？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        order
          .refundDestroy(id)
          .then(() => {
            setLoading(false);
            message.success("删除成功");
            resetData();
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

  const resetData = () => {
    resetLocalSearchParams({
      page: 1,
    });
    setList([]);
    setRefresh(!refresh);
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="退款订单" />
      <div className="float-left j-b-flex mb-30 mt-30">
        <div className="d-flex">
          <Button type="primary" onClick={() => importexcel()}>
            导出表格
          </Button>
        </div>
        <div className="d-flex">
          <Select
            style={{ width: 150 }}
            value={payment}
            onChange={(e) => {
              setPayment(e);
            }}
            allowClear
            placeholder="支付渠道"
            options={payments}
          />
          <Input
            value={mobile}
            onChange={(e) => {
              setMobile(e.target.value);
            }}
            allowClear
            style={{ width: 150, marginLeft: 10 }}
            placeholder="手机号"
          />
          <Input
            value={refund_no}
            onChange={(e) => {
              setRefundNo(e.target.value);
            }}
            allowClear
            style={{ width: 150, marginLeft: 10 }}
            placeholder="退款单号"
          />
          <Select
            style={{ width: 150, marginLeft: 10 }}
            value={is_local}
            onChange={(e) => {
              setIsLocal(e);
            }}
            allowClear
            placeholder="退款类型"
            options={types}
          />
          <Select
            style={{ width: 150, marginLeft: 10 }}
            value={status}
            onChange={(e) => {
              setStatus(e);
            }}
            allowClear
            placeholder="退款状态"
            options={statusRows}
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
                mobile: mobile,
                refund_no: refund_no,
                order_no: order_no,
                payment: typeof payment !== "undefined" ? payment : [],
                status: typeof status !== "undefined" ? status : 0,
                is_local: typeof is_local !== "undefined" ? is_local : -1,
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
                    mobile: mobile,
                    refund_no: refund_no,
                    order_no: order_no,
                    payment: typeof payment !== "undefined" ? payment : [],
                    status: typeof status !== "undefined" ? status : 0,
                    is_local: typeof is_local !== "undefined" ? is_local : -1,
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
            <Select
              style={{ width: "100%" }}
              value={payment}
              onChange={(e) => {
                setPayment(e);
              }}
              allowClear
              placeholder="支付渠道"
              options={payments}
            />
            <Input
              value={mobile}
              onChange={(e) => {
                setMobile(e.target.value);
              }}
              allowClear
              style={{ marginTop: 20 }}
              placeholder="手机号"
            />
            <Input
              value={refund_no}
              onChange={(e) => {
                setRefundNo(e.target.value);
              }}
              allowClear
              style={{ marginTop: 20 }}
              placeholder="退款单号"
            />
            <Input
              value={order_no}
              onChange={(e) => {
                setOrderNo(e.target.value);
              }}
              allowClear
              style={{ marginTop: 20 }}
              placeholder="订单号"
            />
            <Select
              style={{ width: "100%", marginTop: 20 }}
              value={is_local}
              onChange={(e) => {
                setIsLocal(e);
              }}
              allowClear
              placeholder="退款类型"
              options={types}
            />
            <Select
              style={{ width: "100%", marginTop: 20 }}
              value={status}
              onChange={(e) => {
                setStatus(e);
              }}
              allowClear
              placeholder="退款状态"
              options={statusRows}
            />
            <RangePicker
              format={"YYYY-MM-DD"}
              value={createdAts}
              style={{ marginTop: 20 }}
              onChange={(date, dateString) => {
                setCreatedAts(date);
                setCreatedAt(dateString);
              }}
              placeholder={["开始日期", "结束日期"]}
            />
          </div>
        </Drawer>
      ) : null}
    </div>
  );
};

export default OrderRefundPage;
