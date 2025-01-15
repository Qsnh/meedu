import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Radio, Modal, message } from "antd";
import { useSearchParams } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { system } from "../../../api";
import { AdminLogComp } from "./components/admin-log";
import { UserLoginLogComp } from "./components/user-login-log";
import { UploadImagesComp } from "./components/upload-images-log";
import { RunTimeLogComp } from "./components/runtime-log";
import { titleAction } from "../../../store/user/loginUserSlice";
import { PerButton } from "../../../components";
import { ExclamationCircleFilled } from "@ant-design/icons";
const { confirm } = Modal;

interface LocalSearchParamsInterface {
  page?: number;
  size?: number;
  tabActive?: string;
}

const SystemLogPage = () => {
  const dispatch = useDispatch();
  const [searchParams, setSearchParams] = useSearchParams({
    page: "1",
    size: "10",
    tabActive: "admin",
  });
  const tabActive = searchParams.get("tabActive") || "admin";

  const [loading, setLoading] = useState(false);
  const [tabTypes, setTabTypes] = useState<any>([]);
  const [refresh, setRefresh] = useState(false);
  const user = useSelector((state: any) => state.loginUser.value.user);

  useEffect(() => {
    document.title = "系统日志";
    dispatch(titleAction("系统日志"));
  }, []);

  useEffect(() => {
    let types = [];

    if (checkPermission("system.log.admin")) {
      types.push({
        name: "管理后台日志",
        key: "admin",
      });
    }
    if (checkPermission("system.log.userLogin")) {
      types.push({
        name: "学员登录日志",
        key: "user-login",
      });
    }
    if (checkPermission("system.log.uploadImages")) {
      types.push({
        name: "图片上传日志",
        key: "upload-image",
      });
    }
    if (checkPermission("system.log.runtime")) {
      types.push({
        name: "运行日志",
        key: "runtime",
      });
    }
    setTabTypes(types);
  }, [user]);

  const checkPermission = (val: string) => {
    return typeof user.permissions[val] !== "undefined";
  };

  const resetLocalSearchParams = (params: LocalSearchParamsInterface) => {
    setSearchParams(
      (prev) => {
        if (typeof params.tabActive !== "undefined") {
          prev.set("tabActive", params.tabActive);
        }
        if (typeof params.page !== "undefined") {
          prev.set("page", params.page + "");
        }
        if (typeof params.size !== "undefined") {
          prev.set("size", params.size + "");
        }
        return prev;
      },
      { replace: true }
    );
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
      .adminLogDestory(tabActive)
      .then((res: any) => {
        message.success("成功");
        setLoading(false);
        setRefresh(!refresh);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <div className="meedu-main-body">
      <div className="float-left">
        <Radio.Group
          size="large"
          defaultValue={tabActive}
          buttonStyle="solid"
          onChange={(e) => {
            resetLocalSearchParams({
              page: 1,
              size: 10,
              tabActive: e.target.value,
            });
          }}
        >
          {tabTypes.length > 0 &&
            tabTypes.map((item: any) => (
              <Radio.Button key={item.key} value={item.key}>
                {item.name}
              </Radio.Button>
            ))}
        </Radio.Group>
      </div>
      <div className="float-left">
        {tabActive !== "runtime" && (
          <PerButton
            type="danger"
            text="清空日志"
            class="mt-30"
            icon={null}
            p="system.log.delete"
            onClick={() => {
              destorymulti();
            }}
            disabled={null}
          />
        )}
      </div>
      <div className="float-left mt-30">
        {tabActive === "admin" && <AdminLogComp refresh={refresh} />}
        {tabActive === "user-login" && <UserLoginLogComp refresh={refresh} />}
        {tabActive === "upload-image" && <UploadImagesComp refresh={refresh} />}
        {tabActive === "runtime" && <RunTimeLogComp />}
      </div>
    </div>
  );
};

export default SystemLogPage;
