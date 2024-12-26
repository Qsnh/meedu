import { lazy } from "react";
import { RouteObject } from "react-router-dom";
import { system, user } from "../api";
import { getToken } from "../utils";
// 页面加载
import { InitPage } from "../pages/init";
import LoginPage from "../pages/login";
import WithFooter from "../pages/layouts/with-footer";
import WithoutFooter from "../pages/layouts/without-footer";

//用户中心页面
const MemberPage = lazy(() => import("../pages/member/index"));
//主页
const IndexPage = lazy(() => import("../pages/index/index"));
//学习页面
const StudyPage = lazy(() => import("../pages/study/index"));
//课程列表页面
const CoursePage = lazy(() => import("../pages/course/index"));
//课程详情页面
const CourseDetailPage = lazy(() => import("../pages/course/detail"));
//课程学习页面
const CoursePlayPage = lazy(() => import("../pages/course/video"));
//会员页面
const RolePage = lazy(() => import("../pages/role/index"));
//收银台页面
const OrderPage = lazy(() => import("../pages/order/index"));
//支付成功页面
const OrderSuccessPage = lazy(() => import("../pages/order/success"));
//我的订单页面
const MemberOrdersPage = lazy(() => import("../pages/member/order"));
//我的消息页面
const MessagesPage = lazy(() => import("../pages/messages/index"));
//关于页面
const MemberSettingPage = lazy(() => import("../pages/member/setting"));
//个人资料页面
const MemberProfilePage = lazy(() => import("../pages/member/profile"));
//搜索页面页面
const SearchPage = lazy(() => import("../pages/search/index"));
//验证手机号页面
const MemberMobileVerifyPage = lazy(
  () => import("../pages/member/mobileVerify")
);
//绑定手机号页面
const MemberMobilePage = lazy(() => import("../pages/member/mobile"));
//重置密码页面
const MemberPasswordPage = lazy(() => import("../pages/member/password"));
//实人认证结果页面
const FaceSuccessPage = lazy(() => import("../pages/faceSuccess/index"));
//密码登录页面
const LoginPasswordPage = lazy(() => import("../pages/login/login-password"));
//登录失败页面
const LoginErrorPage = lazy(() => import("../pages/login/login-error"));
//登录绑定手机号页面
const BindMobilePage = lazy(() => import("../pages/bind-mobile/index"));
//code登录绑定手机号页面
const CodeBindMobilePage = lazy(
  () => import("../pages/code-bind-mobile/index")
);
//404页面
const ErrorPage = lazy(() => import("../pages/error/index"));

import PrivateRoute from "../components/private-route";

let RootPage: any = null;
if (getToken()) {
  RootPage = lazy(async () => {
    return new Promise<any>(async (resolve) => {
      try {
        let configRes: any = await system.config();
        let userRes: any = await user.detail();
        resolve({
          default: (
            <InitPage configData={configRes.data} loginData={userRes.data} />
          ),
        });
      } catch (e) {
        console.error("系统初始化失败", e);
      }
    });
  });
} else {
  RootPage = lazy(async () => {
    return new Promise<any>(async (resolve) => {
      try {
        let configRes: any = await system.config();
        resolve({
          default: <InitPage configData={configRes.data} />,
        });
      } catch (e) {
        console.error("系统初始化失败", e);
      }
    });
  });
}

const routes: RouteObject[] = [
  {
    path: "/",
    element: RootPage,
    children: [
      {
        path: "/",
        element: <WithFooter />,
        children: [
          {
            path: "/",
            element: <IndexPage />,
          },
          {
            path: "/member",
            element: <MemberPage />,
          },
          {
            path: "/study",
            element: <PrivateRoute Component={<StudyPage />} />,
          },
        ],
      },
      {
        path: "/",
        element: <WithoutFooter />,
        children: [
          {
            path: "/login",
            element: <LoginPage />,
          },
          {
            path: "/courses",
            element: <CoursePage />,
          },
          {
            path: "/course/:courseId",
            element: <CourseDetailPage />,
          },
          {
            path: "/course/video/:videoId",
            element: <PrivateRoute Component={<CoursePlayPage />} />,
          },
          {
            path: "/role",
            element: <PrivateRoute Component={<RolePage />} />,
          },
          {
            path: "/order",
            element: <PrivateRoute Component={<OrderPage />} />,
          },
          {
            path: "/order/success",
            element: <PrivateRoute Component={<OrderSuccessPage />} />,
          },
          {
            path: "/member/order",
            element: <PrivateRoute Component={<MemberOrdersPage />} />,
          },
          {
            path: "/messages",
            element: <PrivateRoute Component={<MessagesPage />} />,
          },
          {
            path: "/member/setting",
            element: <MemberSettingPage />,
          },
          {
            path: "/member/profile",
            element: <PrivateRoute Component={<MemberProfilePage />} />,
          },
          {
            path: "/member/mobileVerify",
            element: <PrivateRoute Component={<MemberMobileVerifyPage />} />,
          },
          {
            path: "/member/password",
            element: <PrivateRoute Component={<MemberPasswordPage />} />,
          },
          {
            path: "/member/mobile",
            element: <PrivateRoute Component={<MemberMobilePage />} />,
          },
          {
            path: "/member/mobile",
            element: <PrivateRoute Component={<MemberMobilePage />} />,
          },
          {
            path: "/search",
            element: <SearchPage />,
          },
          {
            path: "/auth/faceSuccess",
            element: <FaceSuccessPage />,
          },
          {
            path: "/login-password",
            element: <LoginPasswordPage />,
          },
          {
            path: "/login-error",
            element: <LoginErrorPage />,
          },
          {
            path: "/bind-mobile",
            element: <BindMobilePage />,
          },
          {
            path: "/code-bind-mobile",
            element: <CodeBindMobilePage />,
          },
          {
            path: "/error",
            element: <ErrorPage />,
          },
          {
            path: "*",
            element: <ErrorPage />,
          },
        ],
      },
    ],
  },
];

export default routes;
