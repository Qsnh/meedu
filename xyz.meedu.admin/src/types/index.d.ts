declare global {
  interface VideoParseInfo {
    poster: string;
    duration: number;
  }

  interface IApiResponse<T> {
    status: number;
    message: string;
    data: T;
  }

  interface MIAdministrator {
    id: number;
    name: string;
    email: string;
    last_login_ip: string;
    last_login_date: string;
    created_at: string;
    updated_at: string;
    is_ban_login: number;
    login_times: number;
    permissions: Record<string, number>;
    role_id: number[];
    is_super: boolean;
    roles: {
      id: number;
      display_name: string;
      slug: string;
      description: string;
      created_at: string;
      updated_at: string;
      permission_ids: number[];
      pivot: {
        administrator_id: number;
        role_id: number;
      };
    }[];
  }
}

export {};
