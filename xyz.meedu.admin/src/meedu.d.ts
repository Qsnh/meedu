declare module "xlsx";

declare global {
  interface ResponseInterface {
    data: any;
    status: number;
    message?: string;
  }

  interface CategoriesBoxModel {
    [key: number]: CategoriesItemModel[];
  }

  interface CategoriesItemModel {
    id: number;
    name: string;
    parent_chain: string;
    parent_id: number;
    sort: number;
  }
}

export {};
