import client from "./internal/httpClient";

export function CreateOrder(params: any) {
  return client.post("/api/v3/order", params);
}
