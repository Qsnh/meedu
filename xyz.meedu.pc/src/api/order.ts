import client from "./internal/httpClient";

export function payments(params: any) {
  return client.get(`/api/v2/order/payments`, params);
}

export function promoCodeCheck(code: string) {
  return client.get("/api/v2/promoCode/" + code + "/check", {});
}

export function createCourseOrder(params: any) {
  return client.post("/api/v2/order/course", params);
}

export function createVideoOrder(params: any) {
  return client.post("/api/v2/order/video", params);
}

export function createRoleOrder(params: any) {
  return client.post("/api/v2/order/role", params);
}

export function checkOrderStatus(params: any) {
  return client.get(`/api/v2/order/status`, params);
}

export function payWechatScan(params: any) {
  return client.post("/api/v2/order/pay/wechatScan", params);
}

export function handPay(params: any) {
  return client.post("/api/v3/order/pay/handPay", params);
}
