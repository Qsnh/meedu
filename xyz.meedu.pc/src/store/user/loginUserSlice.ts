import { createSlice } from "@reduxjs/toolkit";
import {
  clearToken,
  clearFaceCheckKey,
  clearBindMobileKey,
} from "../../utils/index";

type UserStoreInterface = {
  user: any;
  isLogin: boolean;
  freshUnread: boolean;
  addressForm: {
    name: string;
    mobile: string;
    province: string;
    city: string;
    area: string;
    street: string;
  };
};

let defaultValue: UserStoreInterface = {
  user: null,
  isLogin: false,
  freshUnread: false,
  addressForm: {
    name: "",
    mobile: "",
    province: "",
    city: "",
    area: "",
    street: "",
  },
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
      stage.value.freshUnread = true;
    },
    logoutAction(stage) {
      stage.value.user = null;
      stage.value.isLogin = false;
      clearToken();
      clearFaceCheckKey();
      clearBindMobileKey();
    },
    changeUserCredit(stage, e) {
      stage.value.user.credit1 = e.payload;
    },
    saveUnread(stage, e) {
      stage.value.freshUnread = e.payload;
    },
    setNewAddress(state, e) {
      state.value.addressForm = e.payload;
    },
  },
});

export default loginUserSlice.reducer;

export const {
  loginAction,
  logoutAction,
  saveUnread,
  changeUserCredit,
  setNewAddress,
} = loginUserSlice.actions;

export type { UserStoreInterface };
