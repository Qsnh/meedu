import { useState, useEffect } from "react";
import { message, Upload, Button } from "antd";
import styles from "./import.module.scss";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { promocode } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import { BackBartment } from "../../components";
import * as XLSX from "xlsx";

const PromoCodeImportPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    document.title = "优惠码批量导入";
    dispatch(titleAction("优惠码批量导入"));
  }, []);

  const uploadProps = {
    accept: ".xls,.xlsx,application/vnd.ms-excel",
    beforeUpload: (file: any) => {
      const f = file;
      const reader = new FileReader();
      reader.onload = (e: any) => {
        const datas = new Uint8Array(e.target.result);
        const workbook = XLSX.read(datas, {
          type: "array",
          cellDates: true,
        });
        let parseData = handleImpotedJson(workbook);
        if (parseData.length === 0) {
          message.error("数据为空");
          return;
        }
        storeBatchTableData(parseData);
      };
      reader.readAsArrayBuffer(f);
      return false;
    },
  };

  const handleImpotedJson = (workbook: any) => {
    let data: any = [];
    workbook.SheetNames.forEach((sheetName: any) => {
      var roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {
        header: 1,
      });
      if (roa.length) {
        data.push(...roa);
      }
    });
    return data;
  };

  const storeBatchTableData = (data: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    promocode
      .importCode({ data: data })
      .then(() => {
        setLoading(false);
        message.success("导入成功！");
        navigate(-1);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="优惠码批量导入" />
      <div className={styles["user-import-box"]}>
        <div className="float-left d-flex mb-15">
          <div>
            <Upload {...uploadProps}>
              <Button type="primary">选择Excel表格文件</Button>
            </Upload>
          </div>
          <div className="ml-30">
            <Button
              type="link"
              onClick={() => {
                window.open("https://www.yuque.com/meedu/fvvkbf/lpwsry");
              }}
            >
              点击链接下载「优惠码批量导入模板」
            </Button>
          </div>
        </div>
      </div>
    </div>
  );
};
export default PromoCodeImportPage;
