import { useEffect, useState } from "react";
import { Modal, Table, Button } from "antd";
import type { ColumnsType } from "antd/es/table";
import { useSelector } from "react-redux";
import { course } from "../../../api/index";
import { DurationText } from "../../../components";

interface DataType {
  id: React.Key;
  duration: number;
  video_title: string;
}

interface PropsInterface {
  open: boolean;
  cid: number;
  uid: number;
  onCancel: () => void;
}

export const WatchRecordsDetailDialog = (props: PropsInterface) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [list, setList] = useState<any>([]);
  const [images, setImages] = useState<any>({});
  const [visiable, setVisiable] = useState<boolean>(false);
  const [vid, setVid] = useState(0);
  const enabledAddons = useSelector(
    (state: any) => state.enabledAddonsConfig.value.enabledAddons
  );

  useEffect(() => {
    setImages({});
    if (props.open && props.cid !== 0 && props.uid !== 0) {
      getData();
    }
  }, [props.open, props.cid, props.uid]);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    course
      .recordsDetail(props.cid, props.uid, {})
      .then((res: any) => {
        setList(res.data.data);
        setLoading(false);
        let arr: any = [];
        let data = res.data.data;
        if (data.length > 0) {
          data.map((item: any) => {
            arr.push(item.video_id);
          });
        }
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const columns: ColumnsType<DataType> = [
    {
      title: "标题",
      render: (_, record: any) => <span>{record.video_title}</span>,
    },
    {
      title: "进度",
      width: 300,
      render: (_, record: any) => (
        <>
          {record.watch_seconds > 0 && (
            <DurationText duration={record.watch_seconds}></DurationText>
          )}
          {record.watch_seconds <= 0 && <span>0:00</span>}/
          <DurationText duration={record.duration}></DurationText>
        </>
      ),
    },
    {
      title: "状态",
      width: 120,
      render: (_, record: any) => (
        <>
          {record.watch_seconds >= record.duration ? (
            <span className="c-green">已学完</span>
          ) : (
            <span>未学完</span>
          )}
        </>
      ),
    },
    enabledAddons["Snapshot"]
      ? {
          title: "已拍照片",
          width: 120,
          render: (_, record: any) => (
            <>
              {images[record.video_id] &&
              images[record.video_id].images.length > 0 ? (
                <Button
                  size="small"
                  className="c-primary"
                  type="link"
                  onClick={() => {
                    showDialog(record.video_id);
                  }}
                >
                  {images[record.video_id].images.length}
                </Button>
              ) : (
                <span>-</span>
              )}
            </>
          ),
        }
      : {},
  ];

  const showDialog = (id: number) => {
    setVid(id);
    setVisiable(true);
  };

  const hideDialog = () => {
    setVid(0);
    setVisiable(false);
    getData();
  };

  return (
    <>
      {props.open ? (
        <Modal
          title="学习进度"
          onCancel={() => {
            props.onCancel();
          }}
          open={true}
          width={1000}
          maskClosable={false}
          footer={null}
          centered
        >
          <div className="mt-30">
            <Table
              loading={loading}
              columns={columns}
              dataSource={list}
              rowKey={(record) => record.video_title + Math.random()}
              pagination={false}
            />
          </div>
        </Modal>
      ) : null}
    </>
  );
};
