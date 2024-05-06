import { configureStore } from "@reduxjs/toolkit";
import systemConfigReducer from "./system/systemConfigSlice";
import loginUserReducer from "./user/loginUserSlice";

const store = configureStore({
  reducer: {
    loginUser: loginUserReducer,
    systemConfig: systemConfigReducer,
  },
});

export default store;
