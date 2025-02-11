import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { message, Modal, Alert, Button, Table } from "antd";
import { useDispatch } from "react-redux";
import { system } from "../../../api/index";
import type { ColumnsType } from "antd/es/table";
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
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(100);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);

  useEffect(() => {
    document.title = "功能模块";
    dispatch(titleAction("功能模块"));
  }, []);

  useEffect(() => {
    getLocal();
  }, [page, size, refresh]);

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
    </div>
  );
};

export default SystemApplicationPage;
