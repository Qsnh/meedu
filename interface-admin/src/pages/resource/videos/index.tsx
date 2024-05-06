import { useState, useEffect } from "react";
import { Table, Modal, message, Input, Button } from "antd";
import { useNavigate, useSearchParams } from "react-router-dom";
import type { ColumnsType } from "antd/es/table";
import { useDispatch, useSelector } from "react-redux";
import { media } from "../../../api/index";
import { titleAction } from "../../../store/user/loginUserSlice";
import { PerButton, DurationText, UploadVideoItem } from "../../../components";
import { dateFormat } from "../../../utils/index";
import { ExclamationCircleFilled } from "@ant-design/icons";
const { confirm } = Modal;

interface DataType {
  id: React.Key;
  title: string;
  duration: number;
  goods_type_text: string;
  created_at: string;
}

interface LocalSearchParamsInterface {
  page?: number;
  size?: number;
  keywords?: string;
}

const ResourceVideosPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [searchParams, setSearchParams] = useSearchParams({
    page: "1",
    size: "10",
    keywords: "",
  });
  const page = parseInt(searchParams.get("page") || "1");
  const size = parseInt(searchParams.get("size") || "10");
  const [keywords, setKeywords] = useState(searchParams.get("keywords") || "");

  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);
  const [selectedRowKeys, setSelectedRowKeys] = useState<any>([]);
  const [selectedLocalKeys, setSelectedLocalKeys] = useState<any>([]);
  const [selectedOtherKeys, setSelectedOtherKeys] = useState<any>([]);
  const [openUploadItem, setOpenUploadItem] = useState(false);
  const [isNoService, setIsNoService] = useState(false);
  const [isLocalService, setIsLocalService] = useState(false);
  const [isTenService, setIsTenService] = useState(false);
  const [isAliService, setIsAliService] = useState(false);
  const [records, setRecords] = useState<any>({});
  const [tenRecords, setTenRecords] = useState<any>({});
  const service = useSelector(
    (state: any) => state.systemConfig.value.video.default_service
  );
  const enabledAddons = useSelector(
    (state: any) => state.enabledAddonsConfig.value.enabledAddons
  );

  useEffect(() => {
    document.title = "视频库";
    dispatch(titleAction("视频库"));
  }, []);

  useEffect(() => {
    if (service === "") {
      setIsNoService(true);
    } else if (service === "local") {
      setIsLocalService(true);
    } else if (service === "tencent") {
      setIsTenService(true);
    } else if (service === "aliyun") {
      setIsAliService(true);
    } else {
      setIsNoService(false);
      setIsLocalService(false);
      setIsTenService(false);
      setIsAliService(false);
    }
  }, [service]);

  useEffect(() => {
    getData();
  }, [page, size, refresh]);

  useEffect(() => {
    if (list.length === 0) {
      return;
    }
    let newbox = [];
    let tenbox = [];
    for (var i = 0; i < list.length; i++) {
      if (list[i].storage_driver === "aliyun") {
        newbox.push(list[i].storage_file_id);
      }
      if (list[i].storage_driver === "tencent") {
        tenbox.push(list[i].storage_file_id);
      }
    }
  }, [list, enabledAddons]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    media
      .newVideoList({
        page: page,
        size: size,
        keywords: keywords,
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
        if (typeof params.keywords !== "undefined") {
          prev.set("keywords", params.keywords);
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
      keywords: "",
    });
    setKeywords("");
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
      title: "视频名称",
      dataIndex: "title",
      render: (title: string) => <span>{title}</span>,
    },
    {
      title: "视频时长",
      width: 150,
      render: (_, record: any) => (
        <DurationText duration={record.duration}></DurationText>
      ),
    },
    {
      title: "大小",
      width: 150,
      render: (_, record: any) => <div>{record.size_mb}MB</div>,
    },
    {
      title: "加密",
      width: 120,
      render: (_, record: any) => (
        <>
          {record.storage_driver === "aliyun" &&
          checkTrans(record.storage_file_id) ? (
            <span>已加密</span>
          ) : record.storage_driver === "tencent" &&
            checkTenTrans(record.storage_file_id) ? (
            <span>已加密</span>
          ) : (
            <span>-</span>
          )}
        </>
      ),
    },
    {
      title: "上传时间",
      width: 200,
      render: (_, record: any) => <div>{dateFormat(record.created_at)}</div>,
    },
  ];

  const checkTrans = (val: string) => {
    return typeof records[val] !== "undefined";
  };

  const checkTenTrans = (val: string) => {
    return typeof tenRecords[val] !== "undefined";
  };

  const rowSelection = {
    selectedRowKeys: selectedRowKeys,
    onChange: (selectedRowKeys: React.Key[], selectedRows: DataType[]) => {
      let arrLocal: any = [];
      let arr: any = [];
      selectedRows.map((item: any) => {
        if (item.storage_driver === "local") {
          arrLocal.push(item.storage_file_id);
        } else {
          arr.push(item.id);
        }
      });
      setSelectedRowKeys(selectedRowKeys);
      setSelectedOtherKeys(arr);
      setSelectedLocalKeys(arrLocal);
    },
  };

  const destorymulti = () => {
    if (selectedRowKeys.length === 0) {
      message.error("请选择需要操作的数据");
      return;
    }
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除选中的视频？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        destoryConfirm();
      },
      onCancel() {
        console.log("Cancel");
      },
    });
  };

  const destoryConfirm = async () => {
    if (loading) {
      return;
    }
    setLoading(true);
    try {
      if (selectedOtherKeys.length > 0) {
        await media.newDestroyVideo({
          ids: selectedOtherKeys,
        });
      }
      message.success("成功");
      resetData();
      setLoading(false);
    } catch (err: any) {
      setLoading(false);
    }
  };

  const resetData = () => {
    resetLocalSearchParams({
      page: 1,
    });
    setList([]);
    setRefresh(!refresh);
  };

  const completeUpload = () => {
    setOpenUploadItem(false);
    resetData();
  };

  return (
    <div className="meedu-main-body">
      <div className="float-left j-b-flex mb-30">
        <div className="d-flex">
          <Button
            type="primary"
            onClick={() => {
              if (isNoService) {
                message.warning("请先在系统配置的视频存储中完成参数配置");
                return;
              }
              setOpenUploadItem(true);
            }}
          >
            上传视频
          </Button>
          <PerButton
            type="danger"
            text="批量删除"
            class="ml-10"
            icon={null}
            p="media.video.delete.multi"
            onClick={() => destorymulti()}
            disabled={null}
          />
        </div>
        <div className="d-flex">
          <Input
            value={keywords || ""}
            onChange={(e) => {
              setKeywords(e.target.value);
            }}
            allowClear
            style={{ width: 150 }}
            placeholder="关键字"
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
                keywords: keywords,
              });
              setRefresh(!refresh);
            }}
          >
            筛选
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
      <UploadVideoItem
        open={openUploadItem}
        onCancel={() => setOpenUploadItem(false)}
        onSuccess={() => {
          completeUpload();
        }}
      />
    </div>
  );
};

export default ResourceVideosPage;
