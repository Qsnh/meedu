import { useState, useEffect } from "react";
import { Modal, message, Space, Button, Input, Select } from "antd";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { wechat } from "../../../api/index";
import { titleAction } from "../../../store/user/loginUserSlice";
import { PerButton, BackBartment } from "../../../components";
import { wechatUrlRules } from "../../../utils/index";
import { PlusOutlined, DeleteOutlined } from "@ant-design/icons";

const WechatMenuPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [loading, setLoading] = useState<boolean>(false);
  const [menus, setMenus] = useState<any>([]);
  const [currentIndex, setCurrentIndex] = useState<any>(null);
  const [currentPIndex, setCurrentPIndex] = useState<any>(null);
  const [currentItem, setCurrentItem] = useState<any>(null);
  const types = [
    {
      value: "view",
      label: "跳转网页",
    },
    {
      value: "click",
      label: "点击事件",
    },
    {
      value: "miniprogram",
      label: "打开小程序",
    },
  ];

  useEffect(() => {
    document.title = "公众号菜单";
    dispatch(titleAction("公众号菜单"));
  }, []);

  const getMenu = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    wechat
      .menuList()
      .then((res: any) => {
        let menu = res.data.menu;
        if (typeof menu.selfmenu_info === "undefined") {
          // 不是想要的数据
          return;
        }
        let arr: any = [];
        let data = menu.selfmenu_info.button;
        data.forEach((item: any) => {
          if (item.sub_button) {
            item.sub_button = item.sub_button.list;
          } else {
            item.sub_button = [];
          }
          arr.push(item);
        });

        setMenus(arr);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const addMenu = () => {
    let arr = [...menus];
    if (arr.length >= 3) {
      return;
    }
    arr.push({
      name: "未命名",
      type: null,
      sub_button: [],
    });
    setMenus(arr);
    reset();
  };

  const sync = () => {
    if (loading) {
      return;
    }
    if (menus.length == 0) {
      message.error("请编辑菜单");
      return;
    }
    // 必填检测
    for (let i = 0; i < menus.length; i++) {
      let line = i + 1;
      if (!menus[i].name) {
        message.error("第" + line + "个菜单的「菜单名」为空");
        setEditItem(i, null);
        return;
      }
      if (!menus[i].type) {
        message.error("第" + line + "个菜单的「类型」为空");
        setEditItem(i, null);
        return;
      }

      if (menus[i].type === "view") {
        if (!menus[i].url) {
          message.error("第" + line + "个菜单的「网址」为空");
          setEditItem(i, null);
          return;
        }
        if (wechatUrlRules(menus[i].url)) {
          message.error(
            "第" + line + "个菜单的「网址」错误，必须携带http://或https://协议"
          );
          setEditItem(i, null);
          return;
        }
      } else if (menus[i].type === "click") {
        if (!menus[i].key) {
          message.error("第" + line + "个菜单的「事件key」为空");
          setEditItem(i, null);
          return;
        }
      } else if (menus[i].type === "miniprogram") {
        if (!menus[i].appid) {
          message.error("第" + line + "个菜单的「小程序appid」为空");
          setEditItem(i, null);
          return;
        }
        if (!menus[i].pagepath) {
          message.error("第" + line + "个菜单的「小程序打开页面路径」为空");
          setEditItem(i, null);
          return;
        }
        if (!menus[i].url) {
          message.error("第" + line + "个菜单的「URL地址」为空");
          setEditItem(i, null);
          return;
        }
      }
      if (menus[i].sub_button === undefined) {
        // 无子菜单
        if (!menus[i].name) {
          message.error("第" + line + "个菜单的「菜单名」为空");
          setEditItem(i, null);
          return;
        }
        if (!menus[i].type) {
          message.error("第" + line + "个菜单的「类型」为空");
          setEditItem(i, null);
          return;
        }

        if (menus[i].type === "view") {
          if (!menus[i].url) {
            message.error("第" + line + "个菜单的「网址」为空");
            setEditItem(i, null);
            return;
          }
          if (wechatUrlRules(menus[i].url)) {
            message.error(
              "第" +
                line +
                "个菜单的「网址」错误，必须携带http://或https://协议"
            );
            setEditItem(i, null);
            return;
          }
        } else if (menus[i].type === "click") {
          if (!menus[i].key) {
            message.error("第" + line + "个菜单的「事件key」为空");
            setEditItem(i, null);
            return;
          }
        } else if (menus[i].type === "miniprogram") {
          if (!menus[i].appid) {
            message.error("第" + line + "个菜单的「小程序appid」为空");
            setEditItem(i, null);
            return;
          }
          if (!menus[i].pagepath) {
            message.error("第" + line + "个菜单的「小程序打开页面路径」为空");
            setEditItem(i, null);
            return;
          }
          if (!menus[i].url) {
            message.error("第" + line + "个菜单的「URL地址」为空");
            setEditItem(i, null);
            return;
          }
        }
        continue;
      }

      // 存在子菜单
      for (let j = 0; j < menus[i].sub_button.length; j++) {
        let cLine = j + 1;

        if (!menus[i].sub_button[j].name) {
          message.error(
            "第" + line + "个菜单的第" + cLine + "子菜单的「菜单名」为空"
          );
          setEditItem(i, j);
          return;
        }
        if (!menus[i].sub_button[j].type) {
          message.error(
            "第" + line + "个菜单的第" + cLine + "子菜单的「类型」为空"
          );
          setEditItem(i, j);
          return;
        }

        if (menus[i].sub_button[j].type === "view") {
          if (!menus[i].sub_button[j].url) {
            message.error(
              "第" + line + "个菜单的第" + cLine + "子菜单的「网址」为空"
            );
            setEditItem(i, j);
            return;
          }
          if (wechatUrlRules(menus[i].sub_button[j].url)) {
            message.error(
              "第" +
                line +
                "个菜单的第" +
                cLine +
                "子菜单的「网址」错误，必须携带http://或https://协议"
            );
            setEditItem(i, j);
            return;
          }
        } else if (menus[i].sub_button[j].type === "click") {
          if (!menus[i].sub_button[j].key) {
            message.error(
              "第" + line + "个菜单的第" + cLine + "子菜单的「事件key」为空"
            );
            setEditItem(i, j);
            return;
          }
        } else if (menus[i].sub_button[j].type === "miniprogram") {
          if (!menus[i].sub_button[j].appid) {
            message.error(
              "第" + line + "个菜单的第" + cLine + "子菜单的「小程序appid」为空"
            );
            setEditItem(i, j);
            return;
          }
          if (!menus[i].sub_button[j].pagepath) {
            message.error(
              "第" +
                line +
                "个菜单的第" +
                cLine +
                "子菜单的「小程序打开页面路径」为空"
            );
            setEditItem(i, j);
            return;
          }
          if (!menus[i].sub_button[j].url) {
            message.error(
              "第" + line + "个菜单的第" + cLine + "子菜单的「URL地址」为空"
            );
            setEditItem(i, j);
            return;
          }
        }
      }
    }
    setLoading(true);
    let menuData: any = [];
    menus.forEach((item: any) => {
      if (item.sub_button && item.sub_button.length === 0) {
        delete item.sub_button;
      }
      menuData.push(item);
    });
    wechat
      .menuUpdate({
        menu: {
          button: menuData,
        },
      })
      .then((res: any) => {
        message.success("成功");
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  const reset = () => {
    setCurrentIndex(null);
    setCurrentItem(null);
    setCurrentPIndex(null);
  };

  const addChildrenMenu = (index: number) => {
    let arr = [...menus];
    if (arr[index].sub_button) {
      arr[index].sub_button.push({
        name: "未命名",
        type: null,
      });
    } else {
      arr[index].sub_button = [];
      arr[index].sub_button.push({
        name: "未命名",
        type: null,
      });
    }
    setMenus(arr);
    reset();
  };

  const editMenuItem = (menuItem: any, index: number, pIndex: any) => {
    setCurrentIndex(index);
    setCurrentItem(menuItem);
    setCurrentPIndex(pIndex);
    console.log(pIndex);
  };

  const delMenuItem = () => {
    if (!currentItem) {
      return;
    }
    let arr = [...menus];
    if (currentPIndex === 0) {
      arr[currentIndex].sub_button = null;
    } else if (currentPIndex > 0) {
      arr[currentIndex].sub_button.splice(currentPIndex, 1);
    } else {
      arr.splice(currentIndex, 1);
    }
    setMenus(arr);
    reset();
  };

  const setEditItem = (index: number, cIndex: any) => {
    reset();
    if (cIndex !== null) {
      setCurrentIndex(index);
      setCurrentItem(menus[index].sub_button[cIndex]);
      setCurrentPIndex(cIndex);
    } else {
      setCurrentIndex(index);
      setCurrentItem(menus[index]);
      setCurrentPIndex(null);
    }
  };

  return (
    <div className="meedu-main-body">
      <BackBartment title="公众号菜单" />
      <div className="float-left mt-30">
        <h3>常见问题</h3>
        <div className="question-helper-text">
          1.菜单编辑之后需要点击「更新菜单」按钮将更改同步到微信公众号，这样才是一次正确的菜单更新操作。
        </div>
        <div className="question-helper-text">
          2.点击「更新菜单」按钮之后，已修改的公众号菜单并不是立马就可以看到，最多需要等待10分钟才会看到最新修改的菜单。
        </div>
        <div className="question-helper-text">
          3.自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。
        </div>
        <div className="question-helper-text">
          4.一级菜单最多4个汉字，二级菜单最多8个汉字，多出来的部分将会以“...”代替。
        </div>
      </div>
      <div className="float-left mt-15 mb-15">
        <Button type="primary" onClick={() => sync()}>
          将菜单更新到微信公众号
        </Button>
      </div>
      <div className="mp-menu-edit-box">
        <div className="menu-render-box">
          <div className="menus">
            {menus.length > 0 &&
              menus.map((item: any, index: number) => (
                <div className="menu-item" key={index}>
                  <span
                    onClick={() => {
                      editMenuItem(item, index, null);
                    }}
                  >
                    {item.name}
                  </span>
                  <div className="children-box">
                    {!item.sub_button ||
                      (item.sub_button.length < 5 && (
                        <div
                          className="children-menu-item"
                          onClick={() => addChildrenMenu(index)}
                        >
                          <PlusOutlined />
                        </div>
                      ))}
                    {item.sub_button &&
                      item.sub_button.length > 0 &&
                      item.sub_button.map(
                        (childrenItem: any, childrenIndex: number) => (
                          <div
                            key={childrenIndex}
                            className="children-menu-item"
                            onClick={() =>
                              editMenuItem(childrenItem, index, childrenIndex)
                            }
                          >
                            {childrenItem.name}
                          </div>
                        )
                      )}
                  </div>
                </div>
              ))}
            {menus.length < 3 && (
              <div className="menu-item" onClick={() => addMenu()}>
                <PlusOutlined />
              </div>
            )}
          </div>
        </div>
        {currentItem && (
          <div className="menu-edit-box">
            <div className="float-left mb-15">
              <div className="float-heft question-helper-text mb-10">
                菜单名 <span className="c-red">*</span>
              </div>
              <div className="float-left">
                <Input
                  value={currentItem.name}
                  onChange={(e) => {
                    let obj = { ...currentItem };
                    obj.name = e.target.value;
                    setCurrentItem(obj);
                    if (currentPIndex !== null) {
                      let arr = [...menus];
                      arr[currentIndex].sub_button[currentPIndex].name =
                        e.target.value;
                      setMenus(arr);
                    } else {
                      let arr = [...menus];
                      arr[currentIndex].name = e.target.value;
                      setMenus(arr);
                    }
                  }}
                  placeholder="菜单名"
                  className="w-300px"
                ></Input>
              </div>
            </div>
            <div className="float-left mb-15">
              <div className="float-heft question-helper-text mb-10">
                菜单类型
                <span className="c-red">*</span>
              </div>
              <div className="float-left">
                <Select
                  style={{ width: 300 }}
                  value={currentItem.type}
                  onChange={(e) => {
                    let obj = { ...currentItem };
                    obj.type = e;
                    setCurrentItem(obj);
                    if (currentPIndex !== null) {
                      let arr = [...menus];
                      arr[currentIndex].sub_button[currentPIndex].type = e;
                      setMenus(arr);
                    } else {
                      let arr = [...menus];
                      arr[currentIndex].type = e;
                      setMenus(arr);
                    }
                  }}
                  allowClear
                  placeholder="请选择菜单类型"
                  options={types}
                />
              </div>
            </div>
            {currentItem.type === "view" && (
              <div className="float-left mb-15">
                <div className="float-heft question-helper-text mb-10">
                  网址
                  {currentPIndex !== null && <span className="c-red">*</span>}
                </div>
                <div className="float-left">
                  <div className="d-flex">
                    <div>
                      <Input
                        value={currentItem.url}
                        onChange={(e) => {
                          let obj = { ...currentItem };
                          obj.url = e.target.value;
                          setCurrentItem(obj);
                          if (currentPIndex !== null) {
                            let arr = [...menus];
                            arr[currentIndex].sub_button[currentPIndex].url =
                              e.target.value;
                            setMenus(arr);
                          } else {
                            let arr = [...menus];
                            arr[currentIndex].url = e.target.value;
                            setMenus(arr);
                          }
                        }}
                        placeholder="请输入网址"
                        className="w-300px"
                      ></Input>
                    </div>
                    {currentItem.url && (
                      <div className="ml-10 c-red">
                        {wechatUrlRules(currentItem.url)}
                      </div>
                    )}
                  </div>
                </div>
              </div>
            )}
            {currentItem.type === "click" && (
              <div className="float-left mb-15">
                <div className="float-heft question-helper-text mb-10">
                  事件Key
                  {currentPIndex !== null && <span className="c-red">*</span>}
                </div>
                <div className="float-left">
                  <Input
                    value={currentItem.key}
                    onChange={(e) => {
                      let obj = { ...currentItem };
                      obj.key = e.target.value;
                      setCurrentItem(obj);
                      if (currentPIndex !== null) {
                        let arr = [...menus];
                        arr[currentIndex].sub_button[currentPIndex].key =
                          e.target.value;
                        setMenus(arr);
                      } else {
                        let arr = [...menus];
                        arr[currentIndex].key = e.target.value;
                        setMenus(arr);
                      }
                    }}
                    placeholder="请输入事件key"
                    className="w-300px"
                  ></Input>
                </div>
              </div>
            )}
            {currentItem.type === "miniprogram" && (
              <>
                <div className="float-left mb-15">
                  <div className="float-heft question-helper-text mb-10">
                    小程序AppId
                    {currentPIndex !== null && <span className="c-red">*</span>}
                  </div>
                  <div className="float-left">
                    <Input
                      value={currentItem.appid}
                      onChange={(e) => {
                        let obj = { ...currentItem };
                        obj.appid = e.target.value;
                        setCurrentItem(obj);
                        if (currentPIndex !== null) {
                          let arr = [...menus];
                          arr[currentIndex].sub_button[currentPIndex].appid =
                            e.target.value;
                          setMenus(arr);
                        } else {
                          let arr = [...menus];
                          arr[currentIndex].appid = e.target.value;
                          setMenus(arr);
                        }
                      }}
                      placeholder="小程序AppId"
                      className="w-300px"
                    ></Input>
                  </div>
                </div>
                <div className="float-left mb-15">
                  <div className="float-heft question-helper-text mb-10">
                    小程序打开页面路径
                    {currentPIndex !== null && <span className="c-red">*</span>}
                  </div>
                  <div className="float-left">
                    <Input
                      value={currentItem.pagepath}
                      onChange={(e) => {
                        let obj = { ...currentItem };
                        obj.pagepath = e.target.value;
                        setCurrentItem(obj);
                        if (currentPIndex !== null) {
                          let arr = [...menus];
                          arr[currentIndex].sub_button[currentPIndex].pagepath =
                            e.target.value;
                          setMenus(arr);
                        } else {
                          let arr = [...menus];
                          arr[currentIndex].pagepath = e.target.value;
                          setMenus(arr);
                        }
                      }}
                      placeholder="小程序打开页面路径"
                      className="w-300px"
                    ></Input>
                  </div>
                </div>
                <div className="float-left mb-15">
                  <div className="float-heft question-helper-text mb-10">
                    URL地址
                    {currentPIndex !== null && <span className="c-red">*</span>}
                  </div>
                  <div className="float-left">
                    <div className="mb-10">
                      <Input
                        value={currentItem.url}
                        onChange={(e) => {
                          let obj = { ...currentItem };
                          obj.url = e.target.value;
                          setCurrentItem(obj);
                          if (currentPIndex !== null) {
                            let arr = [...menus];
                            arr[currentIndex].sub_button[currentPIndex].url =
                              e.target.value;
                            setMenus(arr);
                          } else {
                            let arr = [...menus];
                            arr[currentIndex].url = e.target.value;
                            setMenus(arr);
                          }
                        }}
                        placeholder="URL地址"
                        className="w-300px"
                      ></Input>
                    </div>
                    <div>
                      <span className="question-helper-text">
                        不支持打开小程序的老版客户端将会打开该地址
                      </span>
                    </div>
                  </div>
                </div>
              </>
            )}
            <div className="float-left">
              <Button type="primary" danger onClick={() => delMenuItem()}>
                <DeleteOutlined />
              </Button>
            </div>
          </div>
        )}
      </div>
    </div>
  );
};

export default WechatMenuPage;
