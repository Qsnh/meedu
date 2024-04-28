import client from "./internal/httpClient";

export function PageBlocks(params: any) {
  return client.get(`/api/v2/viewBlock/page/blocks`, params);
}
