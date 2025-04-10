import client from "./internal/httpClient";

export function comments(params: any) {
  return client.get("/api/v3/comments", params);
}

export function commentsReplies(params: any) {
  return client.get(`/api/v3/comments/replies`, params);
}

export function submitComment(params: any) {
  return client.post(`/api/v3/comment/store`, params);
}
