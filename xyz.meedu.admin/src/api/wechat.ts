import client from "./internal/httpClient";

export function list() {
  return client.get("/backend/api/v1/mpWechatMessageReply", {});
}

export function create() {
  return client.get("/backend/api/v1/mpWechatMessageReply/create", {});
}

export function store(params: any) {
  return client.post("/backend/api/v1/mpWechatMessageReply", params);
}

export function detail(id: number) {
  return client.get(`/backend/api/v1/mpWechatMessageReply/${id}`, {});
}

export function update(id: number, params: any) {
  return client.put(`/backend/api/v1/mpWechatMessageReply/${id}`, params);
}

export function destroy(id: number) {
  return client.destroy(`/backend/api/v1/mpWechatMessageReply/${id}`);
}

export function menuList() {
  return client.get("/backend/api/v1/mpWechat/menu", {});
}

export function menuUpdate(params: any) {
  return client.put(`/backend/api/v1/mpWechat/menu`, params);
}

export function menuDestroy() {
  return client.destroy(`/backend/api/v1/mpWechat/menu`);
}
