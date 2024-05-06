import { useState, useEffect } from "react";
import { Table, Modal, message, Space } from "antd";
import type { ColumnsType } from "antd/es/table";
import { useLocation } from "react-router-dom";
import { useDispatch } from "react-redux";
import { course } from "../../../api/index";
import { titleAction } from "../../../store/user/loginUserSlice";
import { PerButton, BackBartment } from "../../../components";
import { ExclamationCircleFilled } from "@ant-design/icons";
import { CourseChapterCreateDialog } from "../components/chapter-create";
import { CourseChapterUpdateDialog } from "../components/chapter-update";
const { confirm } = Modal;

interface DataType {
  id: React.Key;
  title: string;
}

const CourseChapterPage = () => {
  const dispatch = useDispatch();
  const result = new URLSearchParams(useLocation().search);
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [refresh, setRefresh] = useState(false);
  const [showAddWin, setShowAddWin] = useState<boolean>(false);
  const [showUpdateWin, setShowUpdateWin] = useState<boolean>(false);
  const [updateId, setUpdateId] = useState<number>(0);
  const [cid, setCid] = useState(Number(result.get("course_id")));

  useEffect(() => {
    document.title = "课程章节管理";
    dispatch(titleAction("课程章节管理"));
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
      .chaptersList(cid, {
        course_id: cid,
      })
      .then((res: any) => {
        setList(res.data.chapters);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const columns: ColumnsType<DataType> = [
    {
      title: "排序",
      width: 150,
      render: (_, record: any) => <span>{record.sort}</span>,
    },
    {
      title: "章节",
      render: (_, record: any) => <span>{record.title} </span>,
    },
    {
      title: "操作",
      width: 160,
      fixed: "right",
      render: (_, record: any) => (
        <Space>
          <PerButton
            type="link"
            text="编辑"
            class="c-primary"
            icon={null}
            p="course_chapter.update"
            onClick={() => {
              setUpdateId(record.id);
              setShowUpdateWin(true);
            }}
            disabled={null}
          />
          <PerButton
            type="link"
            text="删除"
            class="c-red"
            icon={null}
            p="course_chapter.destroy"
            onClick={() => {
              destory(record.id);
            }}
            disabled={null}
          />
        </Space>
      ),
    },
  ];

  const resetData = () => {
    setList([]);
    setRefresh(!refresh);
  };

  const destory = (id: number) => {
    if (id === 0) {
      return;
    }
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除此章节？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        course
          .chaptersDestroy(cid, id)
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
      <BackBartment title="课程章节管理" />
      <CourseChapterCreateDialog
        cid={cid}
        open={showAddWin}
        onCancel={() => setShowAddWin(false)}
        onSuccess={() => {
          resetData();
          setShowAddWin(false);
        }}
      ></CourseChapterCreateDialog>
      <CourseChapterUpdateDialog
        id={updateId}
        cid={cid}
        open={showUpdateWin}
        onCancel={() => setShowUpdateWin(false)}
        onSuccess={() => {
          resetData();
          setShowUpdateWin(false);
        }}
      ></CourseChapterUpdateDialog>
      <div className="float-left  mt-30 mb-30">
        <PerButton
          type="primary"
          text="添加章节"
          class=""
          icon={null}
          p="course_chapter.store"
          onClick={() => setShowAddWin(true)}
          disabled={null}
        />
      </div>
      <div className="float-left">
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

export default CourseChapterPage;
