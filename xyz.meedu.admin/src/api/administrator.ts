import client from "./internal/httpClient";

export function detail() {
  return client.get(`/backend/api/v1/user`, {});
}

export function changePassword(params: any) {
  return client.put(`/backend/api/v1/administrator/password`, params);
}
