import React from "react";
import styles from "./index.module.scss";
import { SliderSet } from "./slider";
import { CodeSet } from "../../h5/config/code";
import { VodV1Set } from "../../h5/config/vod-v1";
import { useHasPermission } from "../../../../../hooks/usePermission";
import { BACKEND_PERMISSIONS } from "../../../../../constants/backendPermissions";

interface PropInterface {
  block: any;
  onUpdate: () => void;
}

export const PCConfigSetting: React.FC<PropInterface> = ({
  block,
  onUpdate,
}) => {
  const canEditCodeBlock = useHasPermission(
    BACKEND_PERMISSIONS.DECORATION_CODE_BLOCK_EDIT
  );

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
