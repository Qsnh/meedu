import client from "./internal/httpClient";

export function list() {
  return client.get("/backend/api/v1/role", {});
}

export function store(params: any) {
  return client.post("/backend/api/v1/role", params);
}

export function detail(id: number) {
  return client.get(`/backend/api/v1/role/${id}`, {});
}

export function update(id: number, params: any) {
  return client.put(`/backend/api/v1/role/${id}`, params);
}

export function destroy(id: number) {
  return client.destroy(`/backend/api/v1/role/${id}`);
}
