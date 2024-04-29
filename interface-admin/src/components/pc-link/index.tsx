import React, { useState, useEffect } from "react";
import { Radio, Button, Space, message, Switch } from "antd";
import { useSelector } from "react-redux";

interface PropInterface {
  open: boolean;
  defautValue: any;
  onClose: () => void;
  onChange: (value: any) => void;
}

export const PCLink: React.FC<PropInterface> = ({
  open,
  defautValue,
  onClose,
  onChange,
}) => {
  const [loading, setLoading] = useState<boolean>(false);
  const [funcLinks, setFuncLinks] = useState<any>([]);
  const [link, setLink] = useState<any>(null);
  const enabledAddons = useSelector(
    (state: any) => state.enabledAddonsConfig.value.enabledAddons
  );

  useEffect(() => {
    setLink(defautValue);
  }, [defautValue]);

  useEffect(() => {
    if (open && enabledAddons) {
      getParams();
    }
  }, [open, enabledAddons]);

  const getParams = () => {
    let links = [
      {
        name: "首页",
        url: "/",
        active: "index",
      },
      {
        name: "录播课",
        url: "/courses",
        active: "courses,course.show,video.show",
      },
    ];

    setFuncLinks(links);
  };

  const submit = () => {
    if (!link) {
      message.warning("请选择链接");
      return;
    }
    onChange(link);
  };

  return (
    <>
      {open && (
        <div className="meedu-dialog-mask">
          <div className="meedu-dialog-box">
            <div className="meedu-dialog-header">选择链接</div>
            <div className="meedu-dialog-body">
              <Radio.Group
                onChange={(e) => {
                  setLink(e.target.value);
                }}
                value={link}
              >
                {funcLinks.map((item: any, index: number) => (
                  <div className="func-link-item" key={index}>
                    <Radio value={item.url} checked={link === item.url}>
                      {item.name}
                    </Radio>
                  </div>
                ))}
              </Radio.Group>
            </div>
            <div className="meedu-dialog-footer">
              <Button type="primary" onClick={() => submit()}>
                确定
              </Button>
              <Button className="ml-10" onClick={() => onClose()}>
                取消
              </Button>
            </div>
          </div>
        </div>
      )}
    </>
  );
};
