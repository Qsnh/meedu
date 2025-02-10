import client from "./internal/httpClient";

export function config() {
  return client.get("/api/v2/other/config", {});
}

export function imageCaptcha() {
  return client.get("/api/v2/captcha/image", {});
}

export function sendSms(params: any) {
  return client.post("/api/v2/captcha/sms", params);
}

export function Jssdk(params: any) {
  return client.get("/api/v3/other/wechat-mp-jssdk", params);
}
