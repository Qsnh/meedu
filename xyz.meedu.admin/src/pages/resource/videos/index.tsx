import { useState, useEffect } from "react";
import {
  Table,
  Modal,
  message,
  Input,
  Button,
  Space,
  Row,
  Col,
  Spin,
} from "antd";
import { useNavigate, useSearchParams } from "react-router-dom";
import type { ColumnsType } from "antd/es/table";
import { useDispatch, useSelector } from "react-redux";
import { media, videoCategory } from "../../../api/index";
import { titleAction } from "../../../store/user/loginUserSlice";
import {
  PerButton,
  DurationText,
  UploadVideoItem,
  TreeCategory,
} from "../../../components";
import { dateFormat } from "../../../utils/index";
import { ExclamationCircleFilled } from "@ant-design/icons";
import { ResourceCategoryCreate } from "./compenents/create";
import { ResourceCategoryUpdate } from "./compenents/update";
import { VideoCategoryUpdate } from "./compenents/video-update";
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
  category_ids?: any;
}

const ResourceVideosPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [searchParams, setSearchParams] = useSearchParams({
    page: "1",
    size: "10",
    keywords: "",
    category_ids: "[]",
  });
  const page = parseInt(searchParams.get("page") || "1");
  const size = parseInt(searchParams.get("size") || "10");
  const [keywords, setKeywords] = useState(searchParams.get("keywords") || "");
  const [category_ids, setCategoryIds] = useState(
    JSON.parse(searchParams.get("category_ids") || "[]")
  );

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
  const [createVisible, setCreateVisible] = useState(false);
  const [updateVisible, setUpdateVisible] = useState(false);
  const [cid, setCid] = useState<number>(0);
  const [rUpdateVisible, setRUpdateVisible] = useState(false);
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
  }, [category_ids, page, size, refresh]);

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
    let categoryId = category_ids.join(",");
    setLoading(true);
    media
      .newVideoList({
        page: page,
        size: size,
        keywords: keywords,
        category_id: categoryId === "" ? -1 : categoryId,
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
        if (typeof params.category_ids !== "undefined") {
          prev.set("category_ids", JSON.stringify(params.category_ids));
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

  const editMulti = () => {
    if (selectedRowKeys.length === 0) {
      message.warning("请选择需要操作的数据");
      return;
    }
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认修改选中的视频所属分类？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        setRUpdateVisible(true);
      },
      onCancel() {
        console.log("Cancel");
      },
    });
  };

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
      message.warning("请选择需要操作的数据");
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

  const delUser = (id: any) => {
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除此分类？",
      centered: true,
      okText: "确定",
      cancelText: "取消",
      onOk() {
        videoCategory.destroy(id).then((res: any) => {
          message.success("成功");
          resetLocalSearchParams({
            page: 1,
            category_ids: [],
          });
          setRefresh(!refresh);
          setCategoryIds([]);
        });
      },
      onCancel() {
        console.log("Cancel");
      },
    });
  };

  return (
    <div className="meedu-main-body">
      <Row>
        <Col
          span={3}
          style={{
            borderRight: "1px solid #f6f6f6",
            paddingRight: 16,
            boxSizing: "border-box",
          }}
        >
          <div className="float-left">
            <TreeCategory
              selected={category_ids}
              refresh={refresh}
              type="cate"
              text="分类"
              onUpdate={(keys: any) => {
                setCategoryIds(keys);
                resetLocalSearchParams({
                  page: 1,
                  category_ids: typeof keys !== "undefined" ? keys : [],
                });
              }}
            />
          </div>
        </Col>
        <Col
          span={21}
          style={{
            paddingLeft: 16,
            boxSizing: "border-box",
          }}
        >
          <div className="float-left j-b-flex mb-30">
            <div className="d-flex">
              <PerButton
                type="default"
                text="添加分类"
                class=""
                icon={null}
                p="media.video-category.store"
                onClick={() => setCreateVisible(true)}
                disabled={null}
              />
              {Number(category_ids.join(",")) > 0 && (
                <>
                  <PerButton
                    type="default"
                    text="编辑分类"
                    class="ml-10"
                    icon={null}
                    p="media.video-category.delete"
                    onClick={() => {
                      setCid(Number(category_ids.join(",")));
                      setUpdateVisible(true);
                    }}
                    disabled={null}
                  />
                  <PerButton
                    type="default"
                    text="删除分类"
                    class="ml-10"
                    icon={null}
                    p="media.video.delete.multi"
                    onClick={() => delUser(Number(category_ids.join(",")))}
                    disabled={null}
                  />
                </>
              )}
              <div className="column-line ml-10"></div>
              <Button
                type="primary"
                className="ml-10"
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
                type="primary"
                text="修改视频分类"
                class="ml-10"
                icon={null}
                p="media.video.change-category"
                onClick={() => {
                  editMulti();
                }}
                disabled={null}
              />
              <PerButton
                type="danger"
                text="删除视频"
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
        </Col>
      </Row>
      <ResourceCategoryCreate
        open={createVisible}
        onCancel={() => {
          setCreateVisible(false);
          setRefresh(!refresh);
        }}
      />
      <ResourceCategoryUpdate
        id={cid}
        open={updateVisible}
        onCancel={() => {
          setUpdateVisible(false);
          setRefresh(!refresh);
        }}
      />
      <VideoCategoryUpdate
        cid={category_ids.join(",") === "" ? 0 : Number(category_ids.join(","))}
        ids={selectedRowKeys}
        open={rUpdateVisible}
        onCancel={() => {
          setRUpdateVisible(false);
          resetData();
        }}
      />
      <UploadVideoItem
        open={openUploadItem}
        categoryId={
          category_ids.join(",") === "" ? 0 : Number(category_ids.join(","))
        }
        onCancel={() => setOpenUploadItem(false)}
        onSuccess={() => {
          completeUpload();
        }}
      ></UploadVideoItem>
    </div>
  );
};

export default ResourceVideosPage;
