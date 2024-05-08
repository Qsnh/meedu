import { useState, useEffect } from "react";
import { message, Upload, Button } from "antd";
import { useNavigate } from "react-router-dom";
import { useDispatch } from "react-redux";
import { member } from "../../api/index";
import * as XLSX from "xlsx";
import { CloseCircleOutlined } from "@ant-design/icons";
import { titleAction } from "../../store/user/loginUserSlice";
import { BackBartment } from "../../components";
import { getUrl } from "../../utils/index";

const MemberImportPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    document.title = "学员批量导入";
    dispatch(titleAction("学员批量导入"));
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
        });
        handleImpotedJson(jsonArr, file);
      };
      reader.readAsBinaryString(f);
      return false;
    },
  };

  const handleImpotedJson = (jsonArr: any[], file: any) => {
    jsonArr.splice(0, 2); // 去掉表头[第一行规则描述,第二行表头名]
    let data: any[] = [];
    for (let i = 0; i < jsonArr.length; i++) {
      let tmpItem = jsonArr[i];
      if (tmpItem.length === 0) {
        //空行
        continue;
      }
      tmpItem.splice(4, 0, 0);
      data.push(tmpItem);
    }

    storeBatchTableCertData(data);
  };

  const storeBatchTableCertData = (data: any) => {
    member
      .userImport({ users: data })
      .then(() => {
        setLoading(false);
        message.success("导入成功！");
      })
      .catch((e) => {
        setLoading(false);
        // let config = {
        //   content: (
        //     <>
        //       <span className="mr-10">{e.message}</span>
        //       <CloseCircleOutlined onClick={() => message.destroy()} />
        //     </>
        //   ),
        //   duration: 0,
        // };
        // message.error(config);
      });
  };

  const download = () => {
    let url = getUrl() + "/template/学员批量导入模板.xlsx";
    window.open(url);
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="学员批量导入" />
      <div className="user-import-box">
        <div className="float-left d-flex mb-30x">
          <div>
            <Upload {...uploadProps} showUploadList={false}>
              <Button loading={loading} type="primary">
                导入表格
              </Button>
            </Upload>
          </div>
          <div className="ml-30">
            <Button
              type="link"
              className="c-primary"
              onClick={() => download()}
            >
              下载「学员批量导入模板」
            </Button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default MemberImportPage;
