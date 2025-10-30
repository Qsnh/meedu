import { useState, useEffect } from "react";
import { Table, Input, Button, Space, message, Select } from "antd";
import { useParams, useNavigate } from "react-router-dom";
import type { ColumnsType } from "antd/es/table";
import { useDispatch } from "react-redux";
import { promocode } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import { BackBartment } from "../../components";
import { dateFormat } from "../../utils/index";
import * as XLSX from "xlsx";
import moment from "moment";

interface DataType {
  id: React.Key;
  order_id: string;
  user_id: number;
  user_nick_name: string;
  user_mobile: string;
  paid_total: number;
  order_charge: number;
  order_status: number;
  order_status_text: string;
  created_at: string;
}

const PromoCodeUsageDetailsPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const { id } = useParams();
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [total, setTotal] = useState(0);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(10);
  const [promoCodeInfo, setPromoCodeInfo] = useState<any>(null);
  const [mobile, setMobile] = useState<string>("");
  const [orderStatus, setOrderStatus] = useState<number | undefined>(undefined);
  const [exporting, setExporting] = useState<boolean>(false);

  useEffect(() => {
    document.title = "优惠码使用明细";
    dispatch(titleAction("优惠码使用明细"));
  }, []);

  useEffect(() => {
    getData();
  }, [page, size, id]);

  const getData = (searchParams?: { mobile?: string; orderStatus?: number | undefined }) => {
    if (loading) {
      return;
    }
    setLoading(true);
    const params: any = {
      page: page,
      size: size,
    };
    // 使用 in 操作符判断对象中是否存在属性，以区分"没传参数"和"传了 undefined"
    const mobileValue = searchParams && 'mobile' in searchParams ? searchParams.mobile : mobile;
    if (mobileValue) {
      params.mobile = mobileValue;
    }
    const orderStatusValue = searchParams && 'orderStatus' in searchParams ? searchParams.orderStatus : orderStatus;
    if (orderStatusValue !== undefined) {
      params.order_status = orderStatusValue;
    }
    promocode
      .usageDetails(Number(id), params)
      .then((res: any) => {
        setList(res.data.data);
        setTotal(res.data.total);
        setPromoCodeInfo(res.data.promo_code);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const paginationProps = {
    current: page,
    pageSize: size,
    total: total,
    onChange: (page: number, pageSize: number) => {
      setPage(page);
      setSize(pageSize);
    },
    showSizeChanger: true,
  };

  const handleSearch = () => {
    setPage(1);
    getData({ mobile, orderStatus });
  };

  const handleReset = () => {
    setMobile("");
    setOrderStatus(undefined);
    setPage(1);
    getData({ mobile: "", orderStatus: undefined });
  };

  const exportExcel = () => {
    if (exporting) {
      return;
    }
    setExporting(true);
    const params: any = {
      page: 1,
      size: total,
    };
    if (mobile) {
      params.mobile = mobile;
    }
    if (orderStatus !== undefined) {
      params.order_status = orderStatus;
    }
    promocode
      .usageDetails(Number(id), params)
      .then((res: any) => {
        if (res.data.total === 0) {
          message.error("数据为空");
          setExporting(false);
          return;
        }
        const filename = `优惠码使用明细-${promoCodeInfo?.code || id}-${moment().format("YYYY-MM-DD")}.xlsx`;
        const sheetName = "使用明细";
        const data = [
          [
            "ID",
            "订单号",
            "用户ID",
            "用户昵称",
            "手机号",
            "优惠金额",
            "订单金额",
            "订单状态",
            "使用时间",
          ],
        ];
        res.data.data.forEach((item: any) => {
          data.push([
            item.id,
            item.order_id || "-",
            item.user_id,
            item.user_nick_name || "-",
            item.user_mobile || "-",
            item.paid_total + "元",
            item.order_charge + "元",
            item.order_status_text || "-",
            item.created_at
              ? moment(item.created_at).format("YYYY-MM-DD HH:mm:ss")
              : "-",
          ]);
        });

        const jsonWorkSheet = XLSX.utils.aoa_to_sheet(data);
        const workBook: XLSX.WorkBook = {
          SheetNames: [sheetName],
          Sheets: {
            [sheetName]: jsonWorkSheet,
          },
        };
        XLSX.writeFile(workBook, filename);
        setExporting(false);
        message.success("导出成功");
      })
      .catch((e) => {
        setExporting(false);
        message.error("导出失败");
      });
  };

  const columns: ColumnsType<DataType> = [
    {
      title: "ID",
      width: 80,
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "订单号",
      width: 200,
      render: (_, record: any) => <span>{record.order_id}</span>,
    },
    {
      title: "用户ID",
      width: 100,
      render: (_, record: any) => <span>{record.user_id}</span>,
    },
    {
      title: "用户昵称",
      width: 150,
      render: (_, record: any) => <span>{record.user_nick_name || "-"}</span>,
    },
    {
      title: "手机号",
      width: 150,
      render: (_, record: any) => <span>{record.user_mobile || "-"}</span>,
    },
    {
      title: "优惠金额",
      width: 120,
      render: (_, record: any) => <span>{record.paid_total}元</span>,
    },
    {
      title: "订单金额",
      width: 120,
      render: (_, record: any) => <span>{record.order_charge}元</span>,
    },
    {
      title: "订单状态",
      width: 120,
      render: (_, record: any) => <span>{record.order_status_text}</span>,
    },
    {
      title: "使用时间",
      width: 200,
      dataIndex: "created_at",
      render: (created_at: string) => <span>{dateFormat(created_at)}</span>,
    },
  ];

  return (
    <div className="meedu-main-body">
      <BackBartment title="优惠码使用明细" />

      <div className="float-left mt-30">
        {promoCodeInfo && (
          <div className="panel-box p-0 mb-30">
            <div className="panel-header">优惠码信息</div>
            <div className="panel-body">
              <div className="float-left">
                <div className="float-left d-flex mb-30">
                  <div className="flex-1">优惠码：{promoCodeInfo.code}</div>
                  <div className="flex-1">
                    面值：{promoCodeInfo.invited_user_reward}元
                  </div>
                  <div className="flex-1">
                    可用次数：
                    {promoCodeInfo.use_times === 0
                      ? "无限制"
                      : `${promoCodeInfo.use_times}次`}
                  </div>
                  <div className="flex-1">
                    已使用：{promoCodeInfo.used_times}次
                  </div>
                  <div className="flex-1">
                    剩余次数：
                    {promoCodeInfo.use_times === 0
                      ? "无限制"
                      : `${promoCodeInfo.use_times - promoCodeInfo.used_times}次`}
                  </div>
                </div>
              </div>
            </div>
          </div>
        )}

        <div className="panel-box p-0">
          <div className="panel-header">使用明细</div>
          <div className="panel-body">
            <div className="float-left j-b-flex mb-15">
              <div></div>
              <div className="d-flex">
                <Space>
                  <Select
                    value={orderStatus}
                    onChange={(value) => setOrderStatus(value)}
                    allowClear
                    style={{ width: 150 }}
                    placeholder="订单状态"
                  >
                    <Select.Option value={1}>未支付</Select.Option>
                    <Select.Option value={5}>支付中</Select.Option>
                    <Select.Option value={9}>已支付</Select.Option>
                    <Select.Option value={7}>已取消</Select.Option>
                  </Select>
                  <Input
                    value={mobile}
                    onChange={(e) => setMobile(e.target.value)}
                    onPressEnter={handleSearch}
                    allowClear
                    style={{ width: 200 }}
                    placeholder="请输入手机号"
                  />
                  <Button type="primary" onClick={handleSearch} loading={loading}>
                    搜索
                  </Button>
                  <Button onClick={handleReset}>重置</Button>
                  <Button
                    type="default"
                    onClick={exportExcel}
                    loading={exporting}
                    disabled={total === 0}
                  >
                    导出表格
                  </Button>
                </Space>
              </div>
            </div>
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

export default PromoCodeUsageDetailsPage;
