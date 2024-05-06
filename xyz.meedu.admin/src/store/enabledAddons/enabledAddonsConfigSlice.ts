import { createSlice } from "@reduxjs/toolkit";

type EnabledAddonsStoreInterface = {
  enabledAddons: any;
  enabledAddonsCount: number;
};

let defaultValue: EnabledAddonsStoreInterface = {
  enabledAddons: {},
  enabledAddonsCount: 0,
};

const enabledAddonsConfigSlice = createSlice({
  name: "enabledAddonsConfig",
  initialState: {
    value: defaultValue,
  },
  reducers: {
    setEnabledAddonsAction(stage, e) {
      stage.value.enabledAddons = e.payload.addons;
      stage.value.enabledAddonsCount = e.payload.count;
    },
  },
});

export default enabledAddonsConfigSlice.reducer;
export const { setEnabledAddonsAction } = enabledAddonsConfigSlice.actions;

export type { EnabledAddonsStoreInterface };
