import client from "./internal/httpClient";

export function list(params: any) {
  return client.get("/backend/api/v1/promoCode", params);
}

export function destroyMulti(params: any) {
  return client.post("/backend/api/v1/promoCode/delete/multi", params);
}

export function create(params: any) {
  return client.post("/backend/api/v1/promoCode", params);
}

export function createMulti(params: any) {
  return client.post("/backend/api/v1/promoCode/generator", params);
}

export function importCode(params: any) {
  return client.post("/backend/api/v1/promoCode/import", params);
}
