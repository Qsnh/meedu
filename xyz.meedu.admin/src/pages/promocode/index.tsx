import { useState, useEffect } from "react";
import {
  Table,
  Modal,
  message,
  Drawer,
  Input,
  Button,
  Tag,
  DatePicker,
  Space,
  Select,
} from "antd";
import { useNavigate, useSearchParams } from "react-router-dom";
import type { ColumnsType } from "antd/es/table";
import { useDispatch } from "react-redux";
import { promocode } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import { PerButton } from "../../components";
import { dateFormat } from "../../utils/index";
import { ExclamationCircleFilled } from "@ant-design/icons";
import { PromocodeCreateDialog } from "./components/create";
import { PromocodeCreateMultiDialog } from "./components/create-multi";
const { confirm } = Modal;
const { RangePicker } = DatePicker;

interface DataType {
  id: React.Key;
  used_times: number;
  expired_at: string;
  created_at: string;
}

interface LocalSearchParamsInterface {
  page?: number;
  size?: number;
  keywords?: string;
  status?: string;
}

const PromoCodePage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [searchParams, setSearchParams] = useSearchParams({
    page: "1",
    size: "10",
    keywords: "",
    status: "",
  });
  const page = parseInt(searchParams.get("page") || "1");
  const size = parseInt(searchParams.get("size") || "10");
  const [keywords, setKeywords] = useState(searchParams.get("keywords") || "");
  const [status, setStatus] = useState(searchParams.get("status") || "");

  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);
  const [user_id, setUserId] = useState("");
  const [created_at, setCreatedAt] = useState<any>([]);
  const [expired_at, setExpiredAt] = useState<any>([]);
  const [createdAts, setCreatedAts] = useState<any>([]);
  const [expiredAts, setExpiredAts] = useState<any>([]);
  const [selectedRowKeys, setSelectedRowKeys] = useState<any>([]);
  const [drawer, setDrawer] = useState(false);
  const [, setShowStatus] = useState(false);
  const [showAddWin, setShowAddWin] = useState<boolean>(false);
  const [showAddMultiWin, setShowAddMultiWin] = useState<boolean>(false);

  useEffect(() => {
    document.title = "优惠码";
    dispatch(titleAction("优惠码"));
  }, []);

  useEffect(() => {
    getData();
  }, [page, size, refresh]);

  useEffect(() => {
    if (
      (created_at && created_at.length > 0) ||
      (expired_at && expired_at.length > 0) ||
      user_id ||
      keywords ||
      status
    ) {
      setShowStatus(true);
    } else {
      setShowStatus(false);
    }
  }, [created_at, expired_at, user_id, keywords, status]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    promocode
      .list({
        page: page,
        size: size,
        user_id: user_id,
        key: keywords,
        created_at: created_at,
        expired_at: expired_at,
        status: status,
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

  const resetLocalSearchParams = (params: LocalSearchParamsInterface) => {
    setSearchParams(
      (prev) => {
        if (typeof params.keywords !== "undefined") {
          prev.set("keywords", params.keywords);
        }
        if (typeof params.page !== "undefined") {
          prev.set("page", params.page + "");
        }
        if (typeof params.size !== "undefined") {
          prev.set("size", params.size + "");
        }
        if (typeof params.status !== "undefined") {
          prev.set("status", params.status);
        }
        return prev;
      },
      { replace: true }
    );
  };

  const destorymulti = () => {
    if (selectedRowKeys.length === 0) {
      message.error("请选择需要操作的数据");
      return;
    }
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除选中的优惠码？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        promocode
          .destroyMulti({
            ids: selectedRowKeys,
          })
          .then((res: any) => {
            // 显示后端返回的详细信息
            const msg = res.message || "成功";
            message.success(msg);
            resetList();
            setLoading(false);
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

  const resetList = () => {
    resetLocalSearchParams({
      page: 1,
      size: 10,
      keywords: "",
      status: "",
    });
    setList([]);
    setSelectedRowKeys([]);
    setKeywords("");
    setStatus("");
    setUserId("");
    setCreatedAts([]);
    setExpiredAt([]);
    setExpiredAts([]);
    setCreatedAt([]);
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

  // 判断优惠码是否已过期
  const isExpired = (record: any) => {
    return new Date(record.expired_at) < new Date();
  };

  // 判断优惠码是否已用完
  const isUsedUp = (record: any) => {
    return record.use_times !== 0 && record.used_times >= record.use_times;
  };

  // 根据优惠码状态返回表格行的 CSS 类名
  const getRowClassName = (record: any) => {
    const expired = isExpired(record);
    const usedUp = isUsedUp(record);

    if (usedUp && expired) {
      return 'promocode-row-used-up-and-expired';
    } else if (usedUp) {
      return 'promocode-row-used-up';
    } else if (expired) {
      return 'promocode-row-expired';
    }
    return '';
  };

  const columns: ColumnsType<DataType> = [
    {
      title: "ID",
      width: 120,
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "优惠码",
      render: (_, record: any) => <span>{record.code}</span>,
    },
    {
      title: "面值",
      width: 120,
      render: (_, record: any) => <span>{record.invited_user_reward}元</span>,
    },
    {
      title: "可用次数",
      width: 120,
      render: (_, record: any) => (
        <>
          {record.use_times === 0 && "-"}
          {record.use_times !== 0 && record.use_times + "次"}
        </>
      ),
    },
    {
      title: "剩余次数",
      width: 120,
      dataIndex: "used_times",
      render: (_, record: any) => (
        <>
          {record.use_times === 0 && <span>-</span>}
          {record.use_times !== 0 && <span>{record.use_times - record.used_times}次</span>}
        </>
      ),
    },
    {
      title: "过期时间",
      width: 200,
      dataIndex: "expired_at",
      render: (expired_at: string) => <span>{dateFormat(expired_at)}</span>,
    },
    {
      title: "添加时间",
      width: 200,
      dataIndex: "created_at",
      render: (created_at: string) => <span>{dateFormat(created_at)}</span>,
    },
    {
      title: "操作",
      width: 120,
      fixed: "right",
      render: (_, record: any) => (
        <PerButton
          type="link"
          text="使用明细"
          class="c-primary"
          icon={null}
          p="promoCode.detail"
          onClick={() => navigate(`/promocode/usage-details/${record.id}`)}
          disabled={null}
        />
      ),
    },
  ];

  const rowSelection = {
    selectedRowKeys: selectedRowKeys,
    onChange: (selectedRowKeys: React.Key[], selectedRows: DataType[]) => {
      setSelectedRowKeys(selectedRowKeys);
    },
    getCheckboxProps: (record: any) => ({
      disabled: record.used_times > 0, // 已使用的优惠码禁止勾选
    }),
  };

  return (
    <div className="meedu-main-body">
      <PromocodeCreateDialog
        open={showAddWin}
        onCancel={() => setShowAddWin(false)}
        onSuccess={() => {
          resetList();
          setShowAddWin(false);
        }}
      />
      <PromocodeCreateMultiDialog
        open={showAddMultiWin}
        onCancel={() => setShowAddMultiWin(false)}
        onSuccess={() => {
          resetList();
          setShowAddMultiWin(false);
        }}
      />
      <div className="float-left j-b-flex mb-30">
        <div className="d-flex">
          <PerButton
            type="primary"
            text="新建优惠码"
            class=""
            icon={null}
            p="promoCode.store"
            onClick={() => setShowAddWin(true)}
            disabled={null}
          />
          <PerButton
            type="primary"
            text="批量生成"
            class="ml-10"
            icon={null}
            p="promoCode.generator"
            onClick={() => setShowAddMultiWin(true)}
            disabled={null}
          />
          <PerButton
            type="primary"
            text="批量导入"
            class="ml-10"
            icon={null}
            p="promoCode.store"
            onClick={() => navigate("/promocode/import")}
            disabled={null}
          />
          <PerButton
            type="danger"
            text="批量删除"
            class="ml-10"
            icon={null}
            p="promoCode.destroy.multi"
            onClick={() => destorymulti()}
            disabled={null}
          />
        </div>
        <div className="d-flex">
          <Select
            value={status}
            onChange={(value) => {
              setStatus(value);
            }}
            allowClear
            style={{ width: 150 }}
            placeholder="优惠码状态"
            options={[
              { label: "全部", value: "" },
              { label: "生效中", value: "active" },
              { label: "已用完", value: "used_up" },
              { label: "已过期", value: "expired" },
              { label: "已用完+已过期", value: "used_up_and_expired" },
            ]}
          />
          <Input
            value={keywords}
            onChange={(e) => {
              setKeywords(e.target.value);
            }}
            allowClear
            style={{ width: 150 }}
            placeholder="请输入优惠码"
            className="ml-10"
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
                keywords: keywords,
                status: status,
              });
              setRefresh(!refresh);
              setDrawer(false);
            }}
          >
            筛选
          </Button>
          {/* <div
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
          </div> */}
        </div>
      </div>
      <div className="float-left">
        <Table
          rowSelection={{
            type: "checkbox",
            ...rowSelection,
          }}
          loading={loading}
          columns={columns}
          dataSource={list}
          rowKey={(record) => record.id}
          pagination={paginationProps}
          rowClassName={(record) => getRowClassName(record)}
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
                    keywords: keywords,
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
              value={keywords}
              onChange={(e) => {
                setKeywords(e.target.value);
              }}
              allowClear
              placeholder="优惠码"
            />
            <Input
              value={user_id}
              onChange={(e) => {
                setUserId(e.target.value);
              }}
              allowClear
              style={{ marginTop: 20 }}
              placeholder="学员ID"
            />
            <RangePicker
              format={"YYYY-MM-DD"}
              value={expiredAts}
              style={{ marginTop: 20 }}
              onChange={(date, dateString) => {
                setExpiredAt(dateString);
                setExpiredAts(date);
              }}
              placeholder={["过期时间-开始", "过期时间-结束"]}
            />
            <RangePicker
              format={"YYYY-MM-DD"}
              value={createdAts}
              style={{ marginTop: 20 }}
              onChange={(date, dateString) => {
                setCreatedAt(dateString);
                setCreatedAts(date);
              }}
              placeholder={["添加时间-开始", "添加时间-结束"]}
            />
          </div>
        </Drawer>
      ) : null}
    </div>
  );
};
export default PromoCodePage;
