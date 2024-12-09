import React, { useState, useEffect, useRef } from "react";
import styles from "./index.module.scss";
import { Modal, Input, message, Select } from "antd";
import ReactQuill from "react-quill";
import { SelectImage } from "../../components";
import "react-quill/dist/quill.snow.css";

interface PropInterface {
  height: number;
  isFormula: boolean;
  defautValue: string;
  mode: string;
  setContent: (value: string) => void;
}

export const QuillEditor: React.FC<PropInterface> = (props) => {
  const { height, isFormula, defautValue, mode, setContent } = props;
  let refs: any = useRef(null);
  const [loading, setLoading] = useState(false);
  const [videoVisiable, setVideoVisiable] = useState(false);
  const [value, setValue] = useState("");
  const [showUploadImage, setShowUploadImage] = useState(false);
  const [videoIframe, setVideoIframe] = useState("");
  const [formulaVisible, setFormulaVisible] = useState(false);
  const [formulaType, setFormulaType] = useState(0);
  const [formulaValue, setFormulaValue] = useState("");
  const types = [
    {
      label: "单行公式",
      value: 0,
    },
    {
      label: "多行公式",
      value: 1,
    },
  ];
  const modules = React.useMemo(
    () => ({
      toolbar: {
        container:
          mode && mode === "remark"
            ? [
                ["bold", "italic", "underline", "strike"],
                ["blockquote", "code-block"],
                [{ list: "ordered" }, { list: "bullet" }],
                [{ size: ["small", false, "large", "huge"] }],
                [{ header: [1, 2, 3, 4, 5, 6, false] }],
                [{ color: [] }, { background: [] }],
              ]
            : [
                ["bold", "italic", "underline", "strike"],
                ["blockquote", "code-block"],
                [{ list: "ordered" }, { list: "bullet" }],
                [{ size: ["small", false, "large", "huge"] }],
                [{ header: [1, 2, 3, 4, 5, 6, false] }],
                [{ color: [] }, { background: [] }],
                [{ align: [] }],
                ["formula"],
                ["link", "video", "image"],
              ],
        handlers: {
          image: () => setShowUploadImage(true),
          video: () => setVideoVisiable(true),
          formula: () => setFormulaVisible(true),
        },
      },
      formula: isFormula,
    }),
    [isFormula, mode]
  );

  useEffect(() => {
    if (value) {
      let text = "";
      if (value !== "<p><br></p>") {
        text = value;
      }
      setContent(text);
    }
  }, [value]);

  useEffect(() => {
    if (defautValue) {
      setValue(defautValue);
    }
  }, [defautValue]);

  const importVideoIframe = () => {
    if (!/^<iframe.+<\/iframe>$/.test(videoIframe)) {
      setVideoIframe("");
      message.error("请输入正确的iframe链接");
      return;
    }
    const value = videoIframe
      .split(/<iframe.*?src="(.*?)".*?<\/iframe>/)
      .join(" ");
    let quill = refs?.current.getEditor();
    let length = quill.selection.savedRange.index || 0;
    quill.insertEmbed(length, "video", value);
    quill.setSelection(length + 1);
    setVideoVisiable(false);
    setVideoIframe("");
  };

  const confirmFormula = () => {
    if (!formulaValue) {
      setFormulaValue("");
      message.error("请输入公式");
      return;
    }
    let value = formulaValue;
    if (formulaType === 1) {
      value = "$$" + value + "$$";
    } else {
      value = "$" + value + "$";
    }
    let quill = refs?.current.getEditor();
    let length = quill.selection.savedRange.index || 0;
    quill.clipboard.dangerouslyPasteHTML(length, value);
    quill.setSelection(length + value.length + 1);
    setFormulaVisible(false);
    setFormulaType(0);
    setFormulaValue("");
  };

  return (
    <>
      <ReactQuill
        ref={refs}
        className="quill-editor-box"
        style={{ height: height }}
        theme="snow"
        value={value}
        onChange={setValue}
        modules={modules}
        placeholder="请输入内容..."
        readOnly={false}
      />
      <SelectImage
        open={showUploadImage}
        from={1}
        scene="editor"
        onCancel={() => setShowUploadImage(false)}
        onSelected={(url) => {
          let quill = refs?.current.getEditor();
          let length = quill.selection.savedRange.index || 0;
          quill.insertEmbed(length, "image", url);
          quill.setSelection(length + 1);
          setShowUploadImage(false);
        }}
      ></SelectImage>
      <Modal
        title="插入视频地址"
        centered
        onCancel={() => {
          setVideoVisiable(false);
        }}
        cancelText="取 消"
        okText="确 定"
        open={videoVisiable}
        width={960}
        maskClosable={false}
        onOk={() => {
          importVideoIframe();
        }}
      >
        <div
          className="text-center"
          style={{ marginTop: 30, marginBottom: 30 }}
        >
          <Input
            value={videoIframe}
            onChange={(e) => {
              setVideoIframe(e.target.value);
            }}
            allowClear
            style={{ width: "100%" }}
            placeholder="如：<iframe src=... ></iframe>"
          />
        </div>
      </Modal>
      <Modal
        title="插入公式"
        centered
        onCancel={() => {
          setFormulaVisible(false);
        }}
        cancelText="取 消"
        okText="确 定"
        open={formulaVisible}
        width={960}
        maskClosable={false}
        onOk={() => {
          confirmFormula();
        }}
      >
        <div style={{ marginTop: 30, marginBottom: 15 }}>
          <Select
            style={{ width: 300 }}
            value={formulaType}
            onChange={(e) => {
              setFormulaType(e);
            }}
            options={types}
          />
        </div>
        <div className="text-center" style={{ marginBottom: 30 }}>
          {formulaType === 0 && (
            <Input
              value={formulaValue}
              onChange={(e) => {
                setFormulaValue(e.target.value);
              }}
              allowClear
              style={{ width: "100%" }}
              placeholder="如：x^2+y^2+Dx+Ey+F=0"
            />
          )}
          {formulaType === 1 && (
            <Input.TextArea
              value={formulaValue}
              onChange={(e) => {
                setFormulaValue(e.target.value);
              }}
              rows={4}
              allowClear
              style={{ width: "100%", resize: "none" }}
              placeholder="如：x^2+y^2+Dx+Ey+F=0"
            />
          )}
        </div>
      </Modal>
    </>
  );
};
