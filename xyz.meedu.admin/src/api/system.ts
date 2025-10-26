import client from "./internal/httpClient";

export function getSystemConfig() {
  return client.get("/backend/api/v2/system/config", {});
}

export function setting() {
  return client.get("/backend/api/v1/setting", {});
}

export function saveSetting(params: any) {
  return client.post("/backend/api/v1/setting", params);
}

export function getImageCaptcha() {
  return client.get("/backend/api/v1/captcha/image", {});
}

export function addonsList() {
  return client.get(`/backend/api/v1/addons`, {});
}

export function switchAction(params: any) {
  return client.post(`/backend/api/v1/addons/switch`, params);
}

export function adminLog(params: any) {
  return client.get(`/backend/api/v1/log/admin`, params);
}
export function userLoginLog(params: any) {
  return client.get(`/backend/api/v1/log/userLogin`, params);
}
export function uploadImagesLog(params: any) {
  return client.get(`/backend/api/v1/log/uploadImages`, params);
}

export function administratorList(params: any) {
  return client.get(`/backend/api/v1/administrator/index`, params);
}

export function administratorDestory(id: number) {
  return client.destroy(`/backend/api/v1/administrator/${id}`);
}

export function administratorCreate() {
  return client.get(`/backend/api/v1/administrator/create`, {});
}

export function administratorStore(params: any) {
  return client.post(`/backend/api/v1/administrator/create`, params);
}

export function administratorDetail(id: number) {
  return client.get(`/backend/api/v1/administrator/${id}`, {});
}

export function administratorUpdate(id: number, params: any) {
  return client.put(`/backend/api/v1/administrator/${id}`, params);
}

export function navsList(params: any) {
  return client.get(`/backend/api/v1/nav/index`, params);
}

export function navsCreate() {
  return client.get(`/backend/api/v1/nav/create`, {});
}

export function navsStore(params: any) {
  return client.post(`/backend/api/v1/nav/create`, params);
}

export function navsDestroy(id: number) {
  return client.destroy(`/backend/api/v1/nav/${id}`);
}

export function navsDetail(id: number) {
  return client.get(`/backend/api/v1/nav/${id}`, {});
}

export function navsUpdate(id: number, params: any) {
  return client.put(`/backend/api/v1/nav/${id}`, params);
}

export function announcementList(params: any) {
  return client.get(`/backend/api/v1/announcement/index`, params);
}

export function announcementStore(params: any) {
  return client.post(`/backend/api/v1/announcement/create`, params);
}

export function announcementDestroy(id: number) {
  return client.destroy(`/backend/api/v1/announcement/${id}`);
}

export function announcementDetail(id: number) {
  return client.get(`/backend/api/v1/announcement/${id}`, {});
}

export function announcementUpdate(id: number, params: any) {
  return client.put(`/backend/api/v1/announcement/${id}`, params);
}

export function linksList(params: any) {
  return client.get(`/backend/api/v1/link/index`, params);
}

export function linksStore(params: any) {
  return client.post(`/backend/api/v1/link/create`, params);
}

export function linksDestroy(id: number) {
  return client.destroy(`/backend/api/v1/link/${id}`);
}

export function linksDetail(id: number) {
  return client.get(`/backend/api/v1/link/${id}`, {});
}

export function linksUpdate(id: number, params: any) {
  return client.put(`/backend/api/v1/link/${id}`, params);
}

export function runTimeLog() {
  return client.get(`/backend/api/v1/log/runtime`, {});
}

export function adminLogDestory(sign: any) {
  return client.destroy(`/backend/api/v1/log/${sign}`);
}
