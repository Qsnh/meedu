import { useState, useEffect } from "react";
import { Toast } from "antd-mobile";
import styles from "./index.module.scss";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { user as member } from "../../api/index";
import {
  getRuleId,
  getBizToken,
  clearBizToken,
  clearRuleId,
} from "../../utils/index";
import { loginAction } from "../../store/user/loginUserSlice";
import icon from "../../assets/img/icon-back.png";
import successIcon from "../../assets/img/faceSuccess.png";

const FaceSuccessPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [status, setStatus] = useState("");
  const [checkSuccess, setCheckSuccess] = useState(false);
  const user = useSelector((state: any) => state.loginUser.value.user);

  useEffect(() => {
    if (getRuleId() && getBizToken()) {
      setStatus("face-check");
      getData(getRuleId(), getBizToken());
    }
    if (user.is_face_verify) {
      setCheckSuccess(true);
    }
  }, [user]);

  const getData = (ruleId: string, bizToken: string) => {
    member
      .TecentFaceVerifyQuery({
        biz_token: bizToken,
        rule_id: ruleId,
      })
      .then((res: any) => {
        if (res.data.status === 9) {
          getUser();
        }
      });
  };

  const getUser = () => {
    member.detail().then((res: any) => {
      dispatch(loginAction(res.data));
      Toast.show("实名认证成功");
      setCheckSuccess(true);
      clearBizToken();
      clearRuleId();
      setLoading(true);
    });
  };

  return (
    <div className={styles["face-success-box"]}>
      <div className="navheader borderbox">
        <img
          className="back"
          onClick={() => {
            if (status === "face-check") {
              navigate("/", { replace: true });
            } else {
              navigate(-1);
            }
          }}
          src={icon}
        />
      </div>
      {checkSuccess ? (
        <>
          <div className={styles["icon"]}>
            <img src={successIcon} />
          </div>
          <div className={styles["profile"]}>
            <div className={styles["profile-item"]}>
              <span className={styles["label"]}>姓名</span>
              <span>{user.profile_real_name}</span>
            </div>
            <div className={styles["profile-item"]}>
              <span className={styles["label"]}>身份证号</span>
              <span>{user.profile_id_number}</span>
            </div>
          </div>
        </>
      ) : (
        <div className={styles["result"]}>正在查询实名认证结果</div>
      )}
      {loading && (
        <div className={styles["btn-box"]}>
          <div
            className={styles["button"]}
            onClick={() => {
              navigate("/", { replace: true });
            }}
          >
            返回首页
          </div>
        </div>
      )}
    </div>
  );
};

export default FaceSuccessPage;
