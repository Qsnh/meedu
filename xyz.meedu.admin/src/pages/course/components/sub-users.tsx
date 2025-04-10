import { useEffect, useState } from "react";
import { Modal, Table, Button, DatePicker, Input, message } from "antd";
import type { ColumnsType } from "antd/es/table";
import { course } from "../../../api/index";
import { dateFormat } from "../../../utils/index";
import { ExclamationCircleFilled } from "@ant-design/icons";
import {
  PerButton,
  UserImportDialog,
  UserAddDialog,
} from "../../../components";
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

export const SubUsers = (props: PropsInterface) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(10);
  const [total, setTotal] = useState(0);
  const [uid, setUid] = useState(0);
  const [showUserAddWin, setShowUserAddWin] = useState<boolean>(false);
  const [importDialog, setImportDialog] = useState<boolean>(false);
  const [refresh, setRefresh] = useState(false);
  const [users, setUsers] = useState<any>({});
  const [user_id, setUserId] = useState<string>("");
  const [watched_at, setWatchedAt] = useState<any>([]);
  const [watchedAts, setWatchedAts] = useState<any>([]);

  useEffect(() => {
    getData();
  }, [props.id, page, size, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    course
      .subUsers(props.id, {
        page: page,
        size: size,
        user_id: user_id,
        subscribe_start_at: watched_at[0],
        subscribe_end_at: watched_at[1],
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

  const delRecords = (uid: number) => {
    if (uid === 0) {
      return;
    }
    confirm({
      title: "警告",
      icon: <ExclamationCircleFilled />,
      content: "确认操作？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        course
          .subUsersDel(props.id, { user_id: uid })
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
    setRefresh(!refresh);
  };

  const resetList = () => {
    setPage(1);
    setSize(10);
    setList([]);
    setUserId("");
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

  const columns: ColumnsType<DataType> = [
    {
      title: "学员ID",
      width: 120,
      render: (_, record: any) => <span>{record.user_id}</span>,
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
      title: "价格",
      width: 200,
      render: (_, record: any) => (
        <>
          {record.charge === 0 && <span>-</span>}
          {record.charge !== 0 && <span>￥{record.charge}</span>}
        </>
      ),
    },
    {
      title: "购买时间",
      width: 200,
      dataIndex: "created_at",
      render: (created_at: string) => <span>{dateFormat(created_at)}</span>,
    },
    {
      title: "操作",
      width: 100,
      fixed: "right",
      render: (_, record: any) => (
        <Button
          type="link"
          className="c-red"
          onClick={() => {
            delRecords(record.user_id);
          }}
        >
          删除
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
      user_id: user_id,
      watched_start_at: watched_at[0],
      watched_end_at: watched_at[1],
    };
    course.subUsers(props.id, params).then((res: any) => {
      if (res.data.data.total === 0) {
        message.error("数据为空");
        setLoading(false);
        return;
      }
      let users = res.data.users;
      let filename = "录播课程购买学员.xlsx";
      let sheetName = "sheet1";

      let data = [["学员ID", "学员", "手机号", "价格", "时间"]];
      res.data.data.data.forEach((item: any) => {
        let user = users[item.user_id];
        data.push([
          item.user_id,
          user.nick_name,
          user.mobile,
          item.charge === 0 ? "-" : "￥" + item.charge,
          item.created_at
            ? moment(item.created_at).format("YYYY-MM-DD HH:mm")
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

  const userAddChange = (rows: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    course
      .subUsersAdd(props.id, {
        user_id: rows,
      })
      .then(() => {
        setLoading(false);
        message.success("成功");
        setShowUserAddWin(false);
        resetData();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <div className="float-left">
      <div className="float-left j-b-flex mb-30">
        <div className="d-flex">
          <Button type="primary" onClick={() => setShowUserAddWin(true)}>
            添加学员
          </Button>
          <PerButton
            type="primary"
            text="批量导入"
            class="ml-10"
            icon={null}
            p="course.subscribe.create"
            onClick={() => setImportDialog(true)}
            disabled={null}
          />
        </div>
        <div className="d-flex">
          <Input
            style={{ width: 150 }}
            value={user_id}
            onChange={(e) => {
              setUserId(e.target.value);
            }}
            allowClear
            placeholder="学员ID"
          />
          <RangePicker
            format={"YYYY-MM-DD"}
            value={watchedAts}
            style={{ marginLeft: 10 }}
            onChange={(date, dateString) => {
              setWatchedAt(dateString);
              setWatchedAts(date);
            }}
            placeholder={["购买时间-开始", "购买时间-结束"]}
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
          loading={loading}
          columns={columns}
          dataSource={list}
          rowKey={(record) => record.id}
          pagination={paginationProps}
        />
      </div>
      <UserImportDialog
        open={importDialog}
        id={props.id}
        type="vod"
        name="学员批量导入模板"
        onCancel={() => setImportDialog(false)}
        onSuccess={() => {
          setImportDialog(false);
          resetData();
        }}
      ></UserImportDialog>
      <UserAddDialog
        type=""
        open={showUserAddWin}
        onCancel={() => setShowUserAddWin(false)}
        onSuccess={(rows: any) => {
          userAddChange(rows);
        }}
      ></UserAddDialog>
    </div>
  );
};
