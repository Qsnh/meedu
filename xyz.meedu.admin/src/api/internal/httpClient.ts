import axios, { Axios, AxiosResponse } from "axios";
import { message } from "antd";
import { getToken, clearToken } from "../../utils/index";
import config from "../../js/config";

const GoLogin = () => {
  clearToken();
  window.location.href = "/login";
};

const GoError = (code: number, msg?: string) => {
  let href = "/error?code=" + code;
  if (code === 0 && msg) {
    href = "/error?msg=" + msg;
  }
  window.location.replace(href);
};

export class HttpClient {
  axios: Axios;

  constructor(url: string) {
    this.axios = axios.create({
      baseURL: url,
      timeout: 15000,
      withCredentials: false,
      headers: {
        Accept: "application/json",
      },
    });

    //拦截器注册
    this.axios.interceptors.request.use(
      (config) => {
        const token = getToken();
        token && (config.headers.Authorization = "Bearer " + token);
        return config;
      },
      (err) => {
        return Promise.reject(err);
      }
    );

    this.axios.interceptors.response.use(
      (response: AxiosResponse) => {
        const status = response.data.status;
        const code = response.data.code;
        const msg = response.data.message; //错误消息
        if (status === 0) {
          return Promise.resolve(response);
        } else if (status === 401 || code === 401) {
          message.error("请重新登录");
          GoLogin();
        } else if (status === 1) {
          message.error(response.data.message);
        } else {
          GoError(0, msg);
        }
        return Promise.reject(response);
      },
      // 当http的状态码非0
      (error) => {
        const httpCode = error.response.status;
        if (httpCode === 401) {
          message.error("请重新登录");
          GoLogin();
        } else {
          GoError(httpCode);
        }
        return Promise.reject(error.response);
      }
    );
  }

  get<T = any>(url: string, params: object): Promise<T> {
    return new Promise((resolve, reject) => {
      this.axios
        .get(url, {
          params: params,
        })
        .then((res) => {
          resolve(res.data);
        })
        .catch((err) => {
          reject(err.data);
        });
    });
  }

  destroy<T = any>(url: string): Promise<T> {
    return new Promise((resolve, reject) => {
      this.axios
        .delete(url)
        .then((res) => {
          resolve(res.data);
        })
        .catch((err) => {
          reject(err.data);
        });
    });
  }

  post<T = any>(url: string, params: object): Promise<T> {
    return new Promise((resolve, reject) => {
      this.axios
        .post(url, params)
        .then((res) => {
          resolve(res.data);
        })
        .catch((err) => {
          reject(err.data);
        });
    });
  }

  put<T = any>(url: string, params: object): Promise<T> {
    return new Promise((resolve, reject) => {
      this.axios
        .put(url, params)
        .then((res) => {
          resolve(res.data);
        })
        .catch((err) => {
          reject(err.data);
        });
    });
  }

  request(config: object) {
    return new Promise((resolve, reject) => {
      this.axios
        .request(config)
        .then((res) => {
          resolve(res.data);
        })
        .catch((err) => {
          reject(err.data);
        });
    });
  }
}

const client = new HttpClient(config.url);

export default client;
