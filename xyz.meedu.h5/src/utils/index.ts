import moment from "moment";
declare const window: any;

export function getToken(): string {
  return window.localStorage.getItem("meedu-h5-token") || "";
}

export function setToken(token: string) {
  window.localStorage.setItem("meedu-h5-token", token);
}

export function clearToken() {
  window.localStorage.removeItem("meedu-h5-token");
}

export function getTmpToken(): string {
  return window.localStorage.getItem("meedu-h5-tmp-token") || "";
}

export function saveTmpToken(token: string) {
  window.localStorage.setItem("meedu-h5-tmp-token", token);
}

export function clearTmpToken() {
  window.localStorage.removeItem("meedu-h5-tmp-token");
}

export function getMsv(): string {
  return window.localStorage.getItem("meedu-msv") || "";
}

export function saveMsv(msv: string) {
  window.localStorage.setItem("meedu-msv", msv);
}

export function clearMsv() {
  window.localStorage.removeItem("meedu-msv");
}

export function getBizToken() {
  return window.localStorage.getItem("meedu-user-face-bizToken");
}

export function saveBizToken(token: string) {
  window.localStorage.setItem("meedu-user-face-bizToken", token);
}

export function clearBizToken() {
  window.localStorage.removeItem("meedu-user-face-bizToken");
}

export function getRuleId() {
  return window.localStorage.getItem("meedu-user-face-ruleId");
}

export function saveRuleId(token: string) {
  window.localStorage.setItem("meedu-user-face-ruleId", token);
}

export function clearRuleId() {
  window.localStorage.removeItem("meedu-user-face-ruleId");
}

export function saveLoginCode(code: string) {
  window.localStorage.setItem("login_code", code);
}

export function getLoginCode() {
  return window.localStorage.getItem("login_code");
}

export function clearLoginCode() {
  window.localStorage.removeItem("login_code");
}

export function saveSessionLoginCode(code: string) {
  if (!code) {
    return;
  }
  window.sessionStorage.setItem("login_code:" + code, code);
}

export function getSessionLoginCode(code: string) {
  return window.sessionStorage.getItem("login_code:" + code);
}

export function clearSessionLoginCode(code: string) {
  return window.sessionStorage.removeItem("login_code:" + code);
}

export function getCommentTime(dateStr: string) {
  if (dateStr === "刚刚") {
    return "刚刚";
  }
  const interval = moment().diff(moment(dateStr), "seconds");
  if (interval < 60) {
    return "刚刚";
  } else if (interval < 60 * 60) {
    let tempTime = Math.floor(interval / 60);
    return `${tempTime}分钟前`;
  } else if (interval < 60 * 60 * 24) {
    let tempTime = Math.floor(interval / (60 * 60));
    return `${tempTime}小时前`;
  } else if (interval < 60 * 60 * 24 * 7) {
    let tempTime = Math.floor(interval / (60 * 60 * 24));
    return `${tempTime}天前`;
  } else if (interval < 60 * 60 * 24 * 365) {
    return moment(dateStr).utcOffset(0).format("MM-DD");
  } else {
    return moment(dateStr).utcOffset(0).format("YYYY-MM-DD");
  }
}

export function changeTime(dateStr: string) {
  const interval = moment().diff(moment(dateStr), "seconds");
  if (interval < 60) {
    return "刚刚";
  } else if (interval < 60 * 60) {
    let tempTime = Math.floor(interval / 60);
    return `${tempTime}分钟前`;
  } else if (interval < 60 * 60 * 24) {
    let tempTime = Math.floor(interval / (60 * 60));
    return `${tempTime}小时前`;
  } else if (interval < 60 * 60 * 24 * 7) {
    let tempTime = Math.floor(interval / (60 * 60 * 24));
    return `${tempTime}天前`;
  } else if (interval < 60 * 60 * 24 * 365) {
    return moment(dateStr).utcOffset(0).format("MM-DD HH:mm");
  } else {
    return moment(dateStr).utcOffset(0).format("YYYY-MM-DD HH:mm");
  }
}

export function dateFormat(dateStr: string) {
  return moment(dateStr).format("YYYY-MM-DD HH:mm");
}

export function generateUUID(): string {
  let guid = "";
  for (let i = 1; i <= 32; i++) {
    let n = Math.floor(Math.random() * 16.0).toString(16);
    guid += n;
    if (i === 8 || i === 12 || i === 16 || i === 20) guid += "-";
  }
  return guid;
}

export function transformBase64ToBlob(
  base64: string,
  mime: string,
  filename: string
): File {
  const arr = base64.split(",");
  const bstr = atob(arr[1]);
  let n = bstr.length;
  const u8arr = new Uint8Array(n);
  while (n--) {
    u8arr[n] = bstr.charCodeAt(n);
  }
  return new File([u8arr], filename, { type: mime });
}

export function getHost() {
  return window.location.protocol + "//" + window.location.host;
}

export function inStrArray(array: string[], value: string): boolean {
  for (let i = 0; i < array.length; i++) {
    if (array[i] === value) {
      return true;
    }
  }
  return false;
}

export function getAppUrl() {
  let host = window.location.protocol + "//" + window.location.host;
  let pathname = window.location.pathname;
  if (pathname && pathname !== "/") {
    host += pathname;
  }
  return host;
}

export function random(minNum: number, maxNum: number) {
  switch (arguments.length) {
    case 1:
      return Math.random() * minNum + 1, 10;
    case 2:
      return Math.random() * (maxNum - minNum + 1) + minNum, 10;
    default:
      return 0;
  }
}

export function getShareHost() {
  let hash = window.location.hash;

  if (hash.match("#")) {
    hash = "/#/";
  } else {
    hash = "/";
  }

  let host = window.location.protocol + "//" + window.location.host + hash;
  return host;
}

export function isMobile() {
  let flag = navigator.userAgent.match(
    /(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i
  );
  return flag;
}

export function isChinaMobilePhone(phone: string) {
  return /^[1][3,4,5,6,7,8,9][0-9]{9}$/.test(phone);
}

export function isWechatMini() {
  let ua = navigator.userAgent.toLowerCase();
  let isWeixin = ua.indexOf("micromessenger") != -1;
  if (isWeixin) {
    return true;
  } else {
    return false;
  }
}

export function isWechat() {
  let ua = window.navigator.userAgent.toLowerCase();
  return /micromessenger/.test(ua);
}

export function SPAUrlAppend(baseUrl: string, queryParams: any) {
  let parseBaseUrl = new URL(baseUrl);
  return (
    parseBaseUrl.protocol +
    "//" +
    parseBaseUrl.host +
    parseBaseUrl.pathname +
    "#/?" +
    (parseBaseUrl.search ? parseBaseUrl.search + "&" : "") +
    queryParams
  );
}

export function removeURLParameter(url: string, parameter: any) {
  const urlObj = new URL(url);
  const searchParams = new URLSearchParams(urlObj.search);

  // 删除指定的参数
  searchParams.delete(parameter);

  // 构建新的URL
  urlObj.search = searchParams.toString();

  return urlObj.toString();
}

export function copyright() {
  let outs = [];
  let fi = function () {
    return {
      msg: "",
      style: "",
    };
  };

  var oi = fi();
  oi.msg = "MeEdu - 在线教育培训解决方案";
  oi.style =
    "padding-top: 15px;padding-bottom:15px;line-height:30px;font-size:2rem;color:#3ca7fa";
  outs.push(oi);

  oi = fi();
  oi.msg =
    "\r\n官网：\nhttps://meedu.vip\r\n\r\nGitHub：\nhttps://github.com/qsnh/meedu\r\n\r\n使用手册：\nhttps://www.yuque.com/meedu/fvvkbf\r\n\r\n当前版本：v4.9.1\r\n";
  outs.push(oi);

  outs.map(function (x) {
    console.log("%c" + x.msg, x.style);
  });
}

export function removeTokenParams(url: string) {
  let parseUrl = new URL(url);
  let hash = parseUrl.hash;
  let querystring = hash.split("?");
  if (querystring.length <= 1) {
    return url;
  }

  let params = querystring[1].split("&");
  if (params.length === 0) {
    return url;
  }

  let data = [];
  for (let i = 0; i < params.length; i++) {
    if (
      params[i].indexOf("token=") === -1 &&
      params[i].indexOf("login_code=") === -1 &&
      params[i].indexOf("action=") === -1
    ) {
      data.push(params[i]);
    }
  }

  let newUrl =
    parseUrl.protocol +
    "//" +
    parseUrl.host +
    parseUrl.pathname +
    querystring[0];

  if (data.length > 0) {
    newUrl += "?" + data.join("&");
  }

  return newUrl;
}
