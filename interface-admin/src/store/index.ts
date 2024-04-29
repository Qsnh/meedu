import { configureStore } from "@reduxjs/toolkit";
import systemConfigReducer from "./system/systemConfigSlice";
import loginUserReducer from "./user/loginUserSlice";
import EnabledAddonsReducer from "./enabledAddons/enabledAddonsConfigSlice";

const store = configureStore({
  reducer: {
    loginUser: loginUserReducer,
    systemConfig: systemConfigReducer,
    enabledAddonsConfig: EnabledAddonsReducer,
  },
});

export default store;
