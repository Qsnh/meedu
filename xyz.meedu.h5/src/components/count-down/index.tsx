import React, { useState, useEffect } from "react";

interface PropInterface {
  timestamp: number;
  type: string;
}

var timer: any = null;

export const CountDown: React.FC<PropInterface> = ({ timestamp, type }) => {
  const [endTime, setEndTime] = useState<number>(0);
  const [remainingTime, setRemainingTime] = useState<any>({
    day: 0,
    hr: 0,
    min: 0,
    sec: 0,
  });

  useEffect(() => {
    setEndTime(timestamp);
    countdown(timestamp);
    return () => {
      timer && clearInterval(timer);
    };
  }, [timestamp]);

  const countdown = (timestamp: number) => {
    let remaining: number = timestamp;
    timer = setInterval(() => {
      //防止出现负数
      if (remaining > 0) {
        remaining--;
        let day = Math.floor(remaining / 3600 / 24);
        let hour = Math.floor((remaining / 3600) % 24);
        let minute = Math.floor((remaining / 60) % 60);
        let second = Math.floor(remaining % 60);

        setRemainingTime({
          day: day,
          hr: hour < 10 ? "0" + hour : hour,
          min: minute < 10 ? "0" + minute : minute,
          sec: second < 10 ? "0" + second : second,
        });
      } else {
        clearInterval(timer);
      }
    }, 1000);
  };
  return (
    <>
      {remainingTime.day !== 0 && (
        <span>
          {remainingTime.day}天{remainingTime.hr}时{remainingTime.min}分
          {remainingTime.sec}秒
        </span>
      )}
      {type !== "face" &&
        remainingTime.day === 0 &&
        remainingTime.hr !== "00" && (
          <span>
            {remainingTime.hr}时{remainingTime.min}分{remainingTime.sec}秒
          </span>
        )}
      {type !== "face" &&
        remainingTime.day === 0 &&
        remainingTime.hr === "00" && (
          <span>
            {remainingTime.min}分{remainingTime.sec}秒
          </span>
        )}
      {type === "face" &&
        remainingTime.day === 0 &&
        remainingTime.hr === "00" &&
        remainingTime.min === "00" &&
        remainingTime.sec === "00" && <span>请刷新界面重试</span>}
    </>
  );
};
