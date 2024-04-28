import client from "./internal/httpClient";

export function Index(params:any) {
  return client.get("/api/v3/search",params);
}
