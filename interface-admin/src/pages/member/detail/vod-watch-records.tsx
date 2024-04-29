import { useEffect, useState } from "react";
import { Table } from "antd";
import type { ColumnsType } from "antd/es/table";
import { member } from "../../../api/index";
import { ThumbBar, PerButton } from "../../../components";
import { dateFormat } from "../../../utils/index";
import { VideoTableDialog } from "../components/video-table-dialog";

interface PropsInterface {
  id: number;
}

interface DataType {
  id: React.Key;
  created_at: string;
}

export const UserVodWatchRecordsComp = (props: PropsInterface) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(8);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);
  const [updateId, setUpdateId] = useState(0);
  const [tit, setTit] = useState<string>("");
  const [showAddWin, setShowAddWin] = useState<boolean>(false);

  useEffect(() => {
    getData();
  }, [props.id, page, size, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    member
      .userVodWatchRecords({
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
      title: "录播课程",
      render: (_, record: any) => (
        <>
          {record.course.id && (
            <ThumbBar
              value={record.course.thumb}
              width={120}
              height={90}
              title={record.course.title}
              border={4}
            ></ThumbBar>
          )}
          {!record.course.id && <span className="c-red">课程不存在</span>}
        </>
      ),
    },
    {
      title: "课程学习进度",
      width: 200,
      render: (_, record: any) => <span>{record.progress}%</span>,
    },
    {
      title: "开始学习时间",
      width: 200,
      dataIndex: "created_at",
      render: (created_at: string) => <span>{dateFormat(created_at)}</span>,
    },
    {
      title: "最近一次学习",
      width: 200,
      render: (_, record: any) => (
        <>
          {record.last_view_video &&
          record.last_view_video.length !== 0 &&
          record.last_view_video.updated_at ? (
            <span>{dateFormat(record.last_view_video.updated_at)}</span>
          ) : (
            <span>-</span>
          )}
        </>
      ),
    },
    {
      title: "课时学习进度",
      width: 200,
      render: (_, record: any) => (
        <PerButton
          type="link"
          text="学习进度"
          class="c-primary"
          icon={null}
          p="v2.member.course.progress"
          onClick={() => {
            showVideoDialog(record);
          }}
          disabled={null}
        />
      ),
    },
  ];

  const showVideoDialog = (item: any) => {
    setTit(item.course.title);
    setUpdateId(item.course_id);
    setShowAddWin(true);
  };

  return (
    <div className="float-left">
      <Table
        loading={loading}
        columns={columns}
        dataSource={list}
        rowKey={(record) => record.id}
        pagination={paginationProps}
      />
      <VideoTableDialog
        open={showAddWin}
        text={tit}
        id={updateId}
        userId={props.id}
        onCancel={() => setShowAddWin(false)}
      ></VideoTableDialog>
    </div>
  );
};
