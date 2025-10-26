import { useState, useEffect } from "react";
import { Table, Button, Space, message, Modal } from "antd";
import { system } from "../../api";
import type { ColumnsType } from "antd/es/table";
import { ExclamationCircleFilled } from "@ant-design/icons";
import { BackBartment, PerButton } from "../../components";
import { LinksCreate } from "./components/pc/render-links/create";
import { LinksUpdate } from "./components/pc/render-links/update";
import { useDispatch } from "react-redux";
import { titleAction } from "../../store/user/loginUserSlice";

const { confirm } = Modal;

interface DataType {
  id: React.Key;
  sort: number;
  name: string;
  url: string;
}

const DecorationLinksPage = () => {
  const dispatch = useDispatch();
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [showCreateWin, setShowCreateWin] = useState<boolean>(false);
  const [showEditWin, setShowEditWin] = useState<boolean>(false);
  const [updateId, setUpdateId] = useState(0);

  useEffect(() => {
    document.title = "友情链接";
    dispatch(titleAction("友情链接"));
    getData();
  }, []);

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
            <PerButton
              type="link"
              text="编辑"
              class="c-primary"
              icon={null}
              p="link.update"
              onClick={() => {
                setUpdateId(record.id);
                setShowEditWin(true);
              }}
              disabled={null}
            />
            <PerButton
              type="link"
              text="删除"
              class="c-red"
              icon={null}
              p="link.destroy"
              onClick={() => {
                destory(record.id);
              }}
              disabled={null}
            />
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
    <div className="meedu-main-body">
      <BackBartment title="友情链接" />
      <div className="float-left mt-30">
        <div className="float-left mb-15">
          <PerButton
            type="primary"
            text="添加"
            class=""
            icon={null}
            p="link.store"
            onClick={() => setShowCreateWin(true)}
            disabled={null}
          />
        </div>
        <Table
          loading={loading}
          columns={columns}
          dataSource={list}
          rowKey={(record) => record.id}
          pagination={false}
        />
      </div>
      <LinksCreate open={showCreateWin} onClose={() => closeEvt()} />
      <LinksUpdate
        open={showEditWin}
        id={updateId}
        onClose={() => closeEvt()}
      />
    </div>
  );
};

export default DecorationLinksPage;
