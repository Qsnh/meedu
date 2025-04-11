import styles from "./index.module.scss";
import { useSelector } from "react-redux";
import { course } from "../../../../api";
import { None } from "../../../../components";
import { isWechat, isQQ, isWechatWork, isSafari } from "../../../../utils";
import { Toast } from "antd-mobile";
import { useNavigate } from "react-router-dom";
import icon from "../../../../assets/img/attach-icon.png";
import { useState } from "react";

interface PropsInterafce {
  cid: number;
  list: any[];
  isBuy: boolean;
}

export default function AttachBox(props: PropsInterafce) {
  const navigate = useNavigate();
  const isLogin = useSelector((state: any) => state.loginUser.value.isLogin);
  const [showLinkModal, setShowLinkModal] = useState(false);
  const [currentUrl, setCurrentUrl] = useState("");

  const goLogin = () => {
    navigate(
      "/login?redirect=" +
        encodeURIComponent(window.location.pathname + window.location.search)
    );
  };

  const copyToClipboard = async (text: string) => {
    try {
      await navigator.clipboard.writeText(text);
      return true;
    } catch (err) {
      try {
        const input = document.createElement("input");
        input.style.position = "fixed";
        input.style.opacity = "0";
        document.body.appendChild(input);
        input.setAttribute("value", text);
        input.select();
        const success = document.execCommand("copy");
        document.body.removeChild(input);
        return success;
      } catch (err) {
        return false;
      }
    }
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
      const url = res.data.download_url;
      if (isWechat() || isQQ() || isWechatWork() || isSafari()) {
        if (isSafari()) {
          window.location.href = url;
          return;
        }
        copyToClipboard(url).then((success) => {
          if (success) {
            Toast.show("链接已复制，请使用浏览器下载");
          } else {
            setCurrentUrl(url);
            setShowLinkModal(true);
          }
        });
      } else {
        window.open(url);
      }
    });
  };

  const closeModal = () => {
    setShowLinkModal(false);
  };

  const manualCopy = () => {
    copyToClipboard(currentUrl).then((success) => {
      if (success) {
        Toast.show("链接已复制，请使用浏览器下载");
        closeModal();
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

      {showLinkModal && (
        <div className={styles["modal-mask"]} onClick={closeModal}>
          <div
            className={styles["modal-content"]}
            onClick={(e) => e.stopPropagation()}
          >
            <div className={styles["modal-header"]}>下载链接</div>
            <div className={styles["modal-body"]}>
              <div className={styles["url-display"]}>{currentUrl}</div>
              <div className={styles["modal-tip"]}>
                请长按上方链接选择复制，或点击下方按钮复制
              </div>
            </div>
            <div className={styles["modal-footer"]}>
              <button className={styles["cancel-btn"]} onClick={closeModal}>
                关闭
              </button>
              <button className={styles["copy-btn"]} onClick={manualCopy}>
                复制链接
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
