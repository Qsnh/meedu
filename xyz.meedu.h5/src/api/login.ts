import client from "./internal/httpClient";

export function SmsLogin(params: any) {
  return client.post("/api/v2/login/mobile", params);
}

export function PasswordLogin(params: any) {
  return client.post("/api/v2/login/password", params);
}

export function WechatMiniLogin(params: any) {
  return client.post("/api/v2/wechat/mini/login", params);
}

export function WechatMiniLoginState(params: any) {
  return client.post("/api/v2/login/wechatMini", params);
}

export function WechatMiniLoginMobile(params: any) {
  return client.post("/api/v2/login/wechatMiniMobile", params);
}

export function CodeLogin(params: any) {
  return client.post(`/api/v3/auth/login/code`, params);
}

export function CodeBind(params: any) {
  return client.post(`/api/v3/member/socialite/bindWithCode`, params);
}

export function DestroyUser(params: any) {
  return client.post(`/api/v3/member/destroy`, params);
}
