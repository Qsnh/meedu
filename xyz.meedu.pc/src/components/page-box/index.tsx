import React, { useState, useEffect } from "react";

interface PropInterface {
  page: number;
  over: boolean;
  currentChange: (page: number) => void;
}

export const PageBox: React.FC<PropInterface> = ({
  page,
  over,
  currentChange,
}) => {
  const [currentPage, setCurrentPage] = useState(1);

  useEffect(() => {
    setCurrentPage(page);
  }, [page]);

  useEffect(() => {
    currentChange(currentPage);
  }, [currentPage]);

  const prePage = () => {
    let current = currentPage;
    if (current > 1) {
      current--;
      setCurrentPage(current);
    }
  };

  const nextPage = () => {
    if (over) {
      // message.error("没有更多了");
    } else {
      let current = currentPage;
      current++;
      setCurrentPage(current);
    }
  };

  return (
    <div className="page-wrapper clearfix">
      <div className="page-tab clearfix">
        <span className="fl h50">第{currentPage}页</span>
        {currentPage !== 1 && (
          <button
            style={{ backgroundColor: "#ffffff" }}
            className="fl h50 cursor"
            onClick={() => prePage()}
          >
            <span>上一页</span>
          </button>
        )}
        {!over && (
          <button
            style={{ backgroundColor: "#ffffff" }}
            className={"fl h50 cursor"}
            onClick={() => nextPage()}
          >
            <span>下一页</span>
          </button>
        )}
      </div>
    </div>
  );
};
