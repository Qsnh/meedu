import client from "./internal/httpClient";

export function list() {
  return client.get("/api/v2/roles", {});
}
