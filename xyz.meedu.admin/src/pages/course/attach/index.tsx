import { useEffect, useState } from "react";
import { Modal, Table, message } from "antd";
import type { ColumnsType } from "antd/es/table";
import { useNavigate, useLocation } from "react-router-dom";
import { useDispatch } from "react-redux";
import { course } from "../../../api/index";
import { titleAction } from "../../../store/user/loginUserSlice";
import { ExclamationCircleFilled } from "@ant-design/icons";
import { PerButton, BackBartment } from "../../../components";
const { confirm } = Modal;

interface DataType {
  id: React.Key;
  name: string;
}

const CourseAttachPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [refresh, setRefresh] = useState(false);
  const [cid, setCid] = useState(Number(result.get("course_id")));

  useEffect(() => {
    document.title = "课程附件管理";
    dispatch(titleAction("课程附件管理"));
  }, []);

  useEffect(() => {
    setCid(Number(result.get("course_id")));
  }, [result.get("course_id")]);

  useEffect(() => {
    getData();
  }, [cid, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    course
      .attachList({
        course_id: cid,
      })
      .then((res: any) => {
        setList(res.data.data);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const columns: ColumnsType<DataType> = [
    {
      title: "ID",
      width: 120,
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "附件名",
      render: (_, record: any) => <span>{record.name}</span>,
    },
    {
      title: "路径",
      width: 500,
      render: (_, record: any) => <span>{record.path}</span>,
    },
    {
      title: "下载次数",
      width: 150,
      render: (_, record: any) => <span>{record.download_times}次</span>,
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
          p="course_attach.destroy"
          onClick={() => {
            destory(record.id);
          }}
          disabled={null}
        />
      ),
    },
  ];

  const destory = (id: number) => {
    if (id === 0) {
      return;
    }
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除此附件？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        course
          .attachDestory(id)
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

  const resetData = () => {
    setList([]);
    setRefresh(!refresh);
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="课程附件管理" />
      <div className="float-left mt-30">
        <PerButton
          type="primary"
          text="添加"
          class=""
          icon={null}
          p="course_attach.store"
          onClick={() => navigate("/course/vod/attach/create?course_id=" + cid)}
          disabled={null}
        />
      </div>
      <div className="float-left mt-30">
        <Table
          loading={loading}
          columns={columns}
          dataSource={list}
          rowKey={(record) => record.id}
          pagination={false}
        />
      </div>
    </div>
  );
};

export default CourseAttachPage;
