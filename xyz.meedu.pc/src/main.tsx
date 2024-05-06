import ReactDOM from "react-dom/client";
import { Provider } from "react-redux";
import store from "./store";
import { BrowserRouter } from "react-router-dom";
import { ConfigProvider } from "antd";
import zhCN from "antd/locale/zh_CN";
import App from "./App";
import "./index.scss"; //全局样式
import AutoScorllTop from "./AutoTop";

ReactDOM.createRoot(document.getElementById("root") as HTMLElement).render(
  <Provider store={store}>
    <ConfigProvider
      locale={zhCN}
      theme={{ token: { colorPrimary: "#3ca7fa" } }}
    >
      <BrowserRouter>
        <AutoScorllTop>
          <App />
        </AutoScorllTop>
      </BrowserRouter>
    </ConfigProvider>
  </Provider>
);