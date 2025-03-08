import { createSlice } from "@reduxjs/toolkit";
import { clearToken } from "../../utils/index";

type UserStoreInterface = {
  user: MIAdministrator | null;
  isLogin: boolean;
  title: string;
};

const defaultValue: UserStoreInterface = {
  user: null,
  isLogin: false,
  title: "MeEdu后台管理",
};

const loginUserSlice = createSlice({
  name: "loginUser",
  initialState: {
    value: defaultValue,
  },
  reducers: {
    loginAction(stage, e) {
      stage.value.user = e.payload;
      stage.value.isLogin = true;
    },
    logoutAction(stage) {
      stage.value.user = null;
      stage.value.isLogin = false;
      clearToken();
    },
    titleAction(stage, e) {
      stage.value.title = e.payload;
    },
  },
});

export default loginUserSlice.reducer;
export const { loginAction, logoutAction, titleAction } =
  loginUserSlice.actions;

export type { UserStoreInterface };
