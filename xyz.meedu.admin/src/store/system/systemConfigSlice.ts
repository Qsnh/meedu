import { createSlice } from "@reduxjs/toolkit";

type SystemConfigStoreInterface = {
  system?: {
    logo?: string;
    url?: {
      api?: string;
      h5?: string;
      pc?: string;
    };
  };
  video?: {
    default_service?: string;
  };
};

const systemConfigSlice = createSlice({
  name: "systemConfig",
  initialState: {
    value: {},
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
