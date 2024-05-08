import client from "./internal/httpClient";

export function List(params: any) {
  return client.get("/api/v2/courses", params);
}

export function Detail(id: number) {
  return client.get("/api/v2/course/" + id, {});
}

export function Comments(id: number) {
  return client.get("/api/v2/course/" + id + "/comments", {});
}

export function Collect(id: number) {
  return client.get("/api/v2/course/" + id + "/like", {});
}

export function SubmitComment(id: number, params: any) {
  return client.post("/api/v2/course/" + id + "/comment", params);
}

export function Video(id: number) {
  return client.get("/api/v2/video/" + id, {});
}

export function VideoComments(id: number) {
  return client.get("/api/v2/video/" + id + "/comments", {});
}

export function SubmitVideoComment(id: number, params: any) {
  return client.post("/api/v2/video/" + id + "/comment", params);
}

export function PlayInfo(id: number, params: any) {
  return client.get("/api/v2/video/" + id + "/playinfo", params);
}

export function VideoRecord(id: number, params: any) {
  return client.post("/api/v2/video/" + id + "/record", params);
}

export function Categories() {
  return client.get("/api/v2/course_categories", {});
}

export function CourseLikeHit(id: number) {
  return client.get(`/api/v2/course/${id}/like`, {});
}
