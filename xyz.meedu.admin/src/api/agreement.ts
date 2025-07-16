import client from "./internal/httpClient";

// 协议列表
export function list(params: any) {
  return client.get("/backend/api/v1/agreement/index", params);
}

// 获取创建表单数据
export function createForm() {
  return client.get("/backend/api/v1/agreement/create", {});
}

// 创建协议
export function store(params: any) {
  return client.post("/backend/api/v1/agreement/create", params);
}

// 获取协议详情
export function detail(id: number) {
  return client.get(`/backend/api/v1/agreement/${id}`, {});
}

// 更新协议
export function update(id: number, params: any) {
  return client.put(`/backend/api/v1/agreement/${id}`, params);
}

// 删除协议
export function destroy(id: number) {
  return client.destroy(`/backend/api/v1/agreement/${id}`);
}

// 协议同意记录
export function records(id: number, params: any) {
  return client.get(`/backend/api/v1/agreement/${id}/records`, params);
} 