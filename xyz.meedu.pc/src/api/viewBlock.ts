import client from "./internal/httpClient";

export function pageBlocks(params: any) {
  return client.get("/api/v2/viewBlock/page/blocks", params);
}

export function sliders(params: any) {
  return client.get("/api/v2/sliders", params);
}
