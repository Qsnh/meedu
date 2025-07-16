import { useState, useEffect } from "react";
import { Table, Modal, message, Space, Select, Button, Tag, Tabs } from "antd";
import { useNavigate, useSearchParams } from "react-router-dom";
import type { ColumnsType } from "antd/es/table";
import { useDispatch } from "react-redux";
import { agreement } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import { PerButton } from "../../components";
import { ExclamationCircleFilled } from "@ant-design/icons";
import { dateFormat } from "../../utils/index";
const { confirm } = Modal;

interface DataType {
  id: React.Key;
  type: string;
  title: string;
  version: string;
  is_active: boolean;
  effective_at: string;
  created_at: string;
}

const AgreementPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [searchParams, setSearchParams] = useSearchParams();
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);

  const [page, setPage] = useState(1);
  const [size, setSize] = useState(10);
  const [typeFilter, setTypeFilter] = useState<string>(
    searchParams.get("type") || "user_agreement"
  );
  const [activeFilter, setActiveFilter] = useState<number>(-1);

  // 协议类型选项
  const [typeOptions, setTypeOptions] = useState<any>([
    {
      label: "用户协议",
      key: "user_agreement",
    },
    {
      label: "隐私政策",
      key: "privacy_policy",
    },
    {
      label: "会员服务协议",
      key: "vip_service_agreement",
    },
    {
      label: "付费内容购买协议",
      key: "paid_content_purchase_agreement",
    },
  ]);

  useEffect(() => {
    document.title = "协议管理";
    dispatch(titleAction("协议管理"));
    
    // 如果URL中没有type参数，设置默认值
    if (!searchParams.get("type")) {
      const newSearchParams = new URLSearchParams(searchParams);
      newSearchParams.set("type", "user_agreement");
      setSearchParams(newSearchParams);
    }
  }, []);

  // 监听URL参数变化
  useEffect(() => {
    const typeFromUrl = searchParams.get("type");
    if (typeFromUrl && typeFromUrl !== typeFilter) {
      setTypeFilter(typeFromUrl);
      setPage(1); // 切换类型时重置页码
      setRefresh(prev => !prev);
    }
  }, [searchParams]);

  useEffect(() => {
    getData();
  }, [refresh, page, size, typeFilter, activeFilter]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    const params: any = {
      page,
      size,
    };
    if (typeFilter) {
      params.type = typeFilter;
    }
    if (activeFilter !== -1) {
      params.is_active = activeFilter;
    }

    agreement
      .list(params)
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
    setPage(page);
    setSize(pageSize);
  };

  const resetData = () => {
    setPage(1);
    setTypeFilter("user_agreement");
    setActiveFilter(-1);
    setRefresh(prev => !prev);
    // 重置URL参数
    const newSearchParams = new URLSearchParams(searchParams);
    newSearchParams.set("type", "user_agreement");
    setSearchParams(newSearchParams);
  };

  // Tab 切换处理函数
  const onTypeChange = (key: string) => {
    setPage(1);
    setTypeFilter(key);
    setRefresh(prev => !prev);
    // 更新URL参数
    const newSearchParams = new URLSearchParams(searchParams);
    newSearchParams.set("type", key);
    setSearchParams(newSearchParams);
  };

  const destory = (id: number) => {
    if (loading) {
      return;
    }
    setLoading(true);
    agreement
      .destroy(id)
      .then(() => {
        setLoading(false);
        message.success("删除成功");
        resetData();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const confirmDestroy = (id: number) => {
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除此协议？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        destory(id);
      },
      onCancel() {
        console.log("Cancel");
      },
    });
  };

  const getTypeText = (type: string) => {
    const types: any = {
      user_agreement: "用户协议",
      privacy_policy: "隐私政策",
      vip_service_agreement: "会员服务协议",
      paid_content_purchase_agreement: "付费内容购买协议",
    };
    return types[type] || type;
  };

  const columns: ColumnsType<DataType> = [
    {
      title: "ID",
      width: 80,
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "协议类型",
      dataIndex: "type",
      render: (type: string) => <span>{getTypeText(type)}</span>,
    },
    {
      title: "标题",
      dataIndex: "title",
    },
    {
      title: "版本",
      dataIndex: "version",
    },
    {
      title: "状态",
      dataIndex: "is_active",
      render: (is_active: boolean) => (
        <Tag color={is_active ? "green" : "default"}>
          {is_active ? "生效中" : "未生效"}
        </Tag>
      ),
    },
    {
      title: "生效时间",
      dataIndex: "effective_at",
      render: (effective_at: string) => <span>{dateFormat(effective_at)}</span>,
    },
    {
      title: "创建时间",
      dataIndex: "created_at",
      render: (created_at: string) => <span>{dateFormat(created_at)}</span>,
    },
    {
      title: "操作",
      width: 200,
      render: (_, record: any) => (
        <Space>
          <PerButton
            type="link"
            text="编辑"
            class="c-primary"
            icon={null}
            p="agreements"
            onClick={() => {
              navigate(`/agreement/${record.id}/edit`);
            }}
            disabled={null}
          />
          {record.type !== "vip_service_agreement" && record.type !== "paid_content_purchase_agreement" && (
            <PerButton
              type="link"
              text="同意记录"
              class="c-primary"
              icon={null}
              p="agreements"
              onClick={() => {
                navigate(`/agreement/${record.id}/records`);
              }}
              disabled={null}
            />
          )}
          <PerButton
            type="link"
            text="删除"
            class="c-red"
            icon={null}
            p="agreements"
            onClick={() => {
              confirmDestroy(record.id);
            }}
            disabled={record.is_active}
          />
        </Space>
      ),
    },
  ];

  return (
    <div className="meedu-main-body">
      <div className="float-left j-b-flex mb-30">
        <div className="d-flex">
          <PerButton
            type="primary"
            text="新增协议"
            class=""
            icon={null}
            p="agreements"
            onClick={() => navigate("/agreement/create")}
            disabled={null}
          />
        </div>
        <div className="d-flex">
          <Select
            style={{ width: 120 }}
            value={activeFilter}
            onChange={(e) => {
              setActiveFilter(e);
            }}
            placeholder="状态"
          >
            <Select.Option value={-1}>全部</Select.Option>
            <Select.Option value={1}>生效中</Select.Option>
            <Select.Option value={0}>未生效</Select.Option>
          </Select>
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
        <Tabs
          activeKey={typeFilter}
          items={typeOptions}
          onChange={onTypeChange}
        />
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

export default AgreementPage;
