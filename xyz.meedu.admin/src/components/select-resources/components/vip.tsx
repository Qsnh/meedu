import { useEffect, useState } from "react";
import { Modal, message, Table, Input, Button } from "antd";
import type { ColumnsType } from "antd/es/table";
import { role } from "../../../api/index";

interface DataType {
  id: React.Key;
  charge: number;
}

interface PropsInterface {
  onChange: (result: any) => void;
}

export const RoleComp = (props: PropsInterface) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [refresh, setRefresh] = useState(false);

  useEffect(() => {
    getData();
  }, [refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    role
      .list()
      .then((res: any) => {
        setList(res.data.data);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const resetList = () => {
    setList([]);
    setRefresh(!refresh);
  };

  const columns: ColumnsType<DataType> = [
    {
      title: "ID",
      width: 120,
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "VIP",
      render: (_, record: any) => <div>{record.name}</div>,
    },
    {
      title: "价格",
      width: 120,
      dataIndex: "charge",
      render: (charge: number) => <span>￥{charge}</span>,
    },
  ];

  const rowSelection = {
    onChange: (selectedRowKeys: React.Key[], selectedRows: DataType[]) => {
      let row: any = selectedRows[0];
      if (row) {
        props.onChange({
          resource_type: "vip",
          id: row.id,
          title: row.name,
          thumb: null,
          charge: row.charge,
          original_charge: row.charge,
        });
      }
    },
  };

  return (
    <div className="float-left">
      <div className="float-left mb-15">
        <Table
          rowSelection={{
            type: "radio",
            ...rowSelection,
          }}
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
