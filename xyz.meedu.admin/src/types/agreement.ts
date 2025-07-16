export interface Agreement {
  id: number;
  type: string;
  title: string;
  content: string;
  version: string;
  is_active: boolean;
  effective_at: string;
  created_at: string;
  updated_at: string;
}

export interface AgreementRecord {
  id: number;
  user_id: number;
  agreement_id: number;
  agreement_type: string;
  agreement_version: string;
  agreed_at: string;
  ip: string;
  user_agent: string;
  platform: string;
  user: {
    id: number;
    nick_name: string;
    mobile: string;
    avatar: string;
  };
} 