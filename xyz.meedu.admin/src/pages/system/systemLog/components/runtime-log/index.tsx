import { useState, useEffect } from "react";
import { system } from "../../../../../api/index";

export const RunTimeLogComp = () => {
  const [loading, setLoading] = useState(false);
  const [list, setList] = useState<any[]>([]);

  useEffect(() => {
    getData();
  }, []);

  const getData = () => {
    if (loading) {
      return;
    }
    setLoading(true);
    system
      .runTimeLog()
      .then((res: any) => {
        let content: any[] = res.data.latest_content;
        if (content && content.length > 0) {
          if (content[0].length === 0) {
            content = content.splice(1);
          }
        }
        setList(content);
        setLoading(false);
      })
      .catch((e) => {
        setLoading(false);
      });
  };

  return (
    <div className="float-left">
      <pre
        style={{
          whiteSpace: "pre-wrap",
          backgroundColor: "rgba(0,0,0,0.05)",
          padding: "15px",
          borderRadius: "5px",
        }}
      >
        {list.join("\n")}
      </pre>
    </div>
  );
};
