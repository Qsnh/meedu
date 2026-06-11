import { configureStore } from "@reduxjs/toolkit";
import systemConfigReducer from "./system/systemConfigSlice";
import systemSetupReducer from "./system/systemSetupSlice";
import loginUserReducer from "./user/loginUserSlice";
import EnabledAddonsReducer from "./enabledAddons/enabledAddonsConfigSlice";

const store = configureStore({
  reducer: {
    loginUser: loginUserReducer,
    systemConfig: systemConfigReducer,
    systemSetup: systemSetupReducer,
    enabledAddonsConfig: EnabledAddonsReducer,
  },
});

export default store;
