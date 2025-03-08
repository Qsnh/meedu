import { createSlice } from "@reduxjs/toolkit";

type SystemConfigStoreInterface = {
  system: {
    logo: string;
    url: {
      api: string;
      h5: string;
      pc: string;
    };
  };
  video: {
    default_service: string;
  };
};

const defaultValue: SystemConfigStoreInterface = {
  system: {
    logo: "",
    url: { api: "", h5: "", pc: "" },
  },
  video: {
    default_service: "",
  },
};

const systemConfigSlice = createSlice({
  name: "systemConfig",
  initialState: {
    value: defaultValue,
  },
  reducers: {
    saveConfigAction(stage, e) {
      stage.value = e.payload;
    },
  },
});

export default systemConfigSlice.reducer;
export const { saveConfigAction } = systemConfigSlice.actions;

export type { SystemConfigStoreInterface };
