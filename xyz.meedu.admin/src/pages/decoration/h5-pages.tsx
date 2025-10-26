import { useState, useEffect } from "react";
import { Table, Modal, message, Button, Space, Input, Form, Dropdown } from "antd";
import { useNavigate } from "react-router-dom";
import type { ColumnsType } from "antd/es/table";
import type { MenuProps } from "antd";
import { useDispatch, useSelector } from "react-redux";
import { decorationPage } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import { BackBartment, PerButton } from "../../components";
import { ExclamationCircleFilled, DownOutlined } from "@ant-design/icons";
import { dateFormat } from "../../utils/index";
const { confirm } = Modal;

interface DataType {
  id: React.Key;
  name: string;
  created_at: string;
  is_default: number;
}

const DecorationH5PagesPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [form] = Form.useForm();
  const user = useSelector((state: any) => state.loginUser.value.user);

  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [refresh, setRefresh] = useState(false);
  const [showCreateModal, setShowCreateModal] = useState(false);
  const [showEditModal, setShowEditModal] = useState(false);
  const [editId, setEditId] = useState<number>(0);

  useEffect(() => {
    document.title = "H5装修页面管理";
    dispatch(titleAction("H5装修页面管理"));
  }, []);

  useEffect(() => {
    getData();
  }, [refresh]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    decorationPage
      .list({ page_key: "h5-page-index" })
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
      title: "ID",
      width: 80,
      render: (_, record: any) => <span>{record.id}</span>,
    },
    {
      title: "页面名称",
      dataIndex: "name",
      render: (name: string) => <span>{name}</span>,
    },
    {
      title: "创建时间",
      dataIndex: "created_at",
      width: 200,
      render: (created_at: string) => <span>{dateFormat(created_at)}</span>,
    },
    {
      title: "默认使用",
      width: 100,
      render: (_, record: any) => (
        <span>
          {record.is_default === 1 ? (
            <span className="c-green">是</span>
          ) : (
            <span className="c-gray">否</span>
          )}
        </span>
      ),
    },
    {
      title: "操作",
      width: 180,
      render: (_, record: any) => {
        const items: MenuProps["items"] = [
          {
            key: "1",
            label: (
              <PerButton
                type="link"
                text="重命名"
                class="c-primary"
                icon={null}
                p="decorationPage.update"
                onClick={() => {
                  showEdit(record.id, record.name);
                }}
                disabled={null}
              />
            ),
          },
          ...(record.is_default !== 1 ? [{
            key: "2",
            label: (
              <PerButton
                type="link"
                text="设为默认"
                class="c-primary"
                icon={null}
                p="decorationPage.setDefault"
                onClick={() => {
                  setDefault(record.id);
                }}
                disabled={null}
              />
            ),
          }] : []),
          {
            key: "3",
            label: (
              <PerButton
                type="link"
                text="复制"
                class="c-primary"
                icon={null}
                p="decorationPage.copy"
                onClick={() => {
                  copyPage(record.id);
                }}
                disabled={null}
              />
            ),
          },
          ...(record.is_default !== 1 ? [{
            key: "4",
            label: (
              <PerButton
                type="link"
                text="删除"
                class="c-red"
                icon={null}
                p="decorationPage.destroy"
                onClick={() => {
                  destroy(record.id);
                }}
                disabled={null}
              />
            ),
          }] : []),
        ];
        return (
          <Space>
            <PerButton
              type="link"
              text="装修"
              class="c-primary"
              icon={null}
              p="decorationPage.blocks"
              onClick={() => {
                navigate("/decoration/h5/editor?page_id=" + record.id);
              }}
              disabled={null}
            />
            <Dropdown menu={{ items }}>
              <Button
                type="link"
                className="c-primary"
                onClick={(e) => e.preventDefault()}
              >
                <Space size="small" align="center">
                  更多
                  <DownOutlined />
                </Space>
              </Button>
            </Dropdown>
          </Space>
        );
      },
    },
  ];

  const resetData = () => {
    setList([]);
    setRefresh(!refresh);
  };

  const showCreate = () => {
    form.resetFields();
    setShowCreateModal(true);
  };

  const handleCreateSubmit = () => {
    form.validateFields().then((values) => {
      if (loading) {
        return;
      }
      setLoading(true);
      decorationPage
        .store({
          name: values.name,
          page_key: "h5-page-index", // H5 页面使用固定的 page_key
        })
        .then(() => {
          setLoading(false);
          message.success("创建成功");
          setShowCreateModal(false);
          resetData();
        })
        .catch((e) => {
          setLoading(false);
        });
    });
  };

  const showEdit = (id: number, name: string) => {
    setEditId(id);
    form.setFieldsValue({ name });
    setShowEditModal(true);
  };

  const handleEditSubmit = () => {
    form.validateFields().then((values) => {
      if (loading) {
        return;
      }
      setLoading(true);
      decorationPage
        .update(editId, {
          name: values.name,
        })
        .then(() => {
          setLoading(false);
          message.success("更新成功");
          setShowEditModal(false);
          resetData();
        })
        .catch((e) => {
          setLoading(false);
        });
    });
  };

  const destroy = (id: number) => {
    if (id === 0) {
      return;
    }
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除此页面？删除后该页面的所有装修块也会被删除",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        decorationPage
          .destroy(id)
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

  const setDefault = (id: number) => {
    if (loading) {
      return;
    }
    setLoading(true);
    decorationPage
      .setDefault(id)
      .then(() => {
        setLoading(false);
        message.success("设置成功");
        resetData();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const copyPage = (id: number) => {
    if (loading) {
      return;
    }
    setLoading(true);
    decorationPage
      .copy(id)
      .then(() => {
        setLoading(false);
        message.success("复制成功");
        resetData();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="H5装修页面管理" />
      <div className="float-left  mt-30 mb-30">
        <PerButton
          type="primary"
          text="添加页面"
          class=""
          icon={null}
          p="decorationPage.store"
          onClick={() => showCreate()}
          disabled={null}
        />
      </div>
      <div className="float-left">
        <Table
          loading={loading}
          columns={columns}
          dataSource={list}
          rowKey={(record) => record.id}
          pagination={false}
        />
      </div>

      {/* 创建页面弹窗 */}
      <Modal
        title="添加页面"
        open={showCreateModal}
        onOk={handleCreateSubmit}
        onCancel={() => setShowCreateModal(false)}
        okText="确认"
        cancelText="取消"
        confirmLoading={loading}
      >
        <Form form={form} layout="vertical">
          <Form.Item
            label="页面名称"
            name="name"
            rules={[{ required: true, message: "请输入页面名称" }]}
          >
            <Input placeholder="请输入页面名称" />
          </Form.Item>
        </Form>
      </Modal>

      {/* 编辑页面弹窗 */}
      <Modal
        title="重命名页面"
        open={showEditModal}
        onOk={handleEditSubmit}
        onCancel={() => setShowEditModal(false)}
        okText="确认"
        cancelText="取消"
        confirmLoading={loading}
      >
        <Form form={form} layout="vertical">
          <Form.Item
            label="页面名称"
            name="name"
            rules={[{ required: true, message: "请输入页面名称" }]}
          >
            <Input placeholder="请输入页面名称" />
          </Form.Item>
        </Form>
      </Modal>
    </div>
  );
};

export default DecorationH5PagesPage;
