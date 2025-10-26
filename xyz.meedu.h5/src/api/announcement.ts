import client from "./internal/httpClient";

export function latest() {
  return client.get(`/api/v2/announcement/latest`, {});
}

export function detail(id: number) {
  return client.get(`/api/v2/announcement/${id}`, {});
}

export function list(page: number = 1, size: number = 10) {
  return client.get(`/api/v2/announcements`, {
    page,
    size,
  });
}
