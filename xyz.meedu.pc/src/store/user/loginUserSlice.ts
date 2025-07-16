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
  showAgreementDialog: boolean; // 新增：是否显示协议弹窗
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
  showAgreementDialog: false, // 新增
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
      
      // 检查用户协议状态
      const agreementStatus = e.payload.agreement_status;
      if (agreementStatus && 
          (!agreementStatus.user_agreement_agreed || 
           !agreementStatus.privacy_policy_agreed)) {
        stage.value.showAgreementDialog = true;
      }
    },
    logoutAction(stage) {
      stage.value.user = null;
      stage.value.isLogin = false;
      stage.value.showAgreementDialog = false; // 重置协议弹窗状态
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
    closeAgreementDialog(stage) {
      stage.value.showAgreementDialog = false;
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
  closeAgreementDialog, // 新增
} = loginUserSlice.actions;

export type { UserStoreInterface };
