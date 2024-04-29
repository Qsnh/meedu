import React, { useState, useEffect } from "react";
import { Modal, Table, Button, Space, message } from "antd";
import { system } from "../../../../../api";
import type { ColumnsType } from "antd/es/table";
import { ExclamationCircleFilled } from "@ant-design/icons";
import { LinksCreate } from "./create";
import { LinksUpdate } from "./update";
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

export const LinksList: React.FC<PropInterface> = ({ open, onClose }) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [showCreateWin, setShowCreateWin] = useState<boolean>(false);
  const [showEditWin, setShowEditWin] = useState<boolean>(false);
  const [updateId, setUpdateId] = useState(0);

  useEffect(() => {
    if (open) {
      getData();
    }
  }, [open]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .linksList({
        page: 1,
        size: 1000,
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
      title: "排序",
      width: 120,
      render: (_, record: any) => <span>{record.sort}</span>,
    },
    {
      title: "链接名",
      render: (_, record: any) => <span>{record.name}</span>,
    },
    {
      title: "链接",
      width: 300,
      render: (_, record: any) => <span>{record.url}</span>,
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
  const destory = (id: number) => {
    if (id === 0) {
      return;
    }
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除此链接？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        system
          .linksDestroy(id)
          .then(() => {
            setLoading(false);
            message.success("删除成功");
            getData();
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
    getData();
  };

  return (
    <>
      {open && (
        <div className="meedu-dialog-mask">
          <div className="meedu-dialog-box">
            <div className="meedu-dialog-header">
              友情链接
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
                pagination={false}
              />
            </div>
          </div>
          <LinksCreate
            open={showCreateWin}
            onClose={() => closeEvt()}
          ></LinksCreate>
          <LinksUpdate
            open={showEditWin}
            id={updateId}
            onClose={() => closeEvt()}
          ></LinksUpdate>
        </div>
      )}
    </>
  );
};
