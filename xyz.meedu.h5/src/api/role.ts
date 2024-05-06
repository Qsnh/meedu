import client from "./internal/httpClient";

export function List() {
  return client.get("/api/v2/roles", {});
}
