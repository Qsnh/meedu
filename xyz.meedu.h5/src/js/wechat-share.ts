import { isWechat } from "../utils/index";
import { system } from "../api";

declare const window: any;

export default {
  methods: {
    wechatH5Share(title: any, desc: any, icon: any, userId: any) {
      if (!isWechat()) {
        return;
      }
      let curLink = window.location.href;

      // 计算分享的链接地址
      let shareLink = curLink;
      if (userId) {
        let parseUrl = new URL(curLink);
        let querystring = parseUrl.hash.split("?");
        if (querystring.length <= 1) {
          shareLink += "?msv=" + userId;
        } else {
          shareLink += "&msv=" + userId;
        }
      }

      system
        .Jssdk({
          path: curLink.split("#")[0],
        })
        .then((res: any) => {
          if (res.data.enabled !== 1) {
            return;
          }
          let jsapiConfig = res.data.data;
          window.wx.config({
            debug: jsapiConfig.debug,
            appId: jsapiConfig.appId,
            timestamp: jsapiConfig.timestamp,
            nonceStr: jsapiConfig.nonceStr,
            signature: jsapiConfig.signature,
            jsApiList: jsapiConfig.jsApiList,
          });

          if (typeof title === "undefined" || !title) {
            title = res.data.share.title;
          }
          if (typeof desc === "undefined" || !desc) {
            desc = res.data.share.desc;
          }
          if (typeof icon === "undefined" || !icon) {
            icon = res.data.share.icon;
          }

          window.wx.ready(() => {
            window.wx.updateAppMessageShareData({
              title: title,
              desc: desc || "",
              link: shareLink,
              imgUrl: icon,
              success: () => {},
            });
            window.wx.updateTimelineShareData({
              title: title,
              link: shareLink,
              imgUrl: icon,
              success: () => {},
            });
          });
        });
    },
  },
};
