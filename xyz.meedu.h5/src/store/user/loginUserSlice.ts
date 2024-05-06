import { createSlice } from "@reduxjs/toolkit";
import { clearToken } from "../../utils/index";

type UserStoreInterface = {
  user: UserModel | null;
  isLogin: boolean;
};

let defaultValue: UserStoreInterface = {
  user: null,
  isLogin: false,
};

const loginUserSlice = createSlice({
  name: "loginUser",
  initialState: {
    value: defaultValue,
  },
  reducers: {
    loginAction(stage, e) {
      stage.value.isLogin = true;
      stage.value.user = e.payload;
    },
    logoutAction(stage) {
      stage.value.isLogin = false;
      stage.value.user = null;
      clearToken();
    },
  },
});

export default loginUserSlice.reducer;
export const { loginAction, logoutAction } = loginUserSlice.actions;

export type { UserStoreInterface };
