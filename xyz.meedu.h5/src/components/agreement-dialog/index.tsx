import React, { useState } from "react";
import { useSelector } from "react-redux";
import styles from "./index.module.scss";
import { user } from "../../api";
import { Toast } from "antd-mobile";
import { RootState } from "../../store";
import { AppConfigInterface } from "../../store/system/systemConfigSlice";

interface PropInterface {
  title: string;
  confirmText: string;
  cancel: () => void;
  change: () => void;
  agreementStatus: {
    user_agreement_agreed: boolean;
    privacy_policy_agreed: boolean;
  };
}

export const AgreementDialog: React.FC<PropInterface> = ({
  title,
  confirmText,
  change,
  cancel,
  agreementStatus,
}) => {
  const [loading, setLoading] = useState(false);
  const config: AppConfigInterface = useSelector(
    (state: RootState) => state.systemConfig.value
  );

  const handleAgree = async () => {
    if (loading) return;

    setLoading(true);
    try {
      await user.AgreementAgree();
      change();
    } catch (error) {
      Toast.show("操作失败，请重试");
    } finally {
      setLoading(false);
    }
  };

  const openPage = (url: string) => {
    window.open(url);
  };

  // 根据协议状态生成提示内容
  const generateContent = () => {
    const needUserAgreement = !agreementStatus.user_agreement_agreed;
    const needPrivacyPolicy = !agreementStatus.privacy_policy_agreed;

    if (needUserAgreement && needPrivacyPolicy) {
      // 两个协议都需要同意
      return (
        <>
          您需要同意用户协议与隐私政策后才能使用本系统。如您不同意，我们只能为您提供浏览服务。您可阅读
          <span
            className={styles["link"]}
            onClick={(e) => {
              e.stopPropagation();
              openPage(config.user_protocol);
            }}
          >
            《用户协议》
          </span>
          和
          <span
            className={styles["link"]}
            onClick={(e) => {
              e.stopPropagation();
              openPage(config.user_private_protocol);
            }}
          >
            《隐私政策》
          </span>
          了解详细信息。如您同意，请点击同意开始接受我们的服务。
        </>
      );
    } else if (needUserAgreement) {
      // 只需要同意用户协议
      return (
        <>
          您需要同意用户协议后才能使用本系统。如您不同意，我们只能为您提供浏览服务。您可阅读
          <span
            className={styles["link"]}
            onClick={(e) => {
              e.stopPropagation();
              openPage(config.user_protocol);
            }}
          >
            《用户协议》
          </span>
          了解详细信息。如您同意，请点击同意开始接受我们的服务。
        </>
      );
    } else if (needPrivacyPolicy) {
      // 只需要同意隐私政策
      return (
        <>
          您需要同意隐私政策后才能使用本系统。如您不同意，我们只能为您提供浏览服务。您可阅读
          <span
            className={styles["link"]}
            onClick={(e) => {
              e.stopPropagation();
              openPage(config.user_private_protocol);
            }}
          >
            《隐私政策》
          </span>
          了解详细信息。如您同意，请点击同意开始接受我们的服务。
        </>
      );
    }
  };

  return (
    <div className={styles["mask"]}>
      <div className={styles["modal"]}>
        <div className={styles["body"]}>
          <div className={styles["top"]}>{title}</div>
          <div className={styles["item"]}>
            {generateContent()}
          </div>
        </div>
        <div className={styles["bottom"]}>
          <div className={styles["btn_cancel"]} onClick={cancel}>
            不同意
          </div>
          <div
            className={`${styles["btn_primary"]} ${
              loading ? styles["loading"] : ""
            }`}
            onClick={handleAgree}
          >
            {loading ? "处理中..." : confirmText}
          </div>
        </div>
      </div>
    </div>
  );
};
