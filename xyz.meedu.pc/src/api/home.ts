import client from "./internal/httpClient";

export function announcement() {
  return client.get(`/api/v2/announcement/latest`, {});
}
export function announcementList() {
  return client.get(`/api/v2/announcements`, {});
}
export function announcementDetail(id: number) {
  return client.get(`/api/v2/announcement/${id}`, {});
}
export function headerNav() {
  return client.get(`/api/v2/navs`, {});
}
