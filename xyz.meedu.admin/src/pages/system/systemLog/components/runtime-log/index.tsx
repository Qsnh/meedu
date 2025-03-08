import { useState, useEffect } from "react";
import { Button, Modal, message } from "antd";
import { system } from "../../../../../api/index";
import { PerButton } from "../../../../../components";
import { ExclamationCircleFilled } from "@ant-design/icons";
const { confirm } = Modal;

export const RunTimeLogComp = () => {
  const [loading, setLoading] = useState(false);
  const [list, setList] = useState<any[]>([]);

  useEffect(() => {
    getData();
  }, []);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .runTimeLog()
      .then((res: any) => {
        let content: any[] = res.data.latest_content;
        if (content && content.length > 0) {
          if (content[0].length === 0) {
            content = content.splice(1);
          }
        }
        setList(content);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const destorymulti = () => {
    confirm({
      title: "操作确认",
      icon: <ExclamationCircleFilled />,
      content: "确认删除当前日志？",
      centered: true,
      okText: "确认",
      cancelText: "取消",
      onOk() {
        destoryConfirm();
      },
      onCancel() {
        console.log("Cancel");
      },
    });
  };

  const destoryConfirm = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .adminLogDestory("runtime")
      .then((res: any) => {
        message.success("成功");
        setLoading(false);
        getData();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <div className="float-left">
      <Button
        type="primary"
        onClick={() => {
          let element = document.createElement("a");
          element.setAttribute(
            "href",
            "data:text/plain;charset=utf-8," +
              encodeURIComponent(list.join("\n"))
          );
          element.setAttribute("download", "运行日志.txt");
          element.style.display = "none";
          document.body.appendChild(element);
          element.click();
          document.body.removeChild(element);
        }}
      >
        下载
      </Button>
      <PerButton
        type="danger"
        text="清空日志"
        class="ml-10"
        icon={null}
        p="system.audit.log.clear"
        onClick={() => {
          destorymulti();
        }}
        disabled={null}
      />
      <div className="float-left mt-30">
        <pre
          style={{
            boxSizing: "border-box",
            whiteSpace: "pre-wrap",
            backgroundColor: "rgba(0,0,0,0.05)",
            padding: "15px",
            borderRadius: "5px",
            overflowX: "auto",
            overflowY: "hidden",
            margin: 0,
          }}
        >
          {list.join("\n")}
        </pre>
      </div>
    </div>
  );
};
