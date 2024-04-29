import client from "./internal/httpClient";

export function list(params: any) {
  return client.get("/api/v3/search", params);
}
