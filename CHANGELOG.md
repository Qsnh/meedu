
> 该日志改为只记录较大更新的变动记录.

## 2018/10/26

+ Added:移除余额直接充值的功能，视频，课程，VIP现在直接下单购买

## 2018/10/24

+ Fixed:后台权限整理

## 2018/10/17

+ Added:注册需要验证短信验证码

## 2018/10/16

+ Added:API接口的单元测试

## 2018/10/11

+ Added:基本完成meedu的API接口

## 2018/10/10

+ Added:视频API接口
+ Added:课程API接口
+ Added:接口文档
+ Added:FAQ接口

## 2018/10/8

+ Fixed:Font-Awesome的cdn引用修改
+ Added:前端资源文件版本控制 issue #3
+ Fixed:登录出错没有消息提示 issue #2
+ Fixed:阿里云视频SDK服务默认Autoloader名于其它扩展包冲突导致无法安装 issue #4
+ Added:将laravel框架版本升级到5.7.*

## 2018/10/7

+ Added:图片的特殊参数(用于第三方云存储下的图片压缩展示)
+ Added:阿里云视频服务作为meedu的默认视频服务，已完成后台的本地上传和前台的播放器集成

## 2018/10/2

+ Added:echojs改为本地引入
+ Added:使用Layx作为前台的消息展示
+ Added:缓存开关和单元测试
+ Added:阿里云的邮件发送服务作为meedu的默认邮件服务，并增加后台配置

## 2018/9/30

+ Fixed:后台视频列表页面在添加视频之后无法渲染
+ Fixed:文案"登陆"改为"登录"

## 2018/9/29

+ Fixed:视频和课程评论的xss漏洞

## 2018/9/27

+ 测试版本发布

## 2018/9/25

+ Added:系统所有css均转换为scss
+ Fixed:课程购买行为单元测试错误

## 2018/9/24

+ Added:后台会员详情面板
+ Added:短信配置gui
+ Fixed:单元测试错误
+ Optimized:优化代码
+ 调整课程详情界面的视频列表布局

## 2018/9/23

+ Added:FAQ
+ Optimized:后台界面样式优化
+ Added:基本完成前台的单元测试

## 2018/9/22

+ Added:全站配置可视化
+ 优化部分代码
+ Fixed:会员中心的最近学习板块展示bug
+ Added:会员密码重置单元测试
+ Added:会员课程购买记录单元测试
+ Added:会员视频购买记录单元测试
+ Added:会员VIP角色购买记录单元测试
+ Added:FAQ后台管理

## 2018/9/21

+ Added:会员角色界面单元测试
+ Added:会员订单界面单元测试
+ Added:用户头像更换单元测试
+ Added:登录/注册界面单元测试
+ Fixed:单元测试偶尔报错bug

## 2018/9/18

+ Added:数据定时备份
+ Added:style.ci 代码格式检测
+ Added:php-cs-fixer 代码自动格式化
+ Added:用户购买课程，视频，会员的消息通知