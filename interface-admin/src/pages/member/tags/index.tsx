import { useState, useEffect } from "react";
import { Table, Modal, message, Button, Space } from "antd";
import { useNavigate, useSearchParams } from "react-router-dom";
import type { ColumnsType } from "antd/es/table";
import { useDispatch } from "react-redux";
import { member } from "../../../api/index";
import { titleAction } from "../../../store/user/loginUserSlice";
import { BackBartment } from "../../../components";
import { ExclamationCircleFilled } from "@ant-design/icons";
const { confirm } = Modal;

interface DataType {
  id: React.Key;
  name: string;
}

interface LocalSearchParamsInterface {
  page?: number;
  size?: number;
}

const MemberTagsPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [searchParams, setSearchParams] = useSearchParams({
    page: "1",
    size: "10",
  });
  const page = parseInt(searchParams.get("page") || "1");
  const size = parseInt(searchParams.get("size") || "10");

  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);

  useEffect(() => {
    document.title = "标签管理";
    dispatch(titleAction("标签管理"));
  }, []);

  useEffect(() => {
    getData();
  }, [page, size, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    member
      .tagList({
        page: page,
        size: size,
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
      title: "标签名",
      dataIndex: "name",
      render: (name: string) => <span>{name}</span>,
    },
    {
      title: "操作",
      width: 130,
      render: (_, record: any) => (
        <Space>
          <Button
            type="link"
            className="c-primary"
            onClick={() => {
              navigate("/member/tag/update?id=" + record.id);
            }}
          >
            编辑
          </Button>

          <Button
            type="link"
            className="c-red"
            onClick={() => {
              destroy(record.id);
            }}
          >
            编辑
          </Button>
        </Space>
      ),
    },
  ];

  const resetData = () => {
    resetLocalSearchParams({
      page: 1,
    });
    setList([]);
    setRefresh(!refresh);
  };

  const destroy = (id: number) => {
    if (id === 0) {
      return;
    }
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除此标签？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        member
          .tagDestroy(id)
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

  return (
    <div className="meedu-main-body">
      <BackBartment title="标签管理" />
      <div className="float-left  mt-30 mb-30">
        <Button type="primary" onClick={() => navigate("/member/tag/create")}>
          添加标签
        </Button>
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
    </div>
  );
};

export default MemberTagsPage;
