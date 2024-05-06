import client from "./internal/httpClient";

export function Payments(params: any) {
  return client.get("/api/v2/order/payments", params);
}

export function PromoCodeCheck(code: string) {
  return client.get("/api/v2/promoCode/" + code + "/check", {});
}

export function CreateCourseOrder(params: any) {
  return client.post("/api/v2/order/course", params);
}

export function CreateVideoOrder(params: any) {
  return client.post("/api/v2/order/video", params);
}

export function CreateRoleOrder(params: any) {
  return client.post("/api/v2/order/role", params);
}

export function PayWechatScan(params: any) {
  return client.post("/api/v2/order/pay/wechatScan", params);
}

export function HandPay(params: any) {
  return client.post("/api/v3/order/pay/handPay", params);
}
