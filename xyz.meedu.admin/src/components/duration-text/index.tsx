import { useEffect, useState } from "react";

interface PropInterface {
  duration: number;
}

export const DurationText = (props: PropInterface) => {
  const [hour, setHour] = useState(0);
  const [minute, setMinute] = useState(0);
  const [second, setSecond] = useState(0);

  useEffect(() => {
    if (props.duration > 0) {
      let h = Math.trunc(props.duration / 3600);
      let m = Math.trunc((props.duration % 3600) / 60);
      let s = Math.trunc((props.duration % 3600) % 60);

      setHour(h);
      setMinute(m);
      setSecond(s);
    }
  }, [props.duration]);

  return (
    <>
      <span>
        {hour === 0 ? null : hour + ":"}
        {minute >= 10 ? minute : "0" + minute}:
        {second >= 10 ? second : "0" + second}
      </span>
    </>
  );
};
