import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Table, Modal, message, Space } from "antd";
import type { ColumnsType } from "antd/es/table";
import { adminRole } from "../../../api/index";
import { useDispatch, useSelector } from "react-redux";
import { titleAction } from "../../../store/user/loginUserSlice";
import { BackBartment, PerButton } from "../../../components";
import { ExclamationCircleFilled } from "@ant-design/icons";
const { confirm } = Modal;

interface DataType {
  id: React.Key;
  display_name: string;
  slug: string;
}

const SystemAdminrolesPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [page, setPage] = useState(1);
  const [size, setSize] = useState(10);
  const [total, setTotal] = useState(0);
  const [refresh, setRefresh] = useState(false);
  const user = useSelector((state: any) => state.loginUser.value.user);

  useEffect(() => {
    document.title = "管理员角色";
    dispatch(titleAction("管理员角色"));
  }, []);

  useEffect(() => {
    getData();
  }, [page, size, refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    adminRole
      .adminRoleList({ page: page, size: size, sort: "id", order: "desc" })
      .then((res: any) => {
        setList(res.data.data);
        setTotal(res.data.total);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const resetData = () => {
    setPage(1);
    setList([]);
    setRefresh(!refresh);
  };

  const checkPermission = (val: string) => {
    return typeof user.permissions[val] !== "undefined";
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
      title: "ID",
      width: 120,
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "姓名",
      width: 120,
      dataIndex: "display_name",
      render: (display_name: string) => <span>{display_name}</span>,
    },
    {
      title: "描述",
      render: (_, record: any) => <span>{record.description}</span>,
    },
    {
      title: "操作",
      width: 130,
      render: (_, record: any) => (
        <Space>
          {record.slug !== "administrator" && (
            <>
              <PerButton
                type="link"
                text="编辑"
                class="c-primary"
                icon={null}
                p="administrator_role.update"
                onClick={() => {
                  navigate("/system/adminroles/update?id=" + record.id);
                }}
                disabled={null}
              />
              <PerButton
                type="link"
                text="删除"
                class="c-red"
                icon={null}
                p="administrator_role.destroy"
                onClick={() => {
                  destory(record.id);
                }}
                disabled={null}
              />
            </>
          )}
        </Space>
      ),
    },
  ];

  const destory = (id: number) => {
    if (id === 0) {
      return;
    }
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除此角色？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        adminRole
          .destroyAdminRole(id)
          .then(() => {
            setLoading(false);
            message.success("删除成功");
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

  return (
    <div className="meedu-main-body">
      <BackBartment title="管理员角色" />
      <div className="float-left mt-30">
        <PerButton
          type="primary"
          text="新建管理员角色"
          class=""
          icon={null}
          p="administrator_role.store"
          onClick={() => navigate("/system/adminroles/create")}
          disabled={null}
        />
      </div>
      <div className="float-left mt-30">
        <Table
          loading={loading}
          columns={columns}
          dataSource={list}
          rowKey={(record) => record.id}
          pagination={paginationProps}
        />
      </div>
    </div>
  );
};

export default SystemAdminrolesPage;
