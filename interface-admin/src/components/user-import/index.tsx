import React, { useState, useEffect } from "react";
import { Modal, message, Upload, Button } from "antd";
import styles from "./index.module.scss";
import { course } from "../../api/index";
import * as XLSX from "xlsx";

interface PropInterface {
  id: number;
  type: string;
  open: boolean;
  name: string;
  onCancel: () => void;
  onSuccess: () => void;
}

export const UserImportDialog: React.FC<PropInterface> = ({
  id,
  type,
  open,
  name,
  onCancel,
  onSuccess,
}) => {
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {}, [open]);

  const mode = () => {
    var array = [["手机号"]];
    if (type === "cert") {
      array = [["证书编号", "手机号"]];
    }
    var sheet = XLSX.utils.aoa_to_sheet(array);
    var blob = sheet2blob(sheet, name || "学员批量导入模板");
    openDownloadXLSXDialog(blob, (name || "学员批量导入模板") + ".xlsx");
  };

  const sheet2blob = (sheet: any, sheetName: string) => {
    //将文件转换为二进制文件
    sheetName = sheetName || "sheet1";
    var workbook: any = {
      SheetNames: [sheetName],
      Sheets: {},
    };
    workbook.Sheets[sheetName] = sheet;
    // 生成excel的配置项
    var wopts: any = {
      bookType: "xlsx", // 要生成的文件类型
      bookSST: false, // 是否生成Shared String Table，官方解释是，如果开启生成速度会下降，但在低版本IOS设备上有更好的兼容性
      type: "binary",
    };
    var wbout = XLSX.write(workbook, wopts);
    var blob = new Blob([s2ab(wbout)], { type: "application/octet-stream" });
    // 字符串转ArrayBuffer
    function s2ab(s: any) {
      var buf = new ArrayBuffer(s.length);
      var view = new Uint8Array(buf);
      for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xff;
      return buf;
    }
    return blob;
  };

  const openDownloadXLSXDialog = (url: any, saveName: string) => {
    //下载模板文件
    if (typeof url == "object" && url instanceof Blob) {
      url = URL.createObjectURL(url); // 创建blob地址
    }

    var aLink = document.createElement("a");
    aLink.href = url;
    aLink.download = saveName || ""; // HTML5新增的属性，指定保存文件名，可以不要后缀，注意，file:///模式下不会生效
    var event;
    if (window.MouseEvent) event = new MouseEvent("click");
    else {
      event = document.createEvent("MouseEvents");
      event.initMouseEvent(
        "click",
        true,
        false,
        window,
        0,
        0,
        0,
        0,
        0,
        false,
        false,
        false,
        false,
        0,
        null
      );
    }
    aLink.dispatchEvent(event);
  };

  const uploadProps = {
    accept: ".xls,.xlsx,application/vnd.ms-excel",
    beforeUpload: (file: any) => {
      if (loading) {
        return;
      }
      setLoading(true);
      const f = file;
      const reader = new FileReader();
      reader.onload = (e: any) => {
        const datas = e.target.result;
        const workbook = XLSX.read(datas, {
          type: "binary",
        });
        const first_worksheet = workbook.Sheets[workbook.SheetNames[0]];
        const jsonArr = XLSX.utils.sheet_to_json(first_worksheet, {
          header: 1,
        });
        handleImpotedJson(jsonArr, file);
      };
      reader.readAsBinaryString(f);
      return false;
    },
  };

  const handleImpotedJson = (jsonArr: any[], file: any) => {
    jsonArr.splice(0, 1); // 去掉表头[第一行规则描述,第二行表头名]
    let data: any[] = [];
    for (let i = 0; i < jsonArr.length; i++) {
      let tmpItem = jsonArr[i];
      if (typeof tmpItem === undefined) {
        break;
      }
      if (tmpItem.length === 0) {
        //空行
        continue;
      }
      let arr: any = [];
      if (type === "cert") {
        tmpItem.map((item: any) => {
          arr.push(item);
        });
        data.push(arr);
      } else {
        data.push(tmpItem[0]);
      }
    }

    if (type === "vod") {
      storeBatchTableCoursetData(data);
    }
  };

  const storeBatchTableCoursetData = (data: any) => {
    course
      .userImport(id, { mobiles: data })
      .then(() => {
        setLoading(false);
        message.success("导入成功！");
        onSuccess();
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <>
      {open ? (
        <Modal
          title=""
          centered
          forceRender
          open={true}
          width={900}
          onCancel={() => {
            onCancel();
          }}
          maskClosable={false}
          closable={false}
          footer={null}
        >
          <div className={styles["header"]}>学员批量导入</div>
          <div className={styles["body"]}>
            <div className="d-flex float-left">
              <div>
                <Upload {...uploadProps} showUploadList={false}>
                  <Button loading={loading} type="primary">
                    选择Excel表格文件
                  </Button>
                </Upload>
              </div>
              <div className="ml-30">
                <Button
                  type="link"
                  className="c-primary"
                  onClick={() => mode()}
                >
                  点击链接下载「{name || "学员批量导入模板"}」
                </Button>
              </div>
            </div>
          </div>
          <div
            slot="footer"
            style={{ display: "flex", flexDirection: "row-reverse" }}
          >
            <Button onClick={() => onCancel()}>取消</Button>
          </div>
        </Modal>
      ) : null}
    </>
  );
};
