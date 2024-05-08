import { useState, useEffect } from "react";
import { Tabs } from "antd";
import { useDispatch } from "react-redux";
import { useParams } from "react-router-dom";
import { titleAction } from "../../store/user/loginUserSlice";
import { BackBartment } from "../../components";
import { WatchRecords } from "./components/watch-records";
import { SubUsers } from "./components/sub-users";

const CourseUsersPage = () => {
  const params = useParams();
  const dispatch = useDispatch();
  const [loading, setLoading] = useState<boolean>(false);
  const [resourceActive, setResourceActive] = useState<string>("watch-records");
  const avaliableResources = [
    {
      key: "watch-records",
      label: "学习记录",
    },
    {
      key: "sub-users",
      label: "付费学员",
    },
  ];

  useEffect(() => {
    document.title = "录播学员";
    dispatch(titleAction("录播学员"));
  }, []);

  const onChange = (key: string) => {
    setResourceActive(key);
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="录播学员" />
      <div className="float-left mt-30">
        <Tabs
          defaultActiveKey={resourceActive}
          items={avaliableResources}
          onChange={onChange}
        />
      </div>
      <div className="float-left">
        {resourceActive === "watch-records" && (
          <WatchRecords id={Number(params.courseId)}></WatchRecords>
        )}
        {resourceActive === "sub-users" && (
          <SubUsers id={Number(params.courseId)}></SubUsers>
        )}
      </div>
    </div>
  );
};

export default CourseUsersPage;
