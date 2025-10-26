import { useState, useEffect } from "react";
import { Table, Button, Space, message } from "antd";
import { system } from "../../api";
import type { ColumnsType } from "antd/es/table";
import { ExclamationCircleFilled } from "@ant-design/icons";
import { BackBartment, PerButton } from "../../components";
import { NavsCreate } from "./components/pc/render-navs/create";
import { NavsUpdate } from "./components/pc/render-navs/update";
import { Modal } from "antd";
import { useDispatch } from "react-redux";
import { titleAction } from "../../store/user/loginUserSlice";

const { confirm } = Modal;

interface DataType {
  id: React.Key;
  charge: number;
}

const DecorationNavPage = () => {
  const dispatch = useDispatch();
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [showCreateWin, setShowCreateWin] = useState<boolean>(false);
  const [showEditWin, setShowEditWin] = useState<boolean>(false);
  const [updateId, setUpdateId] = useState(0);

  useEffect(() => {
    document.title = "导航管理";
    dispatch(titleAction("导航管理"));
    getData();
  }, []);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .navsList({
        platform: "PC",
      })
      .then((res: any) => {
        var data = res.data;
        const box = [];
        for (let i = 0; i < data.length; i++) {
          if (data[i].children.length === 0) {
            box.push({
              id: data[i].id,
              name: data[i].name,
              parent_id: data[i].parent_id,
              url: data[i].url,
              sort: data[i].sort,
              active_routes: data[i].active_routes,
              blank: data[i].blank,
              platform: data[i].platform,
            });
          } else {
            box.push({
              id: data[i].id,
              name: data[i].name,
              parent_id: data[i].parent_id,
              url: data[i].url,
              sort: data[i].sort,
              active_routes: data[i].active_routes,
              blank: data[i].blank,
              platform: data[i].platform,
              children: data[i].children,
            });
          }
        }
        setList(box);
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
      title: "导航名",
      render: (_, record: any) => <div>{record.name}</div>,
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
              p="nav.update"
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
              p="nav.destroy"
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
      content: "确认删除此导航？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        if (loading) {
          return;
        }
        setLoading(true);
        system
          .navsDestroy(id)
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
      <BackBartment title="导航管理" />
      <div className="float-left mt-30">
        <div className="float-left mb-15">
          <PerButton
            type="primary"
            text="添加"
            class=""
            icon={null}
            p="nav.store"
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
      <NavsCreate open={showCreateWin} onClose={() => closeEvt()} />
      <NavsUpdate open={showEditWin} id={updateId} onClose={() => closeEvt()} />
    </div>
  );
};

export default DecorationNavPage;
