import client from "./internal/httpClient";

export function list(params: any) {
  return client.get("/backend/api/v1/comment/index", params);
}

export function commentApplyMulti(params: any) {
  return client.post(`/backend/api/v1/comment/check`, params);
}

export function commentDestroy(params: any) {
  return client.post(`/backend/api/v1/comment/delete`, params);
}
