import { useEffect, useState } from "react";
import { Modal, Table, Space, Button, Dropdown, message } from "antd";
import type { MenuProps } from "antd";
import type { ColumnsType } from "antd/es/table";
import { useNavigate, useLocation, useSearchParams } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { course } from "../../../api/index";
import { titleAction } from "../../../store/user/loginUserSlice";
import { DownOutlined, ExclamationCircleFilled } from "@ant-design/icons";
import { PerButton, BackBartment, DurationText } from "../../../components";
import { dateFormat } from "../../../utils/index";
const { confirm } = Modal;

interface DataType {
  id: React.Key;
  name: string;
  published_at: string;
}

interface LocalSearchParamsInterface {
  page?: number;
  size?: number;
}

const CourseVideoPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const result = new URLSearchParams(useLocation().search);
  const [searchParams, setSearchParams] = useSearchParams({
    page: "1",
    size: "100",
  });
  const page = parseInt(searchParams.get("page") || "1");
  const size = parseInt(searchParams.get("size") || "100");

  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);
  const [selectedRowKeys, setSelectedRowKeys] = useState<any>([]);
  const [cid, setCid] = useState(Number(result.get("course_id")));
  const [title, setTitle] = useState(String(result.get("title")));
  const enabledAddons = useSelector(
    (state: any) => state.enabledAddonsConfig.value.enabledAddons
  );

  useEffect(() => {
    document.title = "课时管理";
    dispatch(titleAction("课时管理"));
  }, []);

  useEffect(() => {
    setCid(Number(result.get("course_id")));
    setTitle(String(result.get("title")));
  }, [result.get("course_id"), result.get("title")]);

  useEffect(() => {
    getData();
  }, [cid, page, size, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    course
      .videoList({
        page: page,
        size: size,
        sort: "published_at",
        order: "asc",
        cid: cid,
      })
      .then((res: any) => {
        setList(res.data.videos.data);
        setTotal(res.data.videos.total);
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

  const destoryMulti = () => {
    if (selectedRowKeys.length === 0) {
      message.error("请选择需要操作的数据");
      return;
    }
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除选中的课时？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        course
          .videoDestoryMulti({ ids: selectedRowKeys })
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
      title: "ID",
      width: "6%",
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "课时",
      width: "38%",
      render: (_, record: any) => (
        <>
          {record.chapter && (
            <>
              <span>{record.chapter.title}</span>
              <span className="mx-5">/</span>
            </>
          )}
          <span>{record.title}</span>
        </>
      ),
    },
    {
      title: "课时时长",
      width: "15%",
      render: (_, record: any) => (
        <DurationText duration={record.duration}></DurationText>
      ),
    },
    {
      title: "上架时间",
      width: "16%",
      dataIndex: "published_at",
      render: (published_at: string) => <span>{dateFormat(published_at)}</span>,
    },
    {
      title: "是否显示",
      width: "8%",
      render: (_, record: any) => (
        <>
          {record.is_show === 1 && <span className="c-green">· 显示</span>}
          {record.is_show !== 1 && <span className="c-red">· 隐藏</span>}
        </>
      ),
    },
    {
      title: "操作",
      width: "14%",
      fixed: "right",
      render: (_, record: any) => {
        const items: MenuProps["items"] = [
          {
            key: "1",
            label: (
              <PerButton
                type="link"
                text="单独购买"
                class="c-primary"
                icon={null}
                p="video.subscribes"
                onClick={() => {
                  navigate(
                    "/course/vod/video/subscribe?course_id=" +
                      cid +
                      "&video_id=" +
                      record.id
                  );
                }}
                disabled={null}
              />
            ),
          },
        ];
        return (
          <Space>
            <PerButton
              type="link"
              text="学员"
              class="c-primary"
              icon={null}
              p="video.watch.records"
              onClick={() => {
                navigate(
                  "/course/vod/video/watch-records?course_id=" +
                    cid +
                    "&id=" +
                    record.id
                );
              }}
              disabled={null}
            />
            <PerButton
              type="link"
              text="编辑"
              class="c-primary"
              icon={null}
              p="video.update"
              onClick={() => {
                navigate(
                  "/course/vod/video/update?course_id=" +
                    cid +
                    "&id=" +
                    record.id
                );
              }}
              disabled={null}
            />
            <Dropdown menu={{ items }}>
              <Button
                type="link"
                className="c-primary"
                onClick={(e) => e.preventDefault()}
              >
                <Space size="small" align="center">
                  更多
                  <DownOutlined />
                </Space>
              </Button>
            </Dropdown>
          </Space>
        );
      },
    },
  ];

  const rowSelection = {
    selectedRowKeys: selectedRowKeys,
    onChange: (selectedRowKeys: React.Key[], selectedRows: DataType[]) => {
      setSelectedRowKeys(selectedRowKeys);
    },
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title={title} />
      <div className="float-left mt-30">
        <PerButton
          type="primary"
          text="新建课时"
          class=""
          icon={null}
          p="video.store"
          onClick={() => navigate("/course/vod/video/create?course_id=" + cid)}
          disabled={null}
        />
        <PerButton
          type="primary"
          text="章节管理"
          class="ml-10"
          icon={null}
          p="course_chapter"
          onClick={() => navigate("/course/vod/chapter/index?course_id=" + cid)}
          disabled={null}
        />
        <PerButton
          type="danger"
          text="删除"
          class="ml-10"
          icon={null}
          p="video.destroy"
          onClick={() => destoryMulti()}
          disabled={null}
        />
      </div>
      <div className="float-left mt-30">
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

export default CourseVideoPage;
