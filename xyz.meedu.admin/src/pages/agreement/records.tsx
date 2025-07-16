import { useState, useEffect, useMemo } from "react";
import { Table, DatePicker, Button, Avatar } from "antd";
import { useParams, useSearchParams } from "react-router-dom";
import type { ColumnsType } from "antd/es/table";
import { useDispatch } from "react-redux";
import { agreement } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import { BackBartment } from "../../components";
import { dateFormat } from "../../utils/index";
import dayjs from "dayjs";

const { RangePicker } = DatePicker;

interface DataType {
  id: React.Key;
  user_id: number;
  agreement_type: string;
  agreement_version: string;
  agreed_at: string;
  ip: string;
  platform: string;
  user: any;
}

const AgreementRecordsPage = () => {
  const dispatch = useDispatch();
  const { id } = useParams();
  const [searchParams, setSearchParams] = useSearchParams();
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [total, setTotal] = useState(0);
  
  // 从URL参数中获取筛选条件，如果没有则使用默认值
  const page = parseInt(searchParams.get('page') || '1');
  const size = parseInt(searchParams.get('size') || '10');
  
  // 使用useMemo缓存dateRange，避免无限重渲染
  const dateRange = useMemo(() => {
    const startDate = searchParams.get('start_date');
    const endDate = searchParams.get('end_date');
    if (startDate && endDate) {
      return [dayjs(startDate), dayjs(endDate)] as [dayjs.Dayjs, dayjs.Dayjs];
    }
    return undefined;
  }, [searchParams.get('start_date'), searchParams.get('end_date')]);

  useEffect(() => {
    document.title = "协议同意记录";
    dispatch(titleAction("协议同意记录"));
  }, []);

  useEffect(() => {
    if (id) {
      getData();
    }
  }, [id, page, size, dateRange]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    const params: any = {
      page,
      size,
    };
    if (dateRange && dateRange.length > 0) {
      params.date_range = [
        dateRange[0].format("YYYY-MM-DD"),
        dateRange[1].format("YYYY-MM-DD"),
      ];
    }

    agreement
      .records(parseInt(id!), params)
      .then((res: any) => {
        setList(res.data.data);
        setTotal(res.data.total);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const handlePageChange = (page: number, pageSize: number) => {
    const newParams = new URLSearchParams(searchParams);
    newParams.set('page', page.toString());
    newParams.set('size', pageSize.toString());
    setSearchParams(newParams);
  };

  const resetData = () => {
    const newParams = new URLSearchParams(searchParams);
    newParams.delete('page');
    newParams.delete('size');
    newParams.delete('start_date');
    newParams.delete('end_date');
    setSearchParams(newParams);
  };

  const handleDateRangeChange = (dates: any) => {
    const newParams = new URLSearchParams(searchParams);
    if (dates && dates.length === 2) {
      newParams.set('start_date', dates[0].format('YYYY-MM-DD'));
      newParams.set('end_date', dates[1].format('YYYY-MM-DD'));
    } else {
      newParams.delete('start_date');
      newParams.delete('end_date');
    }
    newParams.delete('page'); // 重置页码
    setSearchParams(newParams);
  };

  const getTypeText = (type: string) => {
    const types: any = {
      user_agreement: "用户协议",
      privacy_policy: "隐私政策",
      vip_service_agreement: "会员服务协议",
    };
    return types[type] || type;
  };

  const columns: ColumnsType<DataType> = [
    {
      title: "用户",
      width: 300,
      render: (_, record: any) => (
        <div className="user-item d-flex">
          <div className="avatar">
            <Avatar src={record.user.avatar} size={40} />
          </div>
          <div className="ml-10">
            <div className="nickname">{record.user.nick_name}</div>
            <div className="mobile">{record.user.mobile}</div>
          </div>
        </div>
      ),
    },
    {
      title: "协议类型",
      dataIndex: "agreement_type",
      render: (type: string) => <span>{getTypeText(type)}</span>,
    },
    {
      title: "同意时间",
      dataIndex: "agreed_at",
      render: (agreed_at: string) => <span>{dateFormat(agreed_at)}</span>,
    },
    {
      title: "IP地址",
      dataIndex: "ip",
    },
  ];

  return (
    <div className="meedu-main-body">
      <div className="float-left mb-30">
        <BackBartment title="协议同意记录" />
      </div>
      <div className="float-left j-b-flex mb-30">
        <div></div>
        <div className="d-flex">
          <RangePicker
            format="YYYY-MM-DD"
            value={dateRange}
            onChange={handleDateRangeChange}
            placeholder={["开始日期", "结束日期"]}
          />
          <Button
            style={{ marginLeft: 10 }}
            onClick={() => {
              resetData();
            }}
          >
            重置
          </Button>
        </div>
      </div>
      <div className="float-left">
        <Table
          loading={loading}
          columns={columns}
          dataSource={list}
          rowKey={(record) => record.id}
          pagination={{
            current: page,
            pageSize: size,
            total: total,
            onChange: handlePageChange,
            showSizeChanger: true,
            showTotal: (total, range) =>
              `共 ${total} 条数据，显示 ${range[0]} - ${range[1]} 条`,
          }}
        />
      </div>
    </div>
  );
};

export default AgreementRecordsPage;
