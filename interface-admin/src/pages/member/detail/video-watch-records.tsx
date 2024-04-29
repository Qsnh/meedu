import { useEffect, useState } from "react";
import { Table } from "antd";
import type { ColumnsType } from "antd/es/table";
import { member } from "../../../api/index";
import { DurationText } from "../../../components";
import { dateFormat } from "../../../utils/index";

interface PropsInterface {
  id: number;
}

interface DataType {
  id: React.Key;
  created_at: string;
}

export const UserVideoWatchRecordsComp = (props: PropsInterface) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(8);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);

  useEffect(() => {
    getData();
  }, [props.id, page, size, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    member
      .userVideos({
        page: page,
        size: size,
        user_id: props.id,
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

  const paginationProps = {
    current: page, //当前页码
    pageSize: size,
    total: total, // 总条数
    onChange: (page: number, pageSize: number) =>
      handlePageChange(page, pageSize), //改变页码的函数
    showSizeChanger: true,
  };

  const handlePageChange = (page: number, pageSize: number) => {
    setPage(page);
    setSize(pageSize);
  };

  const columns: ColumnsType<DataType> = [
    {
      title: "课时名称",
      render: (_, record: any) => <span>{record.video.title}</span>,
    },
    {
      title: "课时时长",
      width: 200,
      render: (_, record: any) => (
        <DurationText duration={record.duration}></DurationText>
      ),
    },
    {
      title: "已学时长",
      width: 200,
      render: (_, record: any) => (
        <>
          {typeof record.watch_record["watch_seconds"] !== "undefined" ? (
            <DurationText
              duration={record.watch_record.watch_seconds}
            ></DurationText>
          ) : (
            <span>-</span>
          )}
        </>
      ),
    },
    {
      title: "是否学完",
      width: 200,
      render: (_, record: any) => (
        <>
          {typeof record.watch_record["watched_at"] !== "undefined" &&
          record.watch_record.watched_at ? (
            <span className="c-green">已学完</span>
          ) : (
            <span>未学完</span>
          )}
        </>
      ),
    },
    {
      title: "开始学习时间",
      width: 200,
      render: (_, record: any) => (
        <>
          {typeof record.watch_record["created_at"] !== "undefined" &&
          record.watch_record.created_at ? (
            <span>{dateFormat(record.watch_record.created_at)}</span>
          ) : (
            <span>-</span>
          )}
        </>
      ),
    },
    {
      title: "最近一次学习",
      width: 200,
      render: (_, record: any) => (
        <>
          {typeof record.watch_record["updated_at"] !== "undefined" &&
          record.watch_record.updated_at ? (
            <span>{dateFormat(record.watch_record.updated_at)}</span>
          ) : (
            <span>-</span>
          )}
        </>
      ),
    },
  ];

  return (
    <div className="float-left">
      <Table
        loading={loading}
        columns={columns}
        dataSource={list}
        rowKey={(record) => record.id}
        pagination={paginationProps}
      />
    </div>
  );
};
