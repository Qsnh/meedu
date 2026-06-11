import { createSlice } from "@reduxjs/toolkit";

type SetupState = {
  needsInit: boolean | null; // null = 尚未查询
};

const initialState: SetupState = { needsInit: null };

const systemSetupSlice = createSlice({
  name: "systemSetup",
  initialState,
  reducers: {
    setNeedsInit(state, action: { payload: boolean }) {
      state.needsInit = action.payload;
    },
  },
});

export default systemSetupSlice.reducer;
export const { setNeedsInit } = systemSetupSlice.actions;
export type { SetupState };
