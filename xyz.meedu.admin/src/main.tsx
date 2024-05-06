import ReactDOM from "react-dom/client";
import { Provider } from "react-redux";
import store from "./store";
import { BrowserRouter } from "react-router-dom";
import { ConfigProvider, App as AntdApp } from "antd";
import zhCN from "antd/locale/zh_CN";
import "dayjs/locale/zh-cn";
import App from "./App";
import "./index.scss"; //全局样式
import AutoScorllTop from "./AutoTop";

ReactDOM.createRoot(document.getElementById("root") as HTMLElement).render(
  <Provider store={store}>
    <ConfigProvider
      locale={zhCN}
      theme={{ token: { colorPrimary: "#3ca7fa" } }}
    >
      <AntdApp>
        <BrowserRouter>
          <AutoScorllTop>
            <App />
          </AutoScorllTop>
        </BrowserRouter>
      </AntdApp>
    </ConfigProvider>
  </Provider>
);