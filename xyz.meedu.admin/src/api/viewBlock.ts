import client from "./internal/httpClient";

export function list(params: any) {
  return client.get(`/backend/api/v1/viewBlock/index`, params);
}

export function create() {
  return client.get(`/backend/api/v1/viewBlock/create`, {});
}

export function store(params: any) {
  return client.post("/backend/api/v1/viewBlock/create", params);
}

export function detail(id: number) {
  return client.get(`/backend/api/v1/viewBlock/${id}`, {});
}

export function destroy(id: number) {
  return client.destroy(`/backend/api/v1/viewBlock/${id}`);
}

export function update(id: number, params: any) {
  return client.put(`/backend/api/v1/viewBlock/${id}`, params);
}
