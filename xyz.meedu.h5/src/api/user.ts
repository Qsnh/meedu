import client from "./internal/httpClient";

export function detail() {
  return client.get("/api/v2/member/detail", {});
}

export function Orders(params: any) {
  return client.get("/api/v2/member/orders", params);
}

export function Courses(params: any) {
  return client.get("/api/v2/member/courses", params);
}

export function LikeCourses(params: any) {
  return client.get("/api/v2/member/courses/like", params);
}

export function UnReadNum() {
  return client.get("/api/v2/member/unreadNotificationCount", {});
}

export function Messages(params: any) {
  return client.get("/api/v2/member/messages", params);
}

export function ReadMessage(id: number) {
  return client.get("/api/v2/member/notificationMarkAsRead/" + id, {});
}

export function NewCourses(params: any) {
  return client.get("/api/v3/member/courses", params);
}

export function CoursesCollects(params: any) {
  return client.get("/api/v3/member/courses/like", params);
}

export function LearnedCourses(params: any) {
  return client.get("/api/v3/member/courses/learned", params);
}

export function UploadAvatar(params: any) {
  return client.post("/api/v2/member/detail/avatar", params);
}

export function TecentFaceVerify(params: any) {
  return client.post("/api/v3/member/tencent/faceVerify", params);
}

export function TecentFaceVerifyQuery(params: any) {
  return client.get("/api/v3/member/tencent/faceVerify", params);
}

export function CancelBind(app: string) {
  return client.destroy(`/api/v2/member/socialite/${app}`);
}

export function NicknameChange(params: any) {
  return client.post("/api/v2/member/detail/nickname", params);
}

export function MobileChange(params: any) {
  return client.put("/api/v2/member/mobile", params);
}

export function MobileVerify(params: any) {
  return client.post("/api/v2/member/verify", params);
}

export function PasswordChange(params: any) {
  return client.post("/api/v2/member/detail/password", params);
}

export function NewMobile(params: any) {
  return client.post("/api/v2/member/detail/mobile", params);
}

