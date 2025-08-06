import client from "./internal/httpClient";

export function checkOrderStatus(params: any) {
  return client.get(`/api/v2/order/status`, params);
}

export function createOrder(params: any) {
  return client.post("/api/v3/order", params);
}
