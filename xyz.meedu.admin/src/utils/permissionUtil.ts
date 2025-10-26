import { Permission } from "../types/permission";
import { PERMISSION_CONFIG } from "../config/permissions";

export class PermissionUtil {
  /**
   * 获取用户第一个可访问的路径
   * @param permissions 用户权限对象
   * @returns 可访问的路径或null
   */
  static getFirstAvailablePath(permissions: Permission): string | null {
    if (!permissions) return null;

    const availablePath = PERMISSION_CONFIG.find((item) => {
      // 如果permission是数组，检查是否有任意一个权限存在（OR逻辑）
      if (Array.isArray(item.permission)) {
        return item.permission.some(
          (perm) => typeof permissions[perm] !== "undefined"
        );
      }
      // 如果是字符串，直接检查
      return typeof permissions[item.permission] !== "undefined";
    });

    return availablePath?.path || null;
  }

  /**
   * 检查用户是否有任何可用权限
   * @param permissions 用户权限对象
   * @returns boolean
   */
  static hasAnyPermission(permissions: Permission): boolean {
    if (!permissions) return false;
    return PERMISSION_CONFIG.some((item) => {
      // 如果permission是数组，检查是否有任意一个权限存在（OR逻辑）
      if (Array.isArray(item.permission)) {
        return item.permission.some(
          (perm) => typeof permissions[perm] !== "undefined"
        );
      }
      // 如果是字符串，直接检查
      return typeof permissions[item.permission] !== "undefined";
    });
  }

  /**
   * 检查用户是否有特定权限
   * @param permissions 用户权限对象
   * @param permission 权限标识
   * @returns boolean
   */
  static hasPermission(permissions: Permission, permission: string): boolean {
    if (!permissions) return false;
    return !!permissions[permission];
  }
}
