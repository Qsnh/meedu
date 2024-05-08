import { useState, useEffect } from "react";
import { Table, Modal, message } from "antd";
import { useLocation } from "react-router-dom";
import type { ColumnsType } from "antd/es/table";
import { useDispatch } from "react-redux";
import { order } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import { PerButton, BackBartment } from "../../components";
import { dateFormat } from "../../utils/index";
import { ExclamationCircleFilled } from "@ant-design/icons";
import aliIcon from "../../assets/img/ali-pay.png";
import wepayIcon from "../../assets/img/wepay.png";
import cardIcon from "../../assets/img/card.png";
const { confirm } = Modal;

interface DataType {
  id: React.Key;
}

const OrderDetailPage = () => {
  const result = new URLSearchParams(useLocation().search);
  const dispatch = useDispatch();
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [user, setUser] = useState<any>({});
  const [refresh, setRefresh] = useState(false);
  const [id, setId] = useState(Number(result.get("id")));

  useEffect(() => {
    document.title = "订单详情";
    dispatch(titleAction("订单详情"));
  }, []);

  useEffect(() => {
    setId(Number(result.get("id")));
  }, [result.get("id")]);

  useEffect(() => {
    getData();
  }, [id, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    order
      .detail(id)
      .then((res: any) => {
        setList(res.data.order);
        setUser(res.data.user);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const setPaid = () => {
    if (id === 0) {
      return;
    }
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
        order
          .setPaid(id)
          .then(() => {
            setLoading(false);
            message.success("成功");
            setRefresh(!refresh);
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

  const cancelPaid=()=>{
    if (id === 0) {
      return;
    }
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
        order
          .canceltPaid(id)
          .then(() => {
            setLoading(false);
            message.success("成功");
            setRefresh(!refresh);
          })
          .catch((e) => {
            setLoading(false);
          });
      },
      onCancel() {
        console.log("Cancel");
      },
    });
  }

  const recordsColumns: ColumnsType<DataType> = [
    {
      title: "ID",
      width: 120,
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "支付渠道",
      width: 300,
      render: (_, record: any) => <span>{record.paid_type_text}</span>,
    },
    {
      title: "支付金额",
      render: (_, record: any) => <span>{record.paid_total}元</span>,
    },
    {
      title: "渠道ID",
      width: 120,
      render: (_, record: any) => <span>{record.paid_type_id}</span>,
    },
  ];

  const goodsColumns: ColumnsType<DataType> = [
    {
      title: "ID",
      width: 120,
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "商品ID",
      width: 120,
      render: (_, record: any) => <span>{record.goods_id}</span>,
    },
    {
      title: "商品",
      render: (_, record: any) => <span>{record.goods_name}</span>,
    },
    {
      title: "价格",
      width: 200,
      render: (_, record: any) => <span>{record.goods_charge}元</span>,
    },
  ];

  const refundColumns: ColumnsType<DataType> = [
    {
      title: "ID",
      width: 120,
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "退款单号",
      width: 300,
      render: (_, record: any) => <span>{record.refund_no}</span>,
    },
    {
      title: "支付渠道",
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
      title: "退款金额",
      width: 150,
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
      title: "提交时间",
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
            setRefresh(!refresh);
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

  return (
    <div className="meedu-main-body">
      <BackBartment title="订单详情" />

      <div className="float-left mt-30 ">
        {user && list.status !== 9 && (
          <PerButton
            type="danger"
            text="改为已支付"
            class=""
            icon={null}
            p="order.finish"
            onClick={() => setPaid()}
            disabled={null}
          />
        )}
        {user && (list.status === 5 || list.status === 1) && (
          <PerButton
            type="primary"
            text="取消订单"
            class="ml-10"
            icon={null}
            p="order.cancel"
            onClick={() => cancelPaid()}
            disabled={null}
          />
        )}
      </div>

      <div className="float-left mt-30">
        <div className="panel-box p-0 mb-30">
          <div className="panel-header">订单基础信息</div>
          <div className="panel-body">
            <div className="float-left">
              <div className="float-left d-flex mb-30">
                <div className="flex-1">UID：{user.id}</div>
                <div className="flex-1">学员：{user.nick_name}</div>
                <div className="flex-1">订单ID：{list.id}</div>
                <div className="flex-1">订单编号：{list.order_id}</div>
                <div className="flex-1">总额：￥{list.charge}</div>
              </div>
              <div className="float-left d-flex">
                <div className="flex-1">状态：{list.status_text}</div>
                <div className="flex-1">支付渠道：{list.payment_text}</div>
                <div className="flex-1">
                  时间：{dateFormat(list.created_at)}
                </div>
                <div className="flex-1"></div>
                <div className="flex-1"></div>
              </div>
            </div>
          </div>
        </div>

        <div className="panel-box p-0 mt-30">
          <div className="panel-header">订单商品</div>
          <div className="panel-body">
            <Table
              loading={loading}
              columns={goodsColumns}
              dataSource={list.goods}
              rowKey={(record) => record.id}
              pagination={false}
            />
          </div>
        </div>

        <div className="panel-box p-0 mt-30">
          <div className="panel-header">支付记录</div>
          <div className="panel-body">
            <Table
              loading={loading}
              columns={recordsColumns}
              dataSource={list.paid_records}
              rowKey={(record) => record.id}
              pagination={false}
            />
          </div>
        </div>

        <div className="panel-box p-0 mt-30">
          <div className="panel-header">退款记录</div>
          <div className="panel-body">
            <Table
              loading={loading}
              columns={refundColumns}
              dataSource={list.refund}
              rowKey={(record) => record.id}
              pagination={false}
            />
          </div>
        </div>
      </div>
    </div>
  );
};

export default OrderDetailPage;
