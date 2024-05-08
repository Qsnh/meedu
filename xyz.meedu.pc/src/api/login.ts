import client from "./internal/httpClient";

export function passwordLogin(params: any) {
  return client.post("/api/v2/login/password", params);
}
export function smsLogin(params: any) {
  return client.post("/api/v2/login/mobile", params);
}

export function smsRegister(params: any) {
  return client.post(`/api/v2/register/sms`, params);
}

export function logout() {
  return client.post("/api/v2/logout", {});
}

export function codeLogin(params: any) {
  return client.post(`/api/v3/auth/login/code`, params);
}

export function passwordForget(params: any) {
  return client.post(`/api/v2/member/detail/password`, params);
}

export function destroyUser(params: any) {
  return client.post(`/api/v3/member/destroy`, params);
}

export function codeBind(params: any) {
  return client.post(`/api/v3/member/socialite/bindWithCode`, params);
}

export function codeBindMobile(params: any) {
  return client.post(`/api/v3/auth/register/withSocialite`, params);
}

export function noLoginPasswordForget(params: any) {
  return client.post("/api/v2/password/reset", params);
}
