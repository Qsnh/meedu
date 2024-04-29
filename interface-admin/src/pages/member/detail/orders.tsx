import { useEffect, useState } from "react";
import { Table } from "antd";
import type { ColumnsType } from "antd/es/table";
import { member } from "../../../api/index";
import { ThumbBar } from "../../../components";
import { dateFormat } from "../../../utils/index";
import paperIcon from "../../../assets/img/default-paper.png";
import vipIcon from "../../../assets/img/default-vip.png";

interface PropsInterface {
  id: number;
}

interface DataType {
  id: React.Key;
  created_at: string;
}

export const UserOrdersComp = (props: PropsInterface) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(8);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);

  useEffect(() => {
    getData();
  }, [props.id, page, size, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    member
      .userOrders(props.id, {
        page: page,
        size: size,
        status: 9,
      })
      .then((res: any) => {
        setList(res.data.data.data);
        setTotal(res.data.data.total);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
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

  const columns: ColumnsType<DataType> = [
    {
      title: "订单编号",
      width: 200,
      render: (_, record: any) => <span>{record.order_id}</span>,
    },
    {
      title: "订单商品",
      render: (_, record: any) => (
        <>
          {record.goods.map((item: any) => (
            <div key={item.id}>
              {item.goods_type === "BOOK" ? (
                <ThumbBar
                  value={item.goods_thumb}
                  width={67.5}
                  height={90}
                  title={item.goods_name}
                  border={4}
                ></ThumbBar>
              ) : item.goods_type === "模拟试卷" ||
                item.goods_type === "试卷" ||
                item.goods_type === "练习" ? (
                <ThumbBar
                  value={paperIcon}
                  width={120}
                  height={90}
                  title={item.goods_name}
                  border={4}
                ></ThumbBar>
              ) : item.goods_type === "ROLE" ? (
                <ThumbBar
                  value={vipIcon}
                  width={120}
                  height={90}
                  title={item.goods_name}
                  border={4}
                ></ThumbBar>
              ) : (
                <ThumbBar
                  value={item.goods_thumb}
                  width={120}
                  height={90}
                  title={item.goods_name}
                  border={4}
                ></ThumbBar>
              )}
            </div>
          ))}
        </>
      ),
    },
    {
      title: "支付金额",
      width: 200,
      render: (_, record: any) => <span>{record.charge}</span>,
    },
    {
      title: "付款时间",
      width: 200,
      dataIndex: "created_at",
      render: (created_at: string) => <span>{dateFormat(created_at)}</span>,
    },
  ];

  return (
    <div className="float-left">
      <Table
        loading={loading}
        columns={columns}
        dataSource={list}
        rowKey={(record) => record.id}
        pagination={paginationProps}
      />
    </div>
  );
};
