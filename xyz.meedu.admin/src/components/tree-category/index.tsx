import { Tree } from "antd";
import { useState, useEffect } from "react";
import { videoCategory } from "../../api/index";
import type { DataNode, TreeProps } from "antd/es/tree";

interface Option {
  key: string | number;
  title: any;
  children?: Option[];
}

interface PropInterface {
  refresh: boolean;
  type: string;
  text: string;
  selected: any;
  onUpdate: (keys: any, title: any) => void;
}

export const TreeCategory = (props: PropInterface) => {
  const [treeData, setTreeData] = useState<any>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [selectKey, setSelectKey] = useState<number[]>([]);

  useEffect(() => {
    if (props.selected && props.selected.length > 0) {
      setSelectKey(props.selected);
    }
  }, [props.selected]);

  useEffect(() => {
    videoCategory.list().then((res: any) => {
      const categories: any[] = res.data.data;
      if (JSON.stringify(categories) !== "{}" && categories.length !== 0) {
        const new_arr: Option[] = checkArr(categories, 0);
        // new_arr.unshift({
        //   key: 0,
        //   title: <span className="tree-title-elli">未分类</span>,
        // });
        setTreeData(new_arr);
      } else {
        setTreeData([]);
      }
    });
  }, [props.refresh]);

  const checkArr = (categories: CategoriesBoxModel, id: number) => {
    const arr = [];
    for (let i = 0; i < categories[id].length; i++) {
      if (!categories[categories[id][i].id]) {
        let name = (
          <span className="tree-title-elli">{categories[id][i].name}</span>
        );
        arr.push({
          title: name,
          key: categories[id][i].id,
        });
      } else {
        let name = (
          <span className="tree-title-elli">{categories[id][i].name}</span>
        );
        const new_arr: Option[] = checkArr(categories, categories[id][i].id);
        arr.push({
          title: name,
          key: categories[id][i].id,
          children: new_arr,
        });
      }
    }
    return arr;
  };

  const onSelect = (selectedKeys: any, info: any) => {
    let label = "全部" + props.text;
    if (info) {
      label = info.node.title.props.children;
    }
    props.onUpdate(selectedKeys, label);
    setSelectKey(selectedKeys);
  };

  const onExpand = (selectedKeys: any, info: any) => {};

  const onDragEnter: TreeProps["onDragEnter"] = (info) => {
    console.log(info);
    // expandedKeys 需要受控时设置
    // setExpandedKeys(info.expandedKeys)
  };

  const onDrop: TreeProps["onDrop"] = (info) => {
    const dropKey = info.node.key;
    const dragKey = info.dragNode.key;
    const dropPos = info.node.pos.split("-");
    const dropPosition =
      info.dropPosition - Number(dropPos[dropPos.length - 1]);
    const loop = (
      data: DataNode[],
      key: React.Key,
      callback: (node: DataNode, i: number, data: DataNode[]) => void
    ) => {
      for (let i = 0; i < data.length; i++) {
        if (data[i].key === key) {
          return callback(data[i], i, data);
        }
        if (data[i].children) {
          loop(data[i].children!, key, callback);
        }
      }
    };
    const data = [...treeData];
    let isTop = false;

    for (let i = 0; i < data.length; i++) {
      if (data[i].key === dragKey) {
        isTop = true;
      }
    }

    // Find dragObject
    let dragObj: DataNode;
    loop(data, dragKey, (item, index, arr) => {
      arr.splice(index, 1);
      dragObj = item;
    });

    if (!info.dropToGap) {
      // Drop on the content
      loop(data, dropKey, (item) => {
        item.children = item.children || [];
        // where to insert 示例添加到头部，可以是随意位置
        item.children.unshift(dragObj);
      });
    } else if (
      ((info.node as any).props.children || []).length > 0 && // Has children
      (info.node as any).props.expanded && // Is expanded
      dropPosition === 1 // On the bottom gap
    ) {
      loop(data, dropKey, (item) => {
        item.children = item.children || [];
        // where to insert 示例添加到头部，可以是随意位置
        item.children.unshift(dragObj);
        // in previous version, we use item.children.push(dragObj) to insert the
        // item to the tail of the children
      });
    } else {
      let ar: DataNode[] = [];
      let i: number;
      loop(data, dropKey, (_item, index, arr) => {
        ar = arr;
        i = index;
      });
      if (dropPosition === -1) {
        ar.splice(i!, 0, dragObj!);
      } else {
        ar.splice(i! + 1, 0, dragObj!);
      }
    }
    setTreeData(data);
    submitDrop(isTop, data, dragKey);
  };

  const submitDrop = (isTop: boolean, data: any, key: any) => {
    let result = checkDropArr(data, key);
    if (result) {
      if (isTop) {
        videoCategory.dropSameClass(result.ids).then((res: any) => {
          console.log("ok");
        });
      } else {
        submitChildDrop(key, 0, result);
      }
    }
  };

  const submitChildDrop = (key: any, pid: any, ids: any) => {
    videoCategory.dropDiffClass(key, pid, ids.ids).then((res: any) => {
      console.log("ok");
    });
  };

  const checkDropArr = (data: any, key: any) => {
    let ids = [];
    let isSame = false;
    for (let i = 0; i < data.length; i++) {
      ids.push(data[i].key);
      if (data[i].key === key) {
        isSame = true;
      }
      if (data[i].children) {
        let res: any = checkDropArr(data[i].children, key);
        if (res) {
          submitChildDrop(key, data[i].key, res);
        }
      }
    }
    if (isSame) {
      return { key, ids };
    }
  };

  return (
    <div className="playedu-tree">
      <div
        className={
          selectKey.length === 0
            ? "mb-8 category-label active"
            : "mb-8 category-label"
        }
        onClick={() => {
          onSelect([], "");
        }}
      >
        <div className="j-b-flex">
          <span>全部{props.text}</span>
        </div>
      </div>
      <div
        className={
          selectKey.length > 0 && selectKey[0] === 0
            ? "mb-8 category-label active"
            : "mb-8 category-label"
        }
        onClick={() => {
          setSelectKey([0]);
          props.onUpdate([0], "未分类");
        }}
      >
        <div className="j-b-flex">
          <span>未分类</span>
        </div>
      </div>
      {treeData.length > 0 && (
        <>
          {props.type === "cate" && (
            <Tree
              selectedKeys={selectKey}
              onSelect={onSelect}
              treeData={treeData}
              draggable
              blockNode
              onDragEnter={onDragEnter}
              onDrop={onDrop}
            />
          )}
          {props.type === "select" && (
            <Tree
              onSelect={onSelect}
              selectedKeys={selectKey}
              onExpand={onExpand}
              treeData={treeData}
            />
          )}
        </>
      )}
    </div>
  );
};
