import ReactDOM from "react-dom/client";
import { Provider } from "react-redux";
import store from "./store";
import { BrowserRouter } from "react-router-dom";
import "./index.scss";
import App from "./App";
import AutoScorllTop from "./AutoTop";

ReactDOM.createRoot(document.getElementById("root") as HTMLElement).render(
  <Provider store={store}>
    <BrowserRouter>
      <AutoScorllTop>
        <App />
      </AutoScorllTop>
    </BrowserRouter>
  </Provider>
);
