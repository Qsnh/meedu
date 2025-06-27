import { createSlice } from "@reduxjs/toolkit";
import type { NavItem } from "../system/systemConfigSlice";

type NavMenuConfigStoreInterface = {
  navs: NavItem[];
};

let defaultValue: NavMenuConfigStoreInterface = {
  navs: [],
};

const navMenuSlice = createSlice({
  name: "navMenuConfig",
  initialState: {
    value: defaultValue,
  },
  reducers: {
    saveNavsAction(stage, e) {
      stage.value.navs = e.payload;
    },
  },
});

export default navMenuSlice.reducer;
export const { saveNavsAction } = navMenuSlice.actions;

export type { NavMenuConfigStoreInterface };
