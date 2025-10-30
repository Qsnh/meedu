import { useState, useEffect } from "react";
import { message, Upload, Button } from "antd";
import styles from "./import.module.scss";
import { useDispatch } from "react-redux";
import { promocode } from "../../api/index";
import { titleAction } from "../../store/user/loginUserSlice";
import { BackBartment } from "../../components";
import { getUrl } from "../../utils/index";
import * as XLSX from "xlsx";

const PromoCodeImportPage = () => {
  const dispatch = useDispatch();
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    document.title = "优惠码批量导入";
    dispatch(titleAction("优惠码批量导入"));
  }, []);

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
          raw: false, // 强制所有单元格作为字符串处理
        });
        handleImpotedJson(jsonArr, file);
      };
      reader.readAsBinaryString(f);
      return false;
    },
    showUploadList: false,
  };

  const handleImpotedJson = (jsonArr: any[], file: any) => {
    jsonArr.splice(0, 1); // 去掉表头[第一行字段名]
    let data: any[] = [];
    for (let i = 0; i < jsonArr.length; i++) {
      let tmpItem = jsonArr[i];
      if (tmpItem.length === 0) {
        //空行
        continue;
      }
      data.push(tmpItem);
    }

    storeBatchTableData(data);
  };

  const storeBatchTableData = (data: any) => {
    if (loading) {
      return;
    }
    setLoading(true);
    promocode
      .importCode({ data: data, line: 2 })
      .then(() => {
        setLoading(false);
        message.success("导入成功！");
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="优惠码批量导入" />
      <div className={styles["user-import-box"]}>
        <div className="float-left d-flex mb-30x">
          <div>
            <Upload {...uploadProps}>
              <Button loading={loading} type="primary">
                导入表格
              </Button>
            </Upload>
          </div>
          <div className="ml-30">
            <Button
              type="link"
              className="c-primary"
              onClick={() => {
                let url = getUrl() + "/template/promo_code_template.xlsx";
                window.open(url);
              }}
            >
              下载「优惠码批量导入模板」
            </Button>
          </div>
        </div>
      </div>
    </div>
  );
};
export default PromoCodeImportPage;
