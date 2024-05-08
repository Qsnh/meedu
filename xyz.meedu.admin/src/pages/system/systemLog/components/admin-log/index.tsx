import { useState, useEffect } from "react";
import { Table } from "antd";
import { useSearchParams } from "react-router-dom";
import type { ColumnsType } from "antd/es/table";
import { system } from "../../../../../api/index";
import { dateWholeFormat } from "../../../../../utils/index";

interface DataType {
  id: React.Key;
  admin_id: number;
  ip: string;
  opt: string;
  module: string;
  created_at: string;
}

interface LocalSearchParamsInterface {
  page?: number;
  size?: number;
}

export const AdminLogComp = () => {
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
    getData();
  }, [page, size, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .adminLog({ page: page, size: size })
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

  const resetData = () => {
    resetLocalSearchParams({
      page: 1,
    });
    setList([]);
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
      title: "管理员ID",
      width: 100,
      render: (_, record: any) => <span>{record.admin_id}</span>,
    },
    {
      title: "操作模块",
      width: 100,
      dataIndex: "module",
      render: (module: string) => <span>{module}</span>,
    },
    {
      title: "操作指令",
      width: 100,
      dataIndex: "opt",
      render: (opt: string) => <span>{opt}</span>,
    },
    {
      title: "IP",
      width: 200,
      dataIndex: "ip",
      render: (ip: string) => <span>{ip}</span>,
    },
    {
      title: "时间",
      width: 200,
      dataIndex: "created_at",
      render: (created_at: string) => (
        <span>{dateWholeFormat(created_at)}</span>
      ),
    },
    {
      title: "备注",
      dataIndex: "version",
      ellipsis: true,
      render: (_, record: any) => <code>{record.remark}</code>,
    },
  ];
  return (
    <>
      <Table
        loading={loading}
        columns={columns}
        dataSource={list}
        rowKey={(record) => record.id}
        pagination={paginationProps}
      />
    </>
  );
};
