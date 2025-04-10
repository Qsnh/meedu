import { useState, useEffect } from "react";
import { Table, Radio, Modal, message, Button, Select, DatePicker } from "antd";
import type { ColumnsType } from "antd/es/table";
import { useDispatch } from "react-redux";
import { useSearchParams } from "react-router-dom";
import { comment } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import { PerButton } from "../../components";
import { dateFormat } from "../../utils/index";
import { ExclamationCircleFilled } from "@ant-design/icons";
const { confirm } = Modal;
const { RangePicker } = DatePicker;
import moment from "moment";
import dayjs from "dayjs";

interface DataType {
  id: React.Key;
  created_at: string;
  user_id: number;
}

interface LocalSearchParamsInterface {
  page?: number;
  size?: number;
  created_at?: any;
  type?: string;
  is_check?: number;
}

const CourseCommentsPage = () => {
  const dispatch = useDispatch();
  const [searchParams, setSearchParams] = useSearchParams({
    page: "1",
    size: "10",
    created_at: "[]",
    type: "1",
    is_check: "-1",
  });
  const page = parseInt(searchParams.get("page") || "1");
  const size = parseInt(searchParams.get("size") || "10");
  const [type, setType] = useState(searchParams.get("type") || "1");
  const [is_check, setIsCheck] = useState(
    Number(searchParams.get("is_check") || -1)
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
  const [selectedRowKeys, setSelectedRowKeys] = useState<any>([]);
  const typeList = [
    {
      name: "录播课",
      key: "1",
    },
    {
      name: "录播课时",
      key: "2",
    },
  ];
  const refunds = [
    {
      label: "全部",
      value: -1,
    },
    {
      label: "审核通过",
      value: 1,
    },
    {
      label: "审核中",
      value: 0,
    },
  ];

  useEffect(() => {
    document.title = "课程评论";
    dispatch(titleAction("课程评论"));
  }, []);

  useEffect(() => {
    getData();
  }, [page, size, type, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    let time = [...created_at];
    if (time.length > 0) {
      time[1] += " 23:59:59";
    }
    setLoading(true);
    comment
      .list({
        page: page,
        size: size,
        rt: type,
        created_at: time,
        is_check: is_check === undefined ? -1 : is_check,
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
        if (typeof params.type !== "undefined") {
          prev.set("type", params.type);
        }
        if (typeof params.is_check !== "undefined") {
          prev.set("is_check", params.is_check + "");
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

  const delMulti = () => {
    if (selectedRowKeys.length === 0) {
      message.error("请选择需要操作的数据");
      return;
    }

    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除选中的评论？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        comment
          .commentDestroy({ ids: selectedRowKeys })
          .then(() => {
            setLoading(false);
            message.success("成功");
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

  const resetList = () => {
    resetLocalSearchParams({
      page: 1,
      size: 10,
      created_at: [],
      type: "1",
      is_check: -1,
    });
    setIsCheck(-1);
    setCreatedAt([]);
    setCreatedAts([]);
    setList([]);
    setSelectedRowKeys([]);
    setRefresh(!refresh);
  };

  const resetData = () => {
    resetLocalSearchParams({
      page: 1,
    });
    setList([]);
    setSelectedRowKeys([]);
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
      title: "学员",
      width: 240,
      render: (_, record: any) => (
        <>
          {record.user && (
            <div className="user-item d-flex">
              <div className="avatar">
                <img src={record.user.avatar} width="40" height="40" />
              </div>
              <div className="ml-10">{record.user.nick_name}</div>
            </div>
          )}
          {!record.user && <span className="c-red">学员不存在</span>}
        </>
      ),
    },
    {
      title: "审核值",
      width: 100,
      render: (_, record: any) => (
        <>
          {record.is_check === 1 ? (
            <span className="c-green">通过</span>
          ) : (
            <span className="c-red">等待</span>
          )}
        </>
      ),
    },
    {
      title: "内容",
      render: (_, record: any) => (
        <div dangerouslySetInnerHTML={{ __html: record.content }}></div>
      ),
    },
    {
      title: "IP",
      width: 150,
      dataIndex: "ip",
      render: (ip: string) => <span>{ip || "-"}</span>,
    },
    {
      title: "省份",
      width: 150,
      dataIndex: "ip_province",
      render: (ipProvince: string) => <span>{ipProvince || "-"}</span>,
    },
    {
      title: "时间",
      width: 200,
      dataIndex: "created_at",
      render: (created_at: string) => <span>{dateFormat(created_at)}</span>,
    },
  ];

  const rowSelection = {
    selectedRowKeys: selectedRowKeys,
    onChange: (selectedRowKeys: React.Key[], selectedRows: DataType[]) => {
      setSelectedRowKeys(selectedRowKeys);
    },
  };

  const disabledDate = (current: any) => {
    return current && current >= moment().add(0, "days"); // 选择时间要大于等于当前天。若今天不能被选择，去掉等号即可。
  };

  const applyMulti = () => {
    if (selectedRowKeys.length === 0) {
      message.error("请选择需要操作的数据");
      return;
    }
    if (loading) {
      return;
    }
    setLoading(true);
    comment
      .commentApplyMulti({
        ids: selectedRowKeys,
        check_action: "pass",
      })
      .then(() => {
        setLoading(false);
        message.success("成功");
        resetData();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const rejectMulti = () => {
    if (selectedRowKeys.length === 0) {
      message.error("请选择需要操作的数据");
      return;
    }
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "拒绝的评论将自动删除，是否确认",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        comment
          .commentApplyMulti({
            ids: selectedRowKeys,
            check_action: "reject",
          })
          .then(() => {
            setLoading(false);
            message.success("成功");
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

  return (
    <div className="meedu-main-body">
      <div className="float-left mb-30">
        <Radio.Group
          size="large"
          defaultValue={type}
          buttonStyle="solid"
          onChange={(e) => {
            resetLocalSearchParams({
              page: 1,
              size: 10,
              created_at: created_at,
              is_check: typeof is_check !== "undefined" ? is_check : -1,
              type: e.target.value,
            });
            setType(e.target.value);
            setRefresh(!refresh);
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
      <div className="float-left j-b-flex mb-30 ">
        <div className="d-flex">
          <PerButton
            type="danger"
            text="删除"
            class=""
            icon={null}
            p="comment.delete"
            onClick={() => delMulti()}
            disabled={null}
          />
          <PerButton
            type="primary"
            text="审核通过"
            class="ml-10"
            icon={null}
            p="comment.check"
            onClick={() => applyMulti()}
            disabled={null}
          />
          <PerButton
            type="danger"
            text="审核拒绝"
            class="ml-10"
            icon={null}
            p="comment.check"
            onClick={() => rejectMulti()}
            disabled={null}
          />
        </div>
        <div className="d-flex">
          <Select
            style={{ width: 150, marginLeft: 10 }}
            value={is_check}
            onChange={(e) => {
              setIsCheck(e);
            }}
            allowClear
            placeholder="审核状态"
            options={refunds}
          />
          <RangePicker
            disabledDate={disabledDate}
            format={"YYYY-MM-DD"}
            value={createdAts}
            style={{ marginLeft: 10 }}
            onChange={(date, dateString) => {
              setCreatedAts(date);
              setCreatedAt(dateString);
            }}
            placeholder={["评论时间-开始", "评论时间-结束"]}
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
                created_at: created_at,
                type: type,
                is_check: typeof is_check !== "undefined" ? is_check : -1,
              });
              setRefresh(!refresh);
            }}
          >
            筛选
          </Button>
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
        />
      </div>
    </div>
  );
};

export default CourseCommentsPage;
