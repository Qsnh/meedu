import { useState, useEffect } from "react";
import { message, Upload, Button } from "antd";
import { useNavigate } from "react-router-dom";
import { useDispatch } from "react-redux";
import { course } from "../../../api/index";
import * as XLSX from "xlsx";
import { titleAction } from "../../../store/user/loginUserSlice";
import { BackBartment } from "../../../components";
import { getUrl } from "../../../utils/index";

const CourseVideoImportPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);

  useEffect(() => {
    document.title = "课时批量导入";
    dispatch(titleAction("课时批量导入"));
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
    let data: any = [];
    jsonArr.forEach((item) => {
      let tmpItem = [];

      tmpItem[0] = item[0]; //课程名
      tmpItem[1] = item[1]; //章节名
      tmpItem[2] = item[2]; //视频名
      tmpItem[3] = parseInt(item[3] || 0); //视频时长
      tmpItem[4] = item[4]; //腾讯云视频id
      tmpItem[5] = item[5]; //URL直链
      tmpItem[6] = item[6]; //阿里云视频id
      tmpItem[7] = 0; //价格[已废弃字段,但是位置保留]
      tmpItem[8] = item[7] || ""; //上架时间
      tmpItem[9] = ""; //seo关键字
      tmpItem[10] = ""; //seo描述
      tmpItem[11] = parseInt(item[8] || 0); //试看秒数

      data.push(tmpItem);
    });
    storeBatchTableCertData(data);
  };

  const storeBatchTableCertData = (data: any) => {
    for (let i = 0; i < data.length; i++) {
      let tempItem: any = data[i];
      if (!tempItem[0]) {
        setLoading(false);
        message.error(`第${i + 2}行课程名为空`);
        return;
      }
      if (!tempItem[2]) {
        setLoading(false);
        message.error(`第${i + 2}行课时名称为空`);
        return;
      }
      if (tempItem[3] <= 0) {
        setLoading(false);
        message.error(`第${i + 2}行课时时长必须大于0`);
        return;
      }
      if (!tempItem[4] && !tempItem[5] && !tempItem[6]) {
        setLoading(false);
        message.error(
          `第${i + 2}行的腾讯云视频ID、阿里云视频ID、视频URL必须填写一个`
        );
        return;
      }
    }
    course
      .videoImportAct({ line: 3, data: data })
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
    let url = getUrl() + "/template/课时批量导入模板.xlsx";
    window.open(url);
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="课时批量导入" />
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
              下载「课时批量导入模板」
            </Button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CourseVideoImportPage;
