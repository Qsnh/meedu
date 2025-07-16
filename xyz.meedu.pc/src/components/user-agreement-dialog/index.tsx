import React, { useState } from "react";
import { Modal, Button, Space } from "antd";
import { useDispatch, useSelector } from "react-redux";
import { logoutAction } from "../../store/user/loginUserSlice";
import { user } from "../../api/index";
import styles from "./index.module.scss";

interface PropInterface {
  open: boolean;
  onAgree: () => void;
  userAgreementAgreed?: boolean;
  privacyPolicyAgreed?: boolean;
}

export const UserAgreementDialog: React.FC<PropInterface> = ({
  open,
  onAgree,
  userAgreementAgreed = false,
  privacyPolicyAgreed = false,
}) => {
  const dispatch = useDispatch();
  const config = useSelector((state: any) => state.systemConfig.value.config);
  const [loading, setLoading] = useState<boolean>(false);

  // 判断需要同意的协议
  const needUserAgreement = !userAgreementAgreed;
  const needPrivacyPolicy = !privacyPolicyAgreed;

  // 生成动态标题
  const getTitle = () => {
    if (needUserAgreement && needPrivacyPolicy) {
      return "用户协议与隐私政策提示";
    } else if (needUserAgreement) {
      return "用户协议提示";
    } else if (needPrivacyPolicy) {
      return "隐私政策提示";
    }
    return "协议提示";
  };

  // 生成动态内容
  const getContent = () => {
    if (needUserAgreement && needPrivacyPolicy) {
      return (
        <>
          您需要同意用户协议与隐私政策后才能使用本系统。如您不同意，我们将只能为您提供浏览服务。您可阅读
          <a
            href={config?.user_protocol}
            target="_blank"
            rel="noopener noreferrer"
            className={styles["link"]}
          >
            《用户协议》
          </a>
          和
          <a
            href={config?.user_private_protocol}
            target="_blank"
            rel="noopener noreferrer"
            className={styles["link"]}
          >
            《隐私政策》
          </a>
          了解详细信息。如您同意，请点击"同意"开始接受我们的服务。
        </>
      );
    } else if (needUserAgreement) {
      return (
        <>
          您需要同意用户协议后才能使用本系统。如您不同意，我们将只能为您提供浏览服务。您可阅读
          <a
            href={config?.user_protocol}
            target="_blank"
            rel="noopener noreferrer"
            className={styles["link"]}
          >
            《用户协议》
          </a>
          了解详细信息。如您同意，请点击"同意"开始接受我们的服务。
        </>
      );
    } else if (needPrivacyPolicy) {
      return (
        <>
          您需要同意隐私政策后才能使用本系统。如您不同意，我们将只能为您提供浏览服务。您可阅读
          <a
            href={config?.user_private_protocol}
            target="_blank"
            rel="noopener noreferrer"
            className={styles["link"]}
          >
            《隐私政策》
          </a>
          了解详细信息。如您同意，请点击"同意"开始接受我们的服务。
        </>
      );
    }
    return null;
  };

  const handleAgree = async () => {
    setLoading(true);
    try {
      // 只更新需要同意的协议
      const updateParams: any = {};
      if (needUserAgreement) {
        updateParams.user_agreement_agreed = true;
      }
      if (needPrivacyPolicy) {
        updateParams.privacy_policy_agreed = true;
      }

      await user.updateAgreementStatus(updateParams);
      onAgree();
    } catch (error) {
      console.error("更新协议状态失败", error);
    } finally {
      setLoading(false);
    }
  };

  const handleDisagree = () => {
    // 用户不同意，执行登出操作
    dispatch(logoutAction());
  };

  return (
    <Modal
      title={getTitle()}
      open={open}
      footer={null}
      closable={false}
      maskClosable={false}
      width={600}
      className={styles["user-agreement-dialog"]}
    >
      <div className={styles["content"]}>
        <p className={styles["text"]}>{getContent()}</p>
      </div>
      <div className={styles["footer"]}>
        <Space>
          <Button onClick={handleDisagree} size="large">
            不同意
          </Button>
          <Button
            type="primary"
            onClick={handleAgree}
            loading={loading}
            size="large"
          >
            同意
          </Button>
        </Space>
      </div>
    </Modal>
  );
};
