import client from "./internal/httpClient";

export function pageBlocks(params: any) {
  return client.get("/api/v2/decorationPage/blocks", params);
}
