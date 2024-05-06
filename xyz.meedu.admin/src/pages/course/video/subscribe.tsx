import { useEffect, useState } from "react";
import { Table, Modal, DatePicker, Button, Input, message } from "antd";
import type { ColumnsType } from "antd/es/table";
import { useLocation, useSearchParams } from "react-router-dom";
import { useDispatch } from "react-redux";
import { course } from "../../../api/index";
import { titleAction } from "../../../store/user/loginUserSlice";
import { PerButton, BackBartment } from "../../../components";
import { ExclamationCircleFilled } from "@ant-design/icons";
import { dateFormat } from "../../../utils/index";
const { confirm } = Modal;
const { RangePicker } = DatePicker;
import moment from "moment";
import dayjs from "dayjs";
import * as XLSX from "xlsx";

interface DataType {
  id: React.Key;
  created_at: string;
}

interface LocalSearchParamsInterface {
  page?: number;
  size?: number;
  user_id?: string;
  watched_at?: any;
}

const CourseVideoSubscribePage = () => {
  const dispatch = useDispatch();
  const result = new URLSearchParams(useLocation().search);
  const [searchParams, setSearchParams] = useSearchParams({
    page: "1",
    size: "10",
    watched_at: "[]",
    user_id: "",
  });
  const page = parseInt(searchParams.get("page") || "1");
  const size = parseInt(searchParams.get("size") || "10");
  const [user_id, setUserId] = useState(searchParams.get("user_id") || "");
  const [watched_at, setWatchedAt] = useState<any>(
    JSON.parse(searchParams.get("watched_at") || "[]")
  );
  const [watchedAts, setWatchedAts] = useState<any>(
    watched_at.length > 0
      ? [dayjs(watched_at[0], "YYYY-MM-DD"), dayjs(watched_at[1], "YYYY-MM-DD")]
      : []
  );

  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);

  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);
  const [users, setUsers] = useState<any>({});
  const [cid, setCid] = useState(Number(result.get("course_id")));
  const [id, setId] = useState(Number(result.get("video_id")));

  useEffect(() => {
    document.title = "课时销售记录";
    dispatch(titleAction("课时销售记录"));
  }, []);

  useEffect(() => {
    setCid(Number(result.get("course_id")));
    setId(Number(result.get("video_id")));
  }, [result.get("video_id"), result.get("course_id")]);

  useEffect(() => {
    getData();
  }, [cid, id, page, size, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    let time = [...watched_at];
    if (time.length > 0) {
      time[1] += " 23:59:59";
    }
    setLoading(true);
    course
      .videoSubscribe(id, {
        page: page,
        size: size,
        video_id: id,
        user_id: user_id,
        subscribe_start_at: time[0],
        subscribe_end_at: time[1],
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

  const resetLocalSearchParams = (params: LocalSearchParamsInterface) => {
    setSearchParams(
      (prev) => {
        if (typeof params.watched_at !== "undefined") {
          prev.set("watched_at", JSON.stringify(params.watched_at));
        }
        if (typeof params.user_id !== "undefined") {
          prev.set("user_id", params.user_id);
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

  const resetList = () => {
    resetLocalSearchParams({
      page: 1,
      size: 10,
      watched_at: [],
      user_id: "",
    });
    setList([]);
    setUserId("");
    setWatchedAt([]);
    setWatchedAts([]);
    setRefresh(!refresh);
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
      render: (_, record: any) => <span>{record.charge}</span>,
    },
    {
      title: "时间",
      width: 200,
      dataIndex: "created_at",
      render: (created_at: string) => <span>{dateFormat(created_at)}</span>,
    },
    {
      title: "操作",
      width: 100,
      fixed: "right",
      render: (_, record: any) => (
        <PerButton
          type="link"
          text="删除"
          class="c-red"
          icon={null}
          p="video.subscribe.delete"
          onClick={() => {
            destory(record.user_id);
          }}
          disabled={null}
        />
      ),
    },
  ];

  const destory = (item: any) => {
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除选中的课时记录？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        course
          .videoSubscribeDestory(id, { user_id: item })
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

  const importexcel = () => {
    if (loading) {
      return;
    }
    let time = [...watched_at];
    if (time.length > 0) {
      time[1] += " 23:59:59";
    }
    setLoading(true);
    let params = {
      page: 1,
      size: total,
      video_id: id,
      user_id: user_id,
      subscribe_start_at: time[0],
      subscribe_end_at: time[1],
    };
    course.videoSubscribe(id, params).then((res: any) => {
      if (res.data.data.total === 0) {
        message.error("数据为空");
        setLoading(false);
        return;
      }

      let filename = "课时订阅学员.xlsx";
      let sheetName = "sheet1";

      let data = [["学员ID", "学员", "手机号", "价格", "时间"]];
      res.data.data.data.forEach((item: any) => {
        data.push([
          item.user_id,
          users[item.user_id].nick_name,
          users[item.user_id].mobile,
          item.charge === 0 ? "-" : "￥" + item.charge,
          moment(item.created_at).format("YYYY-MM-DD HH:mm"),
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

  return (
    <div className="meedu-main-body">
      <BackBartment title="课时销售记录" />
      <div className="float-left mt-30">
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
            setWatchedAts(date);
            setWatchedAt(dateString);
          }}
          placeholder={["订阅时间-开始", "订阅时间-结束"]}
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
              user_id: user_id,
              watched_at: watched_at,
            });
            setRefresh(!refresh);
          }}
        >
          筛选
        </Button>
        <Button type="primary" className="ml-10" onClick={() => importexcel()}>
          导出表格
        </Button>
      </div>
      <div className="float-left mt-30">
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

export default CourseVideoSubscribePage;
