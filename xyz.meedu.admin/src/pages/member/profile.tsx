import { useState, useEffect } from "react";
import { Image } from "antd";
import { useParams, useNavigate } from "react-router-dom";
import styles from "./profile.module.scss";
import { useDispatch } from "react-redux";
import { member } from "../../api/index";
import { BackBartment } from "../../components";
import { titleAction } from "../../store/user/loginUserSlice";

const MemberProfilePage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const params = useParams();
  const [loading, setLoading] = useState<boolean>(false);
  const [user, setUser] = useState<any>({});

  useEffect(() => {
    document.title = "实名信息";
    dispatch(titleAction("实名信息"));
  }, []);

  useEffect(() => {
    getUser();
  }, [params.memberId]);

  const getUser = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    member
      .detail(Number(params.memberId))
      .then((res: any) => {
        setUser(res.data.data);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <div className={styles["user-main-body"]}>
      <div className="float-left bg-white br-15 p-30">
        <BackBartment title="实名信息" />
        <div className={styles["panel-info-box"]}>
          <div className={styles["panel-info-item"]}>
            真实姓名： {user.profile ? user.profile.real_name : ""}
          </div>
          <div className={styles["panel-info-item"]}>
            身份证号码： {user.profile ? user.profile.id_number : ""}
          </div>
        </div>
      </div>
      <div className="panel-box mt-30">
        <div className="panel-body">
          <div className="float-left mb-15 d-flex">
            <div className={styles["info-item"]}>
              <div className={styles["info-label"]}>认证照片：</div>
              <div className={styles["info-value"]}>
                {user.profile && user.profile.verify_image_url ? (
                  <Image
                    width={150}
                    height={200}
                    style={{ borderRadius: 8 }}
                    src={user.profile.verify_image_url}
                  ></Image>
                ) : (
                  <div className={styles["image"]}></div>
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default MemberProfilePage;
