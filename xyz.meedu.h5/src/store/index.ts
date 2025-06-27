import { configureStore } from "@reduxjs/toolkit";
import systemConfigReducer from "./system/systemConfigSlice";
import loginUserReducer from "./user/loginUserSlice";

const store = configureStore({
  reducer: {
    loginUser: loginUserReducer,
    systemConfig: systemConfigReducer,
  },
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;

export default store;
