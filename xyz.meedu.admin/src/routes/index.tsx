import { lazy } from "react";
import { RouteObject } from "react-router-dom";
import { login, system } from "../api";
// 页面加载
import InitPage from "../pages/init";
import { getToken } from "../utils";
import LoginPage from "../pages/login";
import WithHeaderWithoutFooter from "../pages/layouts/with-header-without-footer";
import WithoutHeaderWithoutFooter from "../pages/layouts/without-header-without-footer";

//主页
const DashboardPage = lazy(() => import("../pages/dashboard"));
//修改密码页面
const ChangePasswordPage = lazy(
  () => import("../pages/administrator/change-password")
);
//资源相关
const ResourceVideosPage = lazy(() => import("../pages/resource/videos/index"));
const ResourceImagesPage = lazy(() => import("../pages/resource/images/index"));
//录播课相关
const CoursePage = lazy(() => import("../pages/course/index"));
const CourseCreatePage = lazy(() => import("../pages/course/create"));
const CourseUpdatePage = lazy(() => import("../pages/course/update"));
const CourseCategoryPage = lazy(() => import("../pages/course/category/index"));
const CourseCommentsPage = lazy(() => import("../pages/course/comments"));
const CourseVideoCommentsPage = lazy(
  () => import("../pages/course/video/comments")
);
const CourseVideoImportPage = lazy(
  () => import("../pages/course/video/import")
);
const CourseUsersPage = lazy(() => import("../pages/course/users"));
const CourseAttachPage = lazy(() => import("../pages/course/attach/index"));
const CourseAttachCreatePage = lazy(
  () => import("../pages/course/attach/create")
);
const CourseVideoPage = lazy(() => import("../pages/course/video/index"));
const CourseVideoRecordsPage = lazy(
  () => import("../pages/course/video/watch-records")
);
const CourseVideoSubscribePage = lazy(
  () => import("../pages/course/video/subscribe")
);
const CourseChapterPage = lazy(() => import("../pages/course/chapter/index"));
const CourseVideoCreatePage = lazy(
  () => import("../pages/course/video/create")
);
const CourseVideoUpdatePage = lazy(
  () => import("../pages/course/video/update")
);
//学员相关
const MemberPage = lazy(() => import("../pages/member/index"));
const MemberImportPage = lazy(() => import("../pages/member/import"));
const MemberDetailPage = lazy(() => import("../pages/member/detail"));
const MemberProfilePage = lazy(() => import("../pages/member/profile"));
const MemberTagsPage = lazy(() => import("../pages/member/tags/index"));
const MemberTagsCreatePage = lazy(() => import("../pages/member/tags/create"));
const MemberTagsUpdatePage = lazy(() => import("../pages/member/tags/update"));
//订单相关
const OrderPage = lazy(() => import("../pages/order/index"));
const OrderRefundPage = lazy(() => import("../pages/order/refund"));
const OrderDetailPage = lazy(() => import("../pages/order/detail"));
//系统相关
const SystemApplicationPage = lazy(() => import("../pages/system/application"));
const SystemLogPage = lazy(() => import("../pages/system/systemLog/index"));
const SystemAdministratorPage = lazy(
  () => import("../pages/system/administrator/index")
);
const SystemAdministratorCreatePage = lazy(
  () => import("../pages/system/administrator/create")
);
const SystemAdministratorUpdatePage = lazy(
  () => import("../pages/system/administrator/update")
);
const SystemAdminrolesPage = lazy(
  () => import("../pages/system/adminroles/index")
);
const SystemAdminrolesCreatePage = lazy(
  () => import("../pages/system/adminroles/create")
);
const SystemAdminrolesUpdatePage = lazy(
  () => import("../pages/system/adminroles/update")
);
//数据统计
const StatsTransactionPage = lazy(() => import("../pages/stats/transaction"));
const StatsContentPage = lazy(() => import("../pages/stats/content"));
const StatsMemberPage = lazy(() => import("../pages/stats/member"));
//会员相关
const RolePage = lazy(() => import("../pages/role/index"));
const RoleCreatePage = lazy(() => import("../pages/role/create"));
const RoleUpdatePage = lazy(() => import("../pages/role/update"));
//优惠码
const PromoCodePage = lazy(() => import("../pages/promocode/index"));
const PromoCodeImportPage = lazy(() => import("../pages/promocode/import"));
const PromoCodeCreateMultiPage = lazy(
  () => import("../pages/promocode/create-multi")
);
const PromoCodeCreatePage = lazy(() => import("../pages/promocode/create"));
//系统配置
const SystemConfigPage = lazy(() => import("../pages/system/config/index"));
const SystemPlayerConfigPage = lazy(
  () => import("../pages/system/config/playerConfig")
);
const SystemPaymentConfigPage = lazy(
  () => import("../pages/system/config/paymentConfig")
);
const SystemMpWechatConfigPage = lazy(
  () => import("../pages/system/config/mp_wechatConfig")
);
const SystemMessageConfigPage = lazy(
  () => import("../pages/system/config/messageConfig")
);
const SystemVideoSaveConfigPage = lazy(
  () => import("../pages/system/config/videoSaveConfig")
);
const SystemImagesSaveConfigPage = lazy(
  () => import("../pages/system/config/saveImagesConfig")
);
const SystemCreditSignConfigPage = lazy(
  () => import("../pages/system/config/creditSignConfig")
);
const SystemNormalConfigPage = lazy(
  () => import("../pages/system/config/config")
);
const EditConfigPage = lazy(() => import("../pages/edit-config/index"));
const ErrorPage = lazy(() => import("../pages/error"));
const NoServicePage = lazy(() => import("../pages/error/no-sevice"));
//装修
const DecorationPCPage = lazy(() => import("../pages/decoration/pc"));
const DecorationH5Page = lazy(() => import("../pages/decoration/h5"));

let RootPage: any = null;
if (getToken() && window.location.pathname !== "/error") {
  RootPage = lazy(async () => {
    return new Promise<any>(async (resolve) => {
      try {
        let configRes: any = await system.getSystemConfig();
        let userRes: any = await login.getUser();
        let addonsRes: any = await system.addonsList();

        resolve({
          default: (
            <InitPage
              configData={configRes.data}
              loginData={userRes.data}
              addonsData={addonsRes.data}
            />
          ),
        });
      } catch (e) {
        console.error("系统初始化失败", e);
        if (typeof e !== "undefined") {
          resolve({
            default: <ErrorPage />,
          });
        } else {
          resolve({
            default: <NoServicePage />,
          });
        }
      }
    });
  });
} else {
  if (
    window.location.pathname !== "/login" &&
    window.location.pathname !== "/edit-config" &&
    window.location.pathname !== "/error"
  ) {
    window.location.href = "/login";
  }
  RootPage = <InitPage />;
}
const routes: RouteObject[] = [
  {
    path: "/",
    element: RootPage,
    children: [
      {
        path: "/",
        element: <WithHeaderWithoutFooter />,
        children: [
          {
            path: "/",
            element: <DashboardPage />,
          },
          {
            path: "/administrator/change-password",
            element: <ChangePasswordPage />,
          },
          { path: "/resource/videos/index", element: <ResourceVideosPage /> },
          { path: "/resource/images/index", element: <ResourceImagesPage /> },
          { path: "/course/vod/index", element: <CoursePage /> },
          { path: "/course/vod/create", element: <CourseCreatePage /> },
          { path: "/course/vod/update", element: <CourseUpdatePage /> },
          {
            path: "/course/vod/category/index",
            element: <CourseCategoryPage />,
          },
          {
            path: "/course/vod/components/vod-comments",
            element: <CourseCommentsPage />,
          },
          {
            path: "/course/vod/video/comments",
            element: <CourseVideoCommentsPage />,
          },
          { path: "/course/vod/:courseId/view", element: <CourseUsersPage /> },
          {
            path: "/course/vod/video-import",
            element: <CourseVideoImportPage />,
          },
          { path: "/course/vod/attach/index", element: <CourseAttachPage /> },
          {
            path: "/course/vod/attach/create",
            element: <CourseAttachCreatePage />,
          },
          { path: "/course/vod/video/index", element: <CourseVideoPage /> },
          {
            path: "/course/vod/video/watch-records",
            element: <CourseVideoRecordsPage />,
          },
          {
            path: "/course/vod/video/subscribe",
            element: <CourseVideoSubscribePage />,
          },
          {
            path: "/course/vod/chapter/index",
            element: <CourseChapterPage />,
          },
          {
            path: "/course/vod/video/create",
            element: <CourseVideoCreatePage />,
          },
          {
            path: "/course/vod/video/update",
            element: <CourseVideoUpdatePage />,
          },
          { path: "/member/index", element: <MemberPage /> },
          { path: "/member/import", element: <MemberImportPage /> },
          { path: "/member/:memberId", element: <MemberDetailPage /> },
          {
            path: "/member/profile/:memberId",
            element: <MemberProfilePage />,
          },
          { path: "/member/tag/index", element: <MemberTagsPage /> },
          { path: "/member/tag/create", element: <MemberTagsCreatePage /> },
          { path: "/member/tag/update", element: <MemberTagsUpdatePage /> },
          { path: "/order/index", element: <OrderPage /> },
          { path: "/order/refund", element: <OrderRefundPage /> },
          { path: "/order/detail", element: <OrderDetailPage /> },
          { path: "/role", element: <RolePage /> },
          { path: "/addrole", element: <RoleCreatePage /> },
          { path: "/editrole", element: <RoleUpdatePage /> },
          { path: "/promocode", element: <PromoCodePage /> },
          { path: "/order/code-import", element: <PromoCodeImportPage /> },
          { path: "/createcode", element: <PromoCodeCreatePage /> },
          { path: "/createmulticode", element: <PromoCodeCreateMultiPage /> },
          {
            path: "/system/administrator",
            element: <SystemAdministratorPage />,
          },
          {
            path: "/system/administrator/create",
            element: <SystemAdministratorCreatePage />,
          },
          {
            path: "/system/administrator/update",
            element: <SystemAdministratorUpdatePage />,
          },
          {
            path: "/system/adminroles",
            element: <SystemAdminrolesPage />,
          },
          {
            path: "/system/adminroles/create",
            element: <SystemAdminrolesCreatePage />,
          },
          {
            path: "/system/adminroles/update",
            element: <SystemAdminrolesUpdatePage />,
          },
          {
            path: "/system/application",
            element: <SystemApplicationPage />,
          },
          {
            path: "/systemLog/index",
            element: <SystemLogPage />,
          },
          {
            path: "/stats/transaction/index",
            element: <StatsTransactionPage />,
          },
          { path: "/stats/content/index", element: <StatsContentPage /> },
          { path: "/stats/member/index", element: <StatsMemberPage /> },
          { path: "/system/index", element: <SystemConfigPage /> },
          { path: "/system/playerConfig", element: <SystemPlayerConfigPage /> },
          {
            path: "/system/paymentConfig",
            element: <SystemPaymentConfigPage />,
          },
          {
            path: "/system/mp_wechatConfig",
            element: <SystemMpWechatConfigPage />,
          },
          {
            path: "/system/messageConfig",
            element: <SystemMessageConfigPage />,
          },
          {
            path: "/system/videoSaveConfig",
            element: <SystemVideoSaveConfigPage />,
          },
          {
            path: "/system/saveImagesConfig",
            element: <SystemImagesSaveConfigPage />,
          },
          {
            path: "/system/creditSignConfig",
            element: <SystemCreditSignConfigPage />,
          },
          { path: "/system/config", element: <SystemNormalConfigPage /> },
        ],
      },
      {
        path: "/",
        element: <WithoutHeaderWithoutFooter />,
        children: [
          {
            path: "/login",
            element: <LoginPage />,
          },
          { path: "/decoration/pc", element: <DecorationPCPage /> },
          { path: "/decoration/h5", element: <DecorationH5Page /> },
          { path: "/edit-config", element: <EditConfigPage /> },
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
