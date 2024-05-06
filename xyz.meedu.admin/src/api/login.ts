import client from "./internal/httpClient";

export function login(params: any) {
  return client.post("/backend/api/v1/login", params);
}

export function logout() {
  return client.post("/backend/api/v1/logout", {});
}

export function getUser() {
  return client.get("/backend/api/v1/user", {});
}
