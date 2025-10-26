import client from "./internal/httpClient";

export function list(params: any) {
  return client.get(`/backend/api/v1/decoration-page`, params);
}

export function store(params: any) {
  return client.post("/backend/api/v1/decoration-page", params);
}

export function detail(id: number) {
  return client.get(`/backend/api/v1/decoration-page/${id}`, {});
}

export function update(id: number, params: any) {
  return client.put(`/backend/api/v1/decoration-page/${id}`, params);
}

export function destroy(id: number) {
  return client.destroy(`/backend/api/v1/decoration-page/${id}`);
}

export function setDefault(id: number) {
  return client.post(`/backend/api/v1/decoration-page/${id}/set-default`, {});
}

export function copy(id: number) {
  return client.post(`/backend/api/v1/decoration-page/${id}/copy`, {});
}
