import client from "./internal/httpClient";

export function courses(params: any) {
  return client.get("/api/v3/member/courses/learned", params);
}

export function coursesDetail(courseId: number, params: any) {
  return client.get(`/api/v3/member/learned/course/${courseId}`, params);
}