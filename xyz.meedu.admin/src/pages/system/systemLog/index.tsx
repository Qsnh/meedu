import { useState, useEffect } from "react";
import styles from "./index.module.scss";
import { Radio } from "antd";
import { useSearchParams } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { AdminLogComp } from "./components/admin-log";
import { UserLoginLogComp } from "./components/user-login-log";
import { UploadImagesComp } from "./components/upload-images-log";
import { titleAction } from "../../../store/user/loginUserSlice";

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
        key: "userLogin",
      });
    }
    if (checkPermission("system.log.uploadImages")) {
      types.push({
        name: "图片上传日志",
        key: "uploadImages",
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
      <div className="float-left mt-30">
        {tabActive === "admin" && <AdminLogComp></AdminLogComp>}
        {tabActive === "userLogin" && <UserLoginLogComp></UserLoginLogComp>}
        {tabActive === "uploadImages" && <UploadImagesComp></UploadImagesComp>}
      </div>
    </div>
  );
};

export default SystemLogPage;
