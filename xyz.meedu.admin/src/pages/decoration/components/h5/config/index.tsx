import React, { useState } from "react";
import styles from "./index.module.scss";
import { CodeSet } from "./code";
import { VodV1Set } from "./vod-v1";
import { GzhV1Set } from "./gzh-v1";
import { ImageGroupSet } from "./image-group";
import { SliderSet } from "./slider";
import { BlankSet } from "./blank";
import { GridNavSet } from "./grid-nav";

interface PropInterface {
  block: any;
  onUpdate: () => void;
}
export const ConfigSetting: React.FC<PropInterface> = ({ block, onUpdate }) => {
  const [loading, setLoading] = useState<boolean>(false);

  const update = () => {
    onUpdate();
  };

  return (
    <div className={styles["config-index-box"]}>
      {block.sign === "slider" && (
        <SliderSet block={block} onUpdate={() => update()}></SliderSet>
      )}
      {block.sign === "grid-nav" && (
        <GridNavSet block={block} onUpdate={() => update()}></GridNavSet>
      )}
      {(block.sign === "h5-vod-v1" || block.sign === "pc-vod-v1") && (
        <VodV1Set block={block} onUpdate={() => update()}></VodV1Set>
      )}
      {block.sign === "code" && (
        <CodeSet block={block} onUpdate={() => update()}></CodeSet>
      )}
      {block.sign === "blank" && (
        <BlankSet block={block} onUpdate={() => update()}></BlankSet>
      )}
      {block.sign === "image-group" && (
        <ImageGroupSet block={block} onUpdate={() => update()}></ImageGroupSet>
      )}
      {block.sign === "h5-gzh-v1" && (
        <GzhV1Set block={block} onUpdate={() => update()}></GzhV1Set>
      )}
    </div>
  );
};
