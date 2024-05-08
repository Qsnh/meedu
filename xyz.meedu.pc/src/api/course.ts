import client from "./internal/httpClient";

export function list(params: any) {
  return client.get("/api/v2/courses", params);
}

// 录播课详情
export function detail(id: number) {
  return client.get(`/api/v2/course/${id}`, {});
}

export function comments(id: number) {
  return client.get(`/api/v2/course/${id}/comments`, {});
}

export function collect(id: number) {
  return client.get(`/api/v2/course/${id}/like`, {});
}

export function submitComment(id: number, params: any) {
  return client.post(`/api/v2/course/${id}/comment`, params);
}

export function video(id: number) {
  return client.get(`/api/v2/video/${id}`, {});
}

export function videoComments(id: number) {
  return client.get(`/api/v2/video/${id}/comments`, {});
}

export function submitVideoComment(id: number, params: any) {
  return client.post(`/api/v2/video/${id}/comment`, params);
}

// 获取播放地址
export function playInfo(id: number, params: any) {
  return client.get(`/api/v2/video/${id}/playinfo`, params);
}

// 记录学员观看时长
export function videoRecord(id: number, params: any) {
  return client.post(`/api/v2/video/${id}/record`, params);
}

export function categories() {
  return client.get("/api/v2/course_categories", {});
}
export function download(id: number, params: any) {
  return client.get(`/api/v2/course/attach/${id}/download`, params);
}
