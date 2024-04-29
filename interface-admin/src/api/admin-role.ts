import client from "./internal/httpClient";

export function adminRoleList(params: any) {
  return client.get("/backend/api/v1/administrator_role", params);
}

export function createAdminRole() {
  return client.get("/backend/api/v1/administrator_role/create", {});
}

export function storeAdminRole(params: any) {
  return client.post("/backend/api/v1/administrator_role", params);
}

export function adminRole(id: number) {
  return client.get(`/backend/api/v1/administrator_role/${id}`, {});
}

export function updateAdminRole(id: number, params: any) {
  return client.put(`/backend/api/v1/administrator_role/${id}`, params);
}

export function destroyAdminRole(id: number) {
  return client.destroy(`/backend/api/v1/administrator_role/${id}`);
}
