// 权限类型定义
export interface Permission {
  [key: string]: boolean;
}

// 权限路径配置类型
export interface PermissionPath {
  permission: string;  // 权限标识
  path: string;       // 路由路径
  title: string;      // 页面标题
}

// 用户信息类型补充
export interface MIAdministrator {
  id: number;
  name: string;
  email: string;
  permissions: Permission;
  created_at: string;
  is_ban_login: number;
  login_at: string;
} 