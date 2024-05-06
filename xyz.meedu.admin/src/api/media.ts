import client from "./internal/httpClient";

export function imageList(params: any) {
  return client.get("/backend/api/v1/media/images", params);
}

export function videoAliyunTokenRefresh(params: any) {
  return client.post("/backend/api/v1/video/token/aliyun/refresh", params);
}

export function videoAliyunTokenCreate(params: any) {
  return client.post("/backend/api/v1/video/token/aliyun/create", params);
}

export function videoTencentToken(params: any) {
  return client.post("/backend/api/v1/video/token/tencent", params);
}

export function newVideoList(params: any) {
  return client.get("/backend/api/v1/media/videos/index", params);
}

export function storeVideo(params: any) {
  return client.post("/backend/api/v1/media/videos/create", params);
}

export function newDestroyVideo(params: any) {
  return client.post(`/backend/api/v1/media/videos/delete/multi`, params);
}

export function imagesList(params: any) {
  return client.get("/backend/api/v1/media/images", params);
}

export function destroyImages(params: any) {
  return client.post(`/backend/api/v1/media/image/delete/multi`, params);
}
