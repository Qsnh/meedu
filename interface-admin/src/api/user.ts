import client from "./internal/httpClient";

export function detail() {
  return client.get("/api/v1/user/detail", {});
}

// 修改密码
export function password(oldPassword: string, newPassword: string) {
  return client.put("/api/v1/user/avatar", {
    old_password: oldPassword,
    new_password: newPassword,
  });
}

// 学员课程
export function courses(depId: number) {
  return client.get("/api/v1/user/courses", {
    dep_id: depId,
  });
}
