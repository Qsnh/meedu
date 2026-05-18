import { useSelector } from "react-redux";

// 判定语义与 PerButton 一致:权限 slug 作为 key 存在即视为拥有。
export const useHasPermission = (slug: string): boolean => {
  const user = useSelector((state: any) => state.loginUser.value.user);
  if (!user || !user.permissions) {
    return false;
  }
  return typeof user.permissions[slug] !== "undefined";
};
