import React, { useState, useEffect } from "react";
import { Modal, Table, Button, Space, message } from "antd";
import { system } from "../../../../../api";
import type { ColumnsType } from "antd/es/table";
import { ExclamationCircleFilled } from "@ant-design/icons";
import { dateFormat } from "../../../../../utils";
import { NoticeCreate } from "./create";
import { NoticeUpdate } from "./update";
import closeIcon from "../../../../../assets/img/close.png";
const { confirm } = Modal;

interface DataType {
  id: React.Key;
  charge: number;
}

interface PropInterface {
  open: boolean;
  onClose: () => void;
}

export const NoticeList: React.FC<PropInterface> = ({ open, onClose }) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(10);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);
  const [showCreateWin, setShowCreateWin] = useState<boolean>(false);
  const [showEditWin, setShowEditWin] = useState<boolean>(false);
  const [updateId, setUpdateId] = useState(0);

  useEffect(() => {
    if (open) {
      getData();
    }
  }, [open, page, size, total, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .announcementList({
        page: page,
        size: size,
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

  const columns: ColumnsType<DataType> = [
    {
      title: "公告",
      render: (_, record: any) => <div>{record.title}</div>,
    },
    {
      title: "添加时间",
      width: 200,
      render: (_, record: any) => <span>{dateFormat(record.created_at)}</span>,
    },
    {
      title: "操作",
      width: 120,
      fixed: "right",
      render: (_, record: any) => {
        return (
          <Space>
            <Button
              type="link"
              className="c-primary"
              onClick={() => {
                setUpdateId(record.id);
                setShowEditWin(true);
              }}
            >
              编辑
            </Button>
            <Button
              type="link"
              className="c-red"
              onClick={() => {
                destory(record.id);
              }}
            >
              删除
            </Button>
          </Space>
        );
      },
    },
  ];

  const resetList = () => {
    setPage(1);
    setSize(10);
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
      content: "确认删除此公告？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        system
          .announcementDestroy(id)
          .then(() => {
            setLoading(false);
            message.success("删除成功");
            resetList();
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

  const closeEvt = () => {
    setShowCreateWin(false);
    setShowEditWin(false);
    resetList();
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

  return (
    <>
      {open && (
        <div className="meedu-dialog-mask">
          <div className="meedu-dialog-box">
            <div className="meedu-dialog-header">
              公告
              <img
                className="icon-close"
                onClick={() => onClose()}
                src={closeIcon}
              />
            </div>
            <div className="meedu-dialog-body">
              <div className="float-left mb-15">
                <Button type="primary" onClick={() => setShowCreateWin(true)}>
                  添加
                </Button>
              </div>
              <Table
                loading={loading}
                columns={columns}
                dataSource={list}
                rowKey={(record) => record.id}
                pagination={paginationProps}
              />
            </div>
          </div>
          <NoticeCreate
            open={showCreateWin}
            onClose={() => closeEvt()}
          ></NoticeCreate>
          <NoticeUpdate
            open={showEditWin}
            id={updateId}
            onClose={() => closeEvt()}
          ></NoticeUpdate>
        </div>
      )}
    </>
  );
};
