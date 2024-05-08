// 导出页面为PDF格式
import html2Canvas from "html2canvas";
import JsPDF from "jspdf";
declare const window: any;
export default {
  //有分页
  getPdf(name:string) {
    window.pageYoffset = 0;
    document.documentElement.scrollTop = 0;
    document.body.scrollTop = 0;

    let shareContent:any = document.querySelector("#pdfDom"), //需要截图的包裹的（原生的）DOM 对象
      width = shareContent.clientWidth, //获取dom 宽度
      height = shareContent.clientHeight, //获取dom 高度
      // height = canvas.height, //获取dom 高度
      canvas = document.createElement("canvas"), //创建一个canvas节点
      scale = 1.5; //定义任意放大倍数 支持小数

    html2Canvas(shareContent, {
      allowTaint: true,
      // scale: scale, // 添加的scale 参数
      // canvas: canvas, //自定义 canvas
      logging: false, //日志开关，便于查看html2canvas的内部执行流程
      // width: width, //dom 原始宽度
      // height: height,
      useCORS: true, // 【重要】开启跨域配置
      scale: 1.5,
    }).then(function (canvas) {
      let contentWidth = canvas.width;
      let contentHeight = canvas.height;
      let pageHeight = (contentWidth / 592.28) * 841.89;
      let leftHeight = contentHeight;
      let position = 0;
      let imgWidth = 595.28;
      let imgHeight = (592.28 / contentWidth) * contentHeight;
      //设置图片跨域访问
      //   img.setAttribute('crossOrigin', 'anonymous');
      let pageData = canvas.toDataURL("image/jpeg", 1.0);
      let PDF = new JsPDF('p', "pt", "a4");
      if (leftHeight < pageHeight) {
        PDF.addImage(pageData, "JPEG", 0, 0, imgWidth, imgHeight);
      } else {
        while (leftHeight > 0) {
          PDF.addImage(pageData, "JPEG", 0, position, imgWidth, imgHeight);
          leftHeight -= pageHeight;
          position -= 841.89;
          if (leftHeight > 0) {
            PDF.addPage();
          }
        }
      }
      PDF.save(name + ".pdf");
    });
  },

  //test -- 无分页
  downloadPdf(name:string) {
    window.pageYoffset = 0;
    document.documentElement.scrollTop = 0;
    document.body.scrollTop = 0;

    let shareContent:any = document.querySelector("#pdfDom"), //需要截图的包裹的（原生的）DOM 对象
      width = shareContent.clientWidth, //获取dom 宽度
      height = shareContent.clientHeight, //获取dom 高度
      // height = canvas.height, //获取dom 高度
      canvas = document.createElement("canvas"), //创建一个canvas节点
      scale = 1.5; //定义任意放大倍数 支持小数

    // console.log(tt)
    setTimeout(() => {
      html2Canvas(shareContent, {
        // allowTaint: false,这部分，最好还是不用，原因是，容易污染画布。
        scale: 2.5, // 提升画面质量，但是会增加文件大小
        useCORS: true, // 【重要】开启跨域配置
        backgroundColor: "#fff", // 一定要添加背景颜色，否则出来的图片，背景全部都是透明的
        // foreignObjectRendering: true,
      }).then(function (canvas) {
        /**jspdf将html转为pdf一页显示不截断，整体思路：
         * 1. 获取DOM
         * 2. 将DOM转换为canvas
         * 3. 获取canvas的宽度、高度（稍微大一点）
         * 4. 将pdf的宽高设置为canvas的宽高
         * 5. 将canvas转为图片
         * 6. 实例化jspdf，将内容图片放在pdf中（因为内容宽高和pdf宽高一样，就只需要一页，也防止内容截断问题）
         */

        // 得到canvas画布的单位是px 像素单位
        var contentWidth = canvas.width;
        var contentHeight = canvas.height;

        // 将canvas转为base64图片
        var pageData = canvas.toDataURL("image/jpeg", 1.0);

        // 设置pdf的尺寸，pdf要使用pt单位 已知 1pt/1px = 0.75   pt = (px/scale)* 0.75
        // 2为上面的scale 缩放了2倍
        var pdfX = ((contentWidth + 10) / 2) * 0.75;
        var pdfY = ((contentHeight + 10) / 2) * 0.75; // 10为底部留白

        // 设置内容图片的尺寸，img是pt单位
        var imgX = pdfX;
        var imgY = (contentHeight / 2) * 0.75; //内容图片这里不需要留白的距离

        // 初始化jspdf 第一个参数方向：默认''时为纵向，第二个参数设置pdf内容图片使用的长度单位为pt，第三个参数为PDF的大小，单位是pt
        var PDF = new JsPDF('p', "pt", [pdfX, pdfY]);

        // 将内容图片添加到pdf中，因为内容宽高和pdf宽高一样，就只需要一页，位置就是 0,0
        PDF.addImage(pageData, "jpeg", 0, 0, imgX, imgY);
        PDF.save(name + ".pdf");
      });
    }, 200);
  },
};
