import styles from "./index.module.scss";
import { useSelector } from "react-redux";
import { course } from "../../../../api";
import { None } from "../../../../components";
import { isWechat } from "../../../../utils";
import { Toast } from "antd-mobile";
import { useNavigate } from "react-router-dom";
import icon from "../../../../assets/img/attach-icon.png";

interface PropsInterafce {
  cid: number;
  list: any[];
  isBuy: boolean;
}

export default function AttachBox(props: PropsInterafce) {
  const navigate = useNavigate();
  const isLogin = useSelector((state: any) => state.loginUser.value.isLogin);
  const systemConfig = useSelector((state: any) => state.systemConfig.value);
  const goLogin = () => {
    navigate(
      "/login?redirect=" +
        encodeURIComponent(window.location.pathname + window.location.search)
    );
  };
  const download = (id: number) => {
    if (!isLogin) {
      goLogin();
      return;
    }
    if (!props.isBuy) {
      Toast.show("请购买课程");
      return;
    }
    course.downloadAttachment(props.cid, id).then((res: any) => {
      let url = res.data.download_url;
      if (isWechat()) {
        const input = document.createElement("input");
        document.body.appendChild(input);
        input.setAttribute("value", url);
        input.select();
        if (document.execCommand("copy")) {
          document.execCommand("copy");
          Toast.show("链接已复制，请使用浏览器下载");
        }
        document.body.removeChild(input);
      } else {
        window.open(url);
      }
    });
  };

  return (
    <div className={styles["attach-box"]}>
      {props.list.length > 0 ? (
        <div className={styles["list-box"]}>
          {props.list.map((item: any) => (
            <div className={styles["item-comp"]} key={item.id}>
              <img className={styles["icon"]} src={icon} />
              <div className={styles["title"]}>{item.name}</div>
              <div className={styles["link"]} onClick={() => download(item.id)}>
                下载
              </div>
            </div>
          ))}
        </div>
      ) : (
        <None type="white" />
      )}
    </div>
  );
}
