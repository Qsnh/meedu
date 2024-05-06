import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { message, Modal, Alert, Button, Table, Tabs } from "antd";
import { useDispatch } from "react-redux";
import { system } from "../../../api/index";
import type { ColumnsType } from "antd/es/table";
import type { TabsProps } from "antd";
import { ExclamationCircleFilled } from "@ant-design/icons";
import { titleAction } from "../../../store/user/loginUserSlice";

const { confirm } = Modal;

interface DataType {
  id: React.Key;
  name: string;
  sign: string;
  version: string;
}

const SystemApplicationPage = () => {
  const dispatch = useDispatch();
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [repositories, setRepositories] = useState<any>([]);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(100);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);
  const [selectedKey, setSelectedKey] = useState<string>("local");

  useEffect(() => {
    document.title = "功能模块";
    dispatch(titleAction("功能模块"));
  }, []);

  useEffect(() => {
    if (selectedKey === "repository") {
      getRepository();
    } else if (selectedKey === "local") {
      getLocal();
    }
  }, [page, size, selectedKey, refresh]);

  const onChange = (key: string) => {
    setSelectedKey(key);
    setPage(1);
  };

  const getLocal = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .addonsList()
      .then((res: any) => {
        setList(res.data);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const getRepository = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .repository({ page: page, size: size })
      .then((res: any) => {
        setRepositories(res.data.data);
        setTotal(res.data.total);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const columns2: ColumnsType<DataType> = [
    {
      title: "插件",
      render: (_, record: any) => <span>{record.name}</span>,
    },
    {
      title: "版本",
      width: 200,
      dataIndex: "version",
      render: (version: string) => <span>{version}</span>,
    },
    {
      title: "操作",
      key: "action",
      fixed: "right",
      width: 100,
      render: (_, record: any) => (
        <>
          {record.is_buy && (
            <>
              {!record.is_install && (
                <Button
                  type="link"
                  size="small"
                  className="b-n-link c-primary"
                  onClick={() => {
                    installAddons(record);
                  }}
                >
                  安装
                </Button>
              )}
              {record.is_upgrade && (
                <Button
                  type="link"
                  size="small"
                  className="b-n-link c-primary"
                  onClick={() => {
                    upgradeAddons(record);
                  }}
                >
                  升级
                </Button>
              )}
            </>
          )}
          {!record.is_buy && <span className="c-red">无权限安装</span>}
        </>
      ),
    },
  ];
  const columns: ColumnsType<DataType> = [
    {
      title: "插件",
      render: (_, record: any) => <span>{record.name}</span>,
    },
    {
      title: "本地版本",
      width: 200,
      dataIndex: "version",
      render: (version: string) => <span>{version}</span>,
    },
    {
      title: "状态",
      width: 150,
      dataIndex: "version",
      render: (_, record: any) => (
        <>
          {record.enabled && (
            <span className="status-success">
              <span className="status-success-icon"></span>
              <span style={{ color: "#66dd7b" }} className="ml-5">
                运行中
              </span>
            </span>
          )}
        </>
      ),
    },
    {
      title: "操作",
      key: "action",
      fixed: "right",
      width: 100,
      render: (_, record: any) => (
        <>
          {record.enabled && (
            <>
              <Button
                type="link"
                size="small"
                className="b-n-link c-red"
                onClick={() => {
                  addonsSwitch(record, 0);
                }}
              >
                停用
              </Button>
              {record.index_url && (
                <Button
                  type="link"
                  size="small"
                  className="b-n-link c-primary ml-10"
                  onClick={() => {
                    window.open(record.index_url);
                  }}
                >
                  配置
                </Button>
              )}
            </>
          )}
          {!record.enabled && (
            <Button
              type="link"
              size="small"
              className="b-n-link c-primary"
              onClick={() => {
                addonsSwitch(record, 1);
              }}
            >
              启用
            </Button>
          )}
        </>
      ),
    },
  ];

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

  const items: TabsProps["items"] = [
    {
      key: "local",
      label: `本地已安装`,
      children: (
        <div className="float-left">
          <Table
            key="local"
            loading={loading}
            columns={columns}
            dataSource={list}
            rowKey={(record) => record.sign}
            pagination={false}
          />
        </div>
      ),
    },
    {
      key: "repository",
      label: `功能模块`,
      children: (
        <div className="float-left">
          <Table
            key="repository"
            loading={loading}
            columns={columns2}
            dataSource={repositories}
            rowKey={(record) => record.id}
            pagination={paginationProps}
          />
        </div>
      ),
    },
  ];

  const installAddons = (item: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .install({
        addons_id: item.id,
        addons_sign: item.sign,
      })
      .then(() => {
        setLoading(false);
        message.success("成功");
        getRepository();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const upgradeAddons = (item: any) => {
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除此课程？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        system
          .upgrade({
            addons_id: item.id,
            addons_sign: item.sign,
          })
          .then(() => {
            setLoading(false);
            message.success("成功");
            getRepository();
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

  const addonsSwitch = (item: any, status: number) => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .switchAction({
        sign: item.sign,
        action: status === 1 ? "enabled" : "disabled",
      })
      .then(() => {
        setLoading(false);
        message.success("成功");

        // 重新加载数据
        location.reload();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <div className="meedu-main-body">
      <div className="float-left mb-30">
        <Alert
          style={{ color: "#F56C6C" }}
          message="功能模块安装之后并不能直接使用，还需要切换到「本地已安装」列表，找到已安装的功能模块，点击「启用」。"
          type="error"
          closable
        />
      </div>
      <div className="float-left">
        <Tabs
          defaultActiveKey={selectedKey}
          items={items}
          onChange={onChange}
        />
      </div>
    </div>
  );
};

export default SystemApplicationPage;
