import { useEffect, useState } from "react";
import {
  Button,
  Modal,
  Input,
  message,
  Table,
  Empty,
  ConfigProvider,
} from "antd";
import type { ColumnsType } from "antd/es/table";
import { media } from "../../api";
import styles from "./index.module.scss";
import { useSelector } from "react-redux";
import { DurationText, PerButton, UploadVideoItem } from "../../components";
import { yearFormat } from "../../utils/index";
import { ExclamationCircleFilled } from "@ant-design/icons";
import emptyIcon from "../../assets/images/upload-video/empty.png";
const { confirm } = Modal;

interface DataType {
  id: React.Key;
  name: string;
}

interface PropInterface {
  open: boolean;
  onCancel: () => void;
  onSuccess: (selectedRows: any) => void;
}

export const UploadVideoDialog: React.FC<PropInterface> = ({
  open,
  onCancel,
  onSuccess,
}) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(7);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);
  const [keywords, setKeywords] = useState<string>("");
  const [selectedRowKeys, setSelectedRowKeys] = useState<any>([]);
  const [selectedRows, setSelectedRows] = useState<any>([]);
  const [isNoService, setIsNoService] = useState(false);
  const [isLocalService, setIsLocalService] = useState(false);
  const [isTenService, setIsTenService] = useState(false);
  const [isAliService, setIsAliService] = useState(false);
  const [openUploadItem, setOpenUploadItem] = useState(false);
  const user = useSelector((state: any) => state.loginUser.value.user);
  const service = useSelector(
    (state: any) => state.systemConfig.value.video.default_service
  );

  useEffect(() => {
    if (open) {
      getData();
    }
  }, [open, page, size, refresh]);

  useEffect(() => {
    resetList();
  }, [openUploadItem]);

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

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    media
      .newVideoList({
        page: page,
        size: size,
        sort: "id",
        order: "desc",
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

  const resetList = () => {
    setPage(1);
    setSize(7);
    setList([]);
    setSelectedRowKeys([]);
    setSelectedRows([]);
    setKeywords("");
    setRefresh(!refresh);
  };

  const checkPermission = (val: string) => {
    return typeof user.permissions[val] !== "undefined";
  };

  const columns2: ColumnsType<DataType> = [
    {
      title: "视频名称",
      render: (_, record: any) => <span>{record.title}</span>,
    },
    {
      title: "时长",
      width: 90,
      render: (_, record: any) => (
        <DurationText duration={record.duration}></DurationText>
      ),
    },
    {
      title: "大小",
      width: 100,
      render: (_, record: any) => (
        <span>{fileSizeConversion(record.size)}MB</span>
      ),
    },
    {
      title: "上传时间",
      width: 120,
      dataIndex: "created_at",
      render: (created_at: string) => <span>{yearFormat(created_at)}</span>,
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
          p="media.video.delete.multi"
          onClick={() => {
            destory(record.id);
          }}
          disabled={null}
        />
      ),
    },
  ];

  const resetData = () => {
    setPage(1);
    setList([]);
    setRefresh(!refresh);
  };

  const destory = (item: any) => {
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除选中的视频？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        let ids = [];
        ids.push(item);
        setLoading(true);
        media
          .newDestroyVideo({ ids: ids })
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

  const fileSizeConversion = (byte: number) => {
    var size = `${(byte / (1024 * 1024)).toFixed(2)}`;
    const sizeStr = `${size}`;
    const index = sizeStr.indexOf(".");
    const dou = sizeStr.substr(index + 1, 2);
    if (dou == "00") {
      return sizeStr.substring(0, index) + sizeStr.substr(index + 3, 2);
    }
    return size;
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
    onChange: (selectedRowKeys: React.Key[], selectedRows: DataType[]) => {
      setSelectedRowKeys(selectedRowKeys);
      let row: any = selectedRows[0];
      if (row) {
        setSelectedRows(row);
      }
    },
  };

  const confirmAdd = () => {
    if (isNoService) {
      message.warning("请先在系统配置的视频存储中完成参数配置");
      return;
    }
    if (selectedRows.length === 0) {
      message.error("请选择需要操作的视频");
      return;
    }
    onSuccess(selectedRows);
  };

  const completeUpload = () => {
    setOpenUploadItem(false);
  };

  const tableEmptyRender = () => {
    return <Empty image={emptyIcon} description={""} />;
  };

  return (
    <>
      {open ? (
        <Modal
          title=""
          centered
          forceRender
          open={true}
          width={800}
          onCancel={() => {
            onCancel();
          }}
          maskClosable={false}
          closable={false}
          onOk={() => confirmAdd()}
        >
          <div className={styles["header"]}>视频列表</div>
          <div className={styles["body"]}>
            {isNoService && (
              <div className="float-left">
                未配置视频存储服务，请前往『系统』-『系统配置』-『视频存储』配置。
              </div>
            )}
            <div className="float-left">
              {isAliService ||
              isTenService ||
              (isLocalService &&
                checkPermission("addons.LocalUpload.video.index")) ? (
                <>
                  <div className="float-left j-b-flex mb-15">
                    <div className="d-flex">
                      <Button
                        type="primary"
                        onClick={() => {
                          if (isNoService) {
                            message.warning(
                              "请先在系统配置的视频存储中完成参数配置"
                            );
                            return;
                          }
                          setOpenUploadItem(true);
                        }}
                      >
                        上传视频
                      </Button>
                    </div>
                    <div className="d-flex">
                      <Input
                        value={keywords}
                        style={{ width: 150 }}
                        onChange={(e) => {
                          setKeywords(e.target.value);
                        }}
                        allowClear
                        placeholder="视频名称关键词"
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
                    </div>
                  </div>
                </>
              ) : null}

              {!isNoService ? (
                <div className="float-left">
                  <ConfigProvider renderEmpty={tableEmptyRender}>
                    <Table
                      rowSelection={{
                        type: "radio",
                        ...rowSelection,
                      }}
                      loading={loading}
                      columns={columns2}
                      dataSource={list}
                      rowKey={(record) => record.id}
                      pagination={paginationProps}
                    />
                  </ConfigProvider>
                </div>
              ) : null}
            </div>
          </div>
        </Modal>
      ) : null}

      <UploadVideoItem
        open={openUploadItem}
        onCancel={() => setOpenUploadItem(false)}
        onSuccess={() => {
          completeUpload();
        }}
      />
    </>
  );
};
