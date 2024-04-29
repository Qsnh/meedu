import { configureStore } from "@reduxjs/toolkit";
import systemConfigReducer from "./system/systemConfigSlice";
import loginUserReducer from "./user/loginUserSlice";
import navsMenuReducer from "./nav-menu/navMenuConfigSlice";

const store = configureStore({
  reducer: {
    loginUser: loginUserReducer,
    systemConfig: systemConfigReducer,
    navsConfig: navsMenuReducer,
  },
});

export default store;
