import client from "./internal/httpClient";

export function PromoCodeCheck(code: string) {
  return client.get("/api/v2/promoCode/" + code + "/check", {});
}

export function CreateOrder(params: any) {
  return client.post("/api/v3/order", params);
}
