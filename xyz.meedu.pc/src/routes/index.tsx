import { lazy } from "react";
import { RouteObject } from "react-router-dom";
import { system, home } from "../api";

// 页面加载
import { InitPage } from "../pages/init";
import LoginPage from "../pages/login";
import PrivateRoute from "../components/private-route";
import WithHeaderWithFooter from "../pages/layouts/with-header-with-footer";
import WithHeaderWithoutFooter from "../pages/layouts/with-header-without-footer";
import WithoutHeaderWithoutFooter from "../pages/layouts/without-header-without-footer";

const IndexPage = lazy(() => import("../pages/index"));
// 录播相关页面
const VodPage = lazy(() => import("../pages/vod/index"));
const VodDetailPage = lazy(() => import("../pages/vod/detail"));
const VodPlayPage = lazy(() => import("../pages/vod/video"));
// 其它
const AnnouncementPage = lazy(() => import("../pages/announcement/index"));
// 学员相关
const MemberPage = lazy(() => import("../pages/member/index"));
const MemberMessagesPage = lazy(() => import("../pages/member/messages"));
const MemberOrdersPage = lazy(() => import("../pages/member/orders"));
const MemberCredit1FreePage = lazy(
  () => import("../pages/member/credit1-free")
);
//会员
const RolePage = lazy(() => import("../pages/role"));
//订单相关
const OrderPage = lazy(() => import("../pages/order/index"));
const OrderPayPage = lazy(() => import("../pages/order/pay"));
const OrderSuccessPage = lazy(() => import("../pages/order/success"));
//搜索
const SearchPage = lazy(() => import("../pages/search"));
//学习中心
const StudyCenterPage = lazy(() => import("../pages/study/index"));
//实人认证
const TencentFaceCheckPage = lazy(() => import("../pages/auth/faceCheck"));
//绑定手机号
const BindNewMobilePage = lazy(() => import("../pages/auth/bindMobile"));
//加载...
const AuthLoadingPage = lazy(() => import("../pages/auth/loading"));
//错误相关
const ErrorPage = lazy(() => import("../pages/error/index"));
const Error404 = lazy(() => import("../pages/error/404"));

let RootPage: any = null;

let configFunc: AppFeatureInterface = {
  vip: true,
  live: false,
  book: false,
  topic: false,
  paper: false,
  practice: false,
  mockPaper: false,
  wrongBook: false,
  wenda: false,
  share: false,
  codeExchanger: false,
  snapshort: false,
  ke: false,
  promoCode: false,
  daySignIn: false,
  credit1Mall: false,
  tuangou: false,
  miaosha: false,
  cert: false,
};

RootPage = lazy(async () => {
  return new Promise<any>(async (resolve) => {
    try {
      // 获取系统配置
      const configRes: AppConfigInterface = (
        (await system.config()) as ResponseInterface
      ).data as AppConfigInterface;

      // 获取导航栏
      const navsRes: any = await home.headerNav();

      resolve({
        default: (
          <InitPage
            config={configRes}
            configFunc={configFunc}
            navsData={navsRes.data}
          />
        ),
      });
    } catch (e) {
      console.error("系统初始化失败", e);
    }
  });
});

const routes: RouteObject[] = [
  {
    path: "/",
    element: RootPage,
    children: [
      {
        path: "/",
        element: <WithHeaderWithFooter />,
        children: [
          {
            path: "/",
            element: <IndexPage />,
          },
          { path: "/login/callback", element: <AuthLoadingPage /> },
          { path: "/courses", element: <VodPage /> },
          { path: "/courses/detail/:courseId", element: <VodDetailPage /> },
          {
            path: "/courses/video/:courseId",
            element: <PrivateRoute Component={<VodPlayPage />} />,
          },
          { path: "/announcement", element: <AnnouncementPage /> },
          {
            path: "/member",
            element: <PrivateRoute Component={<MemberPage />} />,
          },
          {
            path: "/member/messages",
            element: <PrivateRoute Component={<MemberMessagesPage />} />,
          },
          {
            path: "/member/orders",
            element: <PrivateRoute Component={<MemberOrdersPage />} />,
          },
          {
            path: "/member/credit1-free",
            element: <PrivateRoute Component={<MemberCredit1FreePage />} />,
          },
          { path: "/vip", element: <RolePage /> },
          {
            path: "/order",
            element: <PrivateRoute Component={<OrderPage />} />,
          },
          {
            path: "/order/pay",
            element: <PrivateRoute Component={<OrderPayPage />} />,
          },
          {
            path: "/order/success",
            element: <PrivateRoute Component={<OrderSuccessPage />} />,
          },
          { path: "/search", element: <SearchPage /> },
          { path: "/error", element: <ErrorPage /> },
          {
            path: "/study-center",
            element: <PrivateRoute Component={<StudyCenterPage />} />,
          },
          { path: "/face-check", element: <TencentFaceCheckPage /> },
          { path: "/bind-mobile", element: <BindNewMobilePage /> },
        ],
      },
      {
        path: "/",
        element: <WithHeaderWithoutFooter />,
        children: [
          {
            path: "/login",
            element: <LoginPage />,
          },
        ],
      },
      {
        path: "/",
        element: <WithoutHeaderWithoutFooter />,
        children: [{ path: "*", element: <Error404 /> }],
      },
    ],
  },
];

export default routes;
