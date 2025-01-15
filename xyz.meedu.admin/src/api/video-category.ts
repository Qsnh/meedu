import client from "./internal/httpClient";

export function list() {
  return client.get("/backend/api/v1/media/video-category/index", {});
}

export function create() {
  return client.get("/backend/api/v1/media/video-category/create", {});
}

export function store(params: any) {
  return client.post("/backend/api/v1/media/video-category/create", params);
}

export function detail(id: number) {
  return client.get(`backend/api/v1/media/video-category/${id}`, {});
}

export function update(id: number, params: any) {
  return client.put(`backend/api/v1/media/video-category/${id}`, params);
}

export function destroy(id: number) {
  return client.destroy(`backend/api/v1/media/video-category/${id}`);
}

export function dropSameClass(ids: number[]) {
  return client.put(`/backend/api/v1/media/video-category/change-sort`, {
    ids: ids,
  });
}

export function dropDiffClass(id: number, parent_id: number, ids: number[]) {
  return client.put(`/backend/api/v1/media/video-category/change-parent`, {
    id: id,
    parent_id: parent_id,
    ids: ids,
  });
}

export function videoUpdate(params: any) {
  return client.post(`backend/api/v1/media/videos/change-category`, params);
}
