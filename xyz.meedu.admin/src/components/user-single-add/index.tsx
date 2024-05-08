import React, { useState, useEffect } from "react";
import { Modal, message, Table, Button, Input, Select, DatePicker } from "antd";
import type { ColumnsType } from "antd/es/table";
import { member } from "../../api/index";
import styles from "./index.module.scss";
import { dateFormat } from "../../utils/index";
const { RangePicker } = DatePicker;

interface DataType {
  id: React.Key;
  created_at: string;
  credit1: number;
}

interface PropInterface {
  open: boolean;
  type: string;
  onCancel: () => void;
  onSuccess: (selectedRows: any) => void;
}

export const UserSingleAddDialog: React.FC<PropInterface> = ({
  open,
  type,
  onCancel,
  onSuccess,
}) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(10);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);
  const [keywords, setKeywords] = useState<string>("");
  const [tag_id, setTagId] = useState<any>([]);
  const [tags, setTags] = useState<any>([]);
  const [created_at, setCreatedAt] = useState<any>([]);
  const [createdAts, setCreatedAts] = useState<any>([]);
  const [selectedRowKeys, setSelectedRowKeys] = useState<any>([]);
  const [otherKeys, setOtherKeys] = useState<any>([]);

  useEffect(() => {
    getData();
  }, [page, size, refresh]);

  useEffect(() => {
    if (open) {
      resetList();
    }
  }, [open]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    member
      .list({
        page: page,
        size: size,
        sort: "id",
        order: "desc",
        keywords: keywords,
        role_id: null,
        tag_id: tag_id,
        created_at: created_at,
      })
      .then((res: any) => {
        setList(res.data.data.data);
        setTotal(res.data.data.total);
        let tags = res.data.tags;
        let arr2: any = [];
        tags.map((item: any) => {
          arr2.push({
            label: item.name,
            value: item.id,
          });
        });
        setTags(arr2);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const confirmAdd = () => {
    if (selectedRowKeys.length === 0) {
      message.error("请选择需要操作的学员");
      return;
    }
    if (type === "mobile") {
      onSuccess(otherKeys);
    } else {
      onSuccess(selectedRowKeys);
    }
  };

  const resetList = () => {
    setPage(1);
    setSize(10);
    setList([]);
    setSelectedRowKeys([]);
    setKeywords("");
    setCreatedAts([]);
    setCreatedAt([]);
    setTagId([]);
    setRefresh(!refresh);
  };

  const columns: ColumnsType<DataType> = [
    {
      title: "ID",
      width: 120,
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "学员",
      render: (_, record: any) => (
        <>
          <div className="user-item d-flex">
            <div className="avatar">
              <img src={record.avatar} width="40" height="40" />
            </div>
            <div className="ml-10">{record.nick_name}</div>
          </div>
        </>
      ),
    },
    {
      title: "手机号码",
      width: 200,
      render: (_, record: any) => (
        <>
          {record.mobile && <span>{record.mobile}</span>}
          {!record.mobile && <span>-</span>}
        </>
      ),
    },
    {
      title: "注册时间",
      width: 200,
      dataIndex: "created_at",
      render: (created_at: string) => <span>{dateFormat(created_at)}</span>,
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

  const rowSelection = {
    selectedRowKeys: selectedRowKeys,
    onChange: (selectedRowKeys: React.Key[], selectedRows: DataType[]) => {
      setSelectedRowKeys(selectedRowKeys);
      if (type === "mobile") {
        let box: any = [];
        selectedRows.map((item: any) => {
          box.push(item.mobile);
        });
        setOtherKeys(box);
      } else {
        setOtherKeys([]);
      }
    },
  };

  return (
    <>
      {open ? (
        <Modal
          title=""
          centered
          forceRender
          open={true}
          width={1200}
          onCancel={() => {
            onCancel();
          }}
          maskClosable={false}
          closable={false}
          onOk={() => confirmAdd()}
        >
          <div className={styles["header"]}>添加学员</div>
          <div className={styles["body"]}>
            <div className="d-flex float-left">
              <Input
                value={keywords}
                style={{ width: 150 }}
                onChange={(e) => {
                  setKeywords(e.target.value);
                }}
                allowClear
                placeholder="关键字"
              />
              <Select
                style={{ width: 150, marginLeft: 10 }}
                value={tag_id}
                onChange={(e) => {
                  setTagId(e);
                }}
                allowClear
                placeholder="学员标签"
                options={tags}
              />
              <RangePicker
                format={"YYYY-MM-DD"}
                value={createdAts}
                style={{ marginLeft: 10 }}
                onChange={(date, dateString) => {
                  dateString[1] += " 23:59:59";
                  setCreatedAt(dateString);
                  setCreatedAts(date);
                }}
                placeholder={["注册-开始日期", "注册-结束日期"]}
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
            <div className="float-left mt-30">
              <Table
                rowSelection={{
                  type: "radio",
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
        </Modal>
      ) : null}
    </>
  );
};
