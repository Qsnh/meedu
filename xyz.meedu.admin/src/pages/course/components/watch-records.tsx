import { useEffect, useState } from "react";
import { Modal, Table, Button, DatePicker, Select, message } from "antd";
import type { ColumnsType } from "antd/es/table";
import { course } from "../../../api/index";
import { dateFormat } from "../../../utils/index";
import { ExclamationCircleFilled } from "@ant-design/icons";
import { WatchRecordsDetailDialog } from "./watch-records-detail";
const { confirm } = Modal;
const { RangePicker } = DatePicker;
import moment from "moment";
import * as XLSX from "xlsx";

interface DataType {
  id: React.Key;
  created_at: string;
  user_id: number;
  watched_at: string;
}

interface PropsInterface {
  id: number;
}

export const WatchRecords = (props: PropsInterface) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(10);
  const [total, setTotal] = useState(0);
  const [uid, setUid] = useState(0);
  const [visible, setVisible] = useState<boolean>(false);
  const [refresh, setRefresh] = useState(false);
  const [users, setUsers] = useState<any>({});
  const [is_watched, setIsWatched] = useState<any>([]);
  const [watched_at, setWatchedAt] = useState<any>([]);
  const [watchedAts, setWatchedAts] = useState<any>([]);
  const [selectedRowKeys, setSelectedRowKeys] = useState<any>([]);
  const statusMapRows = [
    {
      label: "未看完",
      value: 0,
    },
    {
      label: "已看完",
      value: 1,
    },
  ];

  useEffect(() => {
    getData();
  }, [props.id, page, size, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    course
      .recordsList(props.id, {
        page: page,
        size: size,
        sort: "id",
        order: "desc",
        user_id: null,
        is_watched: is_watched.length === 0 ? -1 : is_watched,
        watched_start_at: watched_at[0],
        watched_end_at: watched_at[1],
      })
      .then((res: any) => {
        setList(res.data.data.data);
        setTotal(res.data.data.total);
        setUsers(res.data.users);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const delRecords = () => {
    if (selectedRowKeys.length === 0) {
      message.error("请选择需要操作的数据");
      return;
    }
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除选中的学员学习记录？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        course
          .recordsDestroy(props.id, { record_ids: selectedRowKeys })
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

  const resetData = () => {
    setPage(1);
    setList([]);
    setSelectedRowKeys([]);
    setRefresh(!refresh);
  };

  const resetList = () => {
    setPage(1);
    setSize(10);
    setList([]);
    setSelectedRowKeys([]);
    setIsWatched([]);
    setWatchedAts([]);
    setWatchedAt([]);
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
    setPage(page);
    setSize(pageSize);
  };

  const rowSelection = {
    selectedRowKeys: selectedRowKeys,
    onChange: (selectedRowKeys: React.Key[], selectedRows: DataType[]) => {
      setSelectedRowKeys(selectedRowKeys);
    },
  };

  const columns: ColumnsType<DataType> = [
    {
      title: "ID",
      width: 120,
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "学员",
      render: (_, record: any) => (
        <>
          {users[record.user_id] && (
            <div className="user-item d-flex">
              <div className="avatar">
                <img
                  src={users[record.user_id].avatar}
                  width="40"
                  height="40"
                />
              </div>
              <div className="ml-10">{users[record.user_id].nick_name}</div>
            </div>
          )}
          {!users[record.user_id] && <span className="c-red">学员不存在</span>}
        </>
      ),
    },
    {
      title: "观看进度",
      width: 150,
      render: (_, record: any) => <span>{record.progress}%</span>,
    },
    {
      title: "开始时间",
      width: 200,
      dataIndex: "created_at",
      render: (created_at: string) => <span>{dateFormat(created_at)}</span>,
    },
    {
      title: "看完时间",
      width: 200,
      dataIndex: "watched_at",
      render: (watched_at: string) => <span>{dateFormat(watched_at)}</span>,
    },
    {
      title: "看完",
      width: 80,
      render: (_, record: any) => (
        <>
          {record.is_watched === 1 && <span className="c-red">是</span>}
          {record.is_watched !== 1 && <span>否</span>}
        </>
      ),
    },
    {
      title: "操作",
      width: 100,
      fixed: "right",
      render: (_, record: any) => (
        <Button
          type="link"
          className="c-primary"
          onClick={() => {
            showDetailDialog(record);
          }}
        >
          详情
        </Button>
      ),
    },
  ];

  const importexcel = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    let params = {
      page: 1,
      size: total,
      sort: "id",
      order: "desc",
      user_id: null,
      is_watched: is_watched.length === 0 ? -1 : is_watched,
      watched_start_at: watched_at[0],
      watched_end_at: watched_at[1],
    };
    course.recordsList(props.id, params).then((res: any) => {
      if (res.data.data.total === 0) {
        message.error("数据为空");
        setLoading(false);
        return;
      }
      let users = res.data.users;
      let filename =
        "课程学习记录|" + moment().format("YYYY-MM-DD HH:mm:ss") + ".xlsx";
      let sheetName = "sheet1";

      let data = [
        ["用户ID", "用户", "手机号", "观看进度", "开始时间", "看完时间"],
      ];
      res.data.data.data.forEach((item: any) => {
        let user = users[item.user_id];
        if (typeof user === "undefined") {
          return;
        }

        data.push([
          item.user_id,
          user.nick_name,
          user.mobile,
          item.progress + "%",
          item.created_at
            ? moment(item.created_at).format("YYYY-MM-DD HH:mm")
            : "",
          item.watched_at
            ? moment(item.watched_at).format("YYYY-MM-DD HH:mm")
            : "",
        ]);
      });

      const jsonWorkSheet = XLSX.utils.json_to_sheet(data);
      const workBook: XLSX.WorkBook = {
        SheetNames: [sheetName],
        Sheets: {
          [sheetName]: jsonWorkSheet,
        },
      };
      XLSX.writeFile(workBook, filename);
      setLoading(false);
    });
  };

  const showDetailDialog = (item: any) => {
    setUid(item.user_id);
    setVisible(true);
  };

  return (
    <div className="float-left">
      <div className="float-left j-b-flex mb-30">
        <div className="d-flex">
          <Button type="primary" danger onClick={() => delRecords()}>
            删除
          </Button>
        </div>
        <div className="d-flex">
          <Select
            style={{ width: 150 }}
            value={is_watched}
            onChange={(e) => {
              setIsWatched(e);
            }}
            allowClear
            placeholder="看完"
            options={statusMapRows}
          />
          <RangePicker
            format={"YYYY-MM-DD"}
            value={watchedAts}
            style={{ marginLeft: 10 }}
            onChange={(date, dateString) => {
              setWatchedAt(dateString);
              setWatchedAts(date);
            }}
            placeholder={["看完时间-开始", "看完时间-结束"]}
          />
          <Button className="ml-10" onClick={resetList}>
            清空
          </Button>
          <Button
            className="ml-10"
            type="primary"
            onClick={() => {
              setPage(1);
              setRefresh(!refresh);
            }}
          >
            筛选
          </Button>
          <Button
            type="primary"
            className="ml-10"
            onClick={() => importexcel()}
          >
            导出表格
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
      <WatchRecordsDetailDialog
        open={visible}
        cid={props.id}
        uid={uid}
        onCancel={() => setVisible(false)}
      ></WatchRecordsDetailDialog>
    </div>
  );
};
