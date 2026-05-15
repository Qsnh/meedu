import React from "react";
import { useSelector } from "react-redux";
import styles from "./index.module.scss";
import { SliderSet } from "./slider";
import { CodeSet } from "../../h5/config/code";
import { VodV1Set } from "../../h5/config/vod-v1";

interface PropInterface {
  block: any;
  onUpdate: () => void;
}

export const PCConfigSetting: React.FC<PropInterface> = ({
  block,
  onUpdate,
}) => {
  const user = useSelector((state: any) => state.loginUser.value.user);
  const canEditCodeBlock =
    !!user &&
    !!user.permissions &&
    typeof user.permissions["decorationPage.codeBlockEdit"] !== "undefined";

  const update = () => {
    onUpdate();
  };

  return (
    <div className={styles["config-index-box"]}>
      {block.sign === "pc-slider" && (
        <SliderSet block={block} onUpdate={() => update()} />
      )}
      {block.sign === "pc-vod-v1" && (
        <VodV1Set block={block} onUpdate={() => update()} />
      )}
      {block.sign === "code" && canEditCodeBlock && (
        <CodeSet block={block} onUpdate={() => update()} />
      )}
    </div>
  );
};
