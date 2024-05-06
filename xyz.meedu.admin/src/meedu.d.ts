declare module "xlsx";

declare global {
  interface ResponseInterface {
    data: any;
    status: number;
    message?: string;
  }
}

export {};
