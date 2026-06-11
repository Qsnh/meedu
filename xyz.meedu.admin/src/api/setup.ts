import client from "./internal/httpClient";

export function getSetupStatus() {
  return client.get("/backend/api/v1/system/setup-status", {});
}

export function submitSetup(params: {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
}) {
  return client.post("/backend/api/v1/system/setup", params);
}
