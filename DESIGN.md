---
name: MeEdu
description: 数据自托管的开源网校 / 知识付费系统的视觉规范——Ant Design 之上的克制收敛层
colors:
  primary: "#3ca7fa"
  primary-legacy: "#409eff"
  success: "#04c877"
  warning: "#e1a500"
  danger: "#ff4d4f"
  neutral-bg: "#ffffff"
  neutral-bg-soft: "#f4fafe"
  surface-elevated: "#ffffff"
  text-primary: "#213547"
  text-secondary: "#00000073"
  text-tertiary: "#999999"
  divider: "#e5e5e5"
  selection: "#3ca7fa"
typography:
  display:
    fontFamily: "Inter, system-ui, Avenir, Helvetica, Arial, sans-serif"
    fontSize: "24px"
    fontWeight: 500
    lineHeight: 1
    letterSpacing: "normal"
  title:
    fontFamily: "Inter, system-ui, Avenir, Helvetica, Arial, sans-serif"
    fontSize: "16px"
    fontWeight: 500
    lineHeight: 1.5
    letterSpacing: "normal"
  body:
    fontFamily: "Inter, system-ui, Avenir, Helvetica, Arial, sans-serif"
    fontSize: "14px"
    fontWeight: 400
    lineHeight: 1.5
    letterSpacing: "normal"
  label:
    fontFamily: "Inter, system-ui, Avenir, Helvetica, Arial, sans-serif"
    fontSize: "12px"
    fontWeight: 400
    lineHeight: 2
    letterSpacing: "normal"
rounded:
  sm: "4px"
  md: "8px"
  pill: "15px"
spacing:
  xs: "4px"
  sm: "8px"
  md: "16px"
  lg: "24px"
  xl: "32px"
  xxl: "48px"
components:
  button-primary:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.neutral-bg}"
    rounded: "{rounded.sm}"
    padding: "4px 16px"
    height: "32px"
  button-primary-hover:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.neutral-bg}"
  button-ghost:
    backgroundColor: "{colors.neutral-bg}"
    textColor: "{colors.text-primary}"
    rounded: "{rounded.sm}"
    padding: "4px 16px"
  input-default:
    backgroundColor: "{colors.neutral-bg}"
    textColor: "{colors.text-primary}"
    rounded: "{rounded.sm}"
    padding: "4px 12px"
    height: "32px"
  card-default:
    backgroundColor: "{colors.surface-elevated}"
    rounded: "{rounded.sm}"
    padding: "24px"
  nav-sidebar:
    backgroundColor: "{colors.neutral-bg}"
    textColor: "{colors.text-primary}"
    width: "200px"
  chip-tag:
    backgroundColor: "{colors.neutral-bg-soft}"
    textColor: "{colors.primary}"
    rounded: "{rounded.sm}"
    padding: "0 8px"
    height: "22px"
---

# Design System: MeEdu

## 1. Overview

**Creative North Star: "运营人员的工作台 / The Operator's Console"**

MeEdu 的视觉系统不是一份品牌宣言，是一张**工作台桌面**。运营人员每天要在这张桌面上完成订单核销、课程上下架、学员管理、内容审核与异常排查；学员要在 pc/h5 端不被打断地完成"找课 → 购买 → 学习"。系统的工作是让这两种心流都不掉线——而不是让人停下来欣赏 UI。

这意味着默认色是 Ant Design 的中性灰白，主色 `#3ca7fa` 是一束**克制的天空蓝**，只在交互节点上点亮（按钮、链接、聚焦、选区），从不平铺到大块表面上。视觉密度向桌面 B 端工具看齐（腾讯课堂 / Stripe Dashboard / 后台型 SaaS），不向 K12 教育网站、微商课程页或老派 OA 系统看齐。

这套系统明确**拒绝**：花哨的卡通插画与彩虹渐变；满屏倒计时与"已有 XXX 人购买"的伪从众小红字；左侧深蓝竖条 + 顶部灰蓝渐变的老派 OA 默认皮；任何"一眼能认出是 AI 套模板"的玻璃卡片 / 渐变文字 / 通用 hero 模板。

**Key Characteristics:**

- 中性灰白底面 + 单一天空蓝点缀，色彩出现频率 ≤10%
- Antd 5 默认结构 + 项目级精修，不重写组件而是收敛 token
- 信息密度向 B 端工具靠拢——表格、统计、筛选区不靠加大间距显档次
- 异常状态（红 `#ff4d4f` / 黄 `#e1a500`）享有视觉优先权
- 静态层级——阴影仅用于浮起态，不用于装饰
- 4 个端共享 token：`api / admin / pc / h5`

## 2. Colors

调色板是一束克制的天空蓝叠在中性灰白上，再加四个语义色用作状态信号。色彩本身不是视觉主语，状态才是。

### Primary

- **Sky Blue 天空蓝** (`#3ca7fa`): Antd `colorPrimary` 主色。出现在主按钮、链接、表单聚焦、Tab 高亮、文本选区。**任意单屏内出现频率 ≤10%**——它是"该操作"的信号，不是装饰背景。

### Secondary

无次要主色。状态色（下方"Status"组）承担类似次主色的注意力，但语义不同——它们只在异常/进度场景出现。

### Status

- **Danger 红** (`#ff4d4f`): 仅用于错误、删除确认、订单失败、内容下架、未通过审核。不可用作装饰红。
- **Warning 黄** (`#e1a500`): 仅用于待处理、即将过期、配置缺失、需要管理员介入。不可用作主色调或大块背景。
- **Success 绿** (`#04c877`): 仅用于成功完成、已发布、已通过、已支付。不可用于"在线"装饰小圆点之外的氛围用途。

### Neutral

- **Surface 白** (`#ffffff`): admin 主表面、侧边栏、卡片、模态背景。绝对禁止 `#fff` 直写——使用 token 引用。
- **Soft Sky 浅天空** (`#f4fafe`): 仅用于学员端 (pc) 全局底色，让学员侧比 admin 多一点温度，但保持同一冷色家族。
- **Text Primary** (`#213547`): 正文、表格内容、表单标签默认文本色。不是纯黑 `#000`——这点是项目的克制基线。
- **Text Secondary** (`#00000073` / rgba 0,0,0,0.45): helper-text、辅助说明、placeholder。
- **Text Tertiary 灰** (`#999999`): 时间戳、表格次要列、禁用态文本。
- **Divider** (`#e5e5e5`): 分割线、滚动条 thumb、卡片边框。

### Named Rules

**The One-Voice Rule（一票通过律）.** 主色 `#3ca7fa` 是单一发声口。任意单屏内主色覆盖面积 ≤10%。如果一屏出现两片以上的实蓝色面板，说明在用色彩贴标签，回去用层级和字重重做。

**The Status-Reserves Rule（状态色保留律）.** 红 / 黄 / 绿三色**只为状态而存在**。一个绿色 chip 用来装饰"全部分类"就是误用——它会稀释生产环境中"真正成功"那条信号的视觉权重。

**The Legacy-Blue Sundown Rule（旧蓝退役律）.** 项目里存在历史遗留蓝 `#409eff`（`c-blue` / `c-primary` 工具类）。**新代码禁止引用**，老代码遇到即顺手替换为 `#3ca7fa`。两条主色并存等于没有主色。

## 3. Typography

**Display / Body Font:** Inter, system-ui, Avenir, Helvetica, Arial, sans-serif

**Character:** 单一无衬线家族贯穿全产品——Inter 在西文上几何感强、字距可控；系统字体兜底确保中文环境下使用 PingFang / Microsoft YaHei 的原生字形。不引入展示字体，不用宋体作 display——MeEdu 不卖"文化感"，卖"靠谱感"。

### Hierarchy

- **Display** (`24px / 500 / 1.0`): 页面主标题、登录页"欢迎"标题。一屏一处，不重复使用作 section 标题。
- **Title** (`16px / 500 / 1.5`): 卡片标题、模态标题、表单分组标题。
- **Body** (`14px / 400 / 1.5`): Antd 默认正文。表单、表格、菜单、按钮内文。正文行宽控制在 65–75ch 以内（长描述、协议文本类容器需要显式约束 max-width）。
- **Label** (`12px / 400 / 24px line-height`): `.helper-text` 辅助说明、表单提示、时间戳、表格次要信息。

### Named Rules

**The Density-Over-Whitespace Rule（密度优先律）.** admin 是工作面板。表格行高、卡片内边距向 Antd 默认（compact / middle）看齐，不靠加 padding 显高级。行距加大只为长文阅读区，不为表格"显气派"。

**The Plain-Speech Rule（朴素表达律）.** 标题不写鸡汤，按钮不写"立即开启您的精彩之旅"。运营场景下文案是工具的一部分，每个字都要为操作服务。

## 4. Elevation

系统**默认是平的**。深度来自边框、底色对比与层级排版，不来自阴影。阴影是状态的产物——浮起、聚焦、模态——而不是装饰。

### Shadow Vocabulary

- **Resting**: 无阴影。卡片、表格、侧边栏在静止态都是平的，用 1px `#e5e5e5` 边框或底色差分层。
- **Lifted** (`box-shadow: 20px 20px 100px 0 rgba(85, 102, 119, 0.1)`): 登录卡、初始化向导主面板使用的**长柔阴影**。偏移大、模糊大、不透明度低——产生"漂浮在工作台上方"的感觉，不产生厚重感。这是 MeEdu 的签名阴影。
- **Floating**: 模态、Drawer、Popover 沿用 Antd 默认（短偏移高模糊），不再叠加自定义阴影。

### Named Rules

**The Flat-By-Default Rule（默认平面律）.** 静止表面无阴影。如果你在一个不会被浮起的卡片上加阴影，就把它换成 1px 边框或底色 token。卡片不是"重要"的同义词。

**The Signature-Shadow Rule（签名阴影律）.** 长柔阴影 `20px 20px 100px rgba(85, 102, 119, 0.1)` 只用于真正离开了工作台层的元素（登录卡、空态启动门、关键引导）。日常表格、模态、Drawer 都不用它——稀有性是它的全部意义。

## 5. Components

### Buttons

- **Shape:** 4px 圆角（`{rounded.sm}`）。不使用大圆角（>8px）按钮——大圆角会让 B 端按钮显得轻浮。
- **Primary:** 背景 `#3ca7fa`、白字、高度 32px、内边距 `4px 16px`。Antd `<Button type="primary" />` 默认。
- **Hover / Focus:** 沿用 Antd 默认 hover 略亮、focus 描边 2px 同色。**不允许**自定义 hover 颜色、不允许平移 / 阴影动效。
- **Ghost / Default:** 白底 + `#d9d9d9` 边框 + `#213547` 文字，用于次要操作。
- **Danger:** Antd `danger` 属性，背景 `#ff4d4f`，只用于不可逆动作（删除、解绑、清空）。一屏最多一个 danger 按钮。

### Chips / Tags

- **Style:** 浅天空底 `#f4fafe`、主色文字 `#3ca7fa`、4px 圆角、22px 高度。
- **State:** 用于分类标签、用户身份、订单状态标签。状态色版本（红/黄/绿）使用 Antd `<Tag color="..." />` 配套底色，**不要用主色版式硬套状态色**。

### Cards / Containers

- **Corner Style:** 4px（`{rounded.sm}`）。
- **Background:** `#ffffff`。pc 端在 `#f4fafe` 底色上时仍保持白卡。
- **Shadow Strategy:** 默认无阴影 + 1px `#e5e5e5` 边框。仅 hero 级浮起元素使用签名长柔阴影。
- **Internal Padding:** `24px`（`{spacing.lg}`）。表格类容器内的卡片用 `16px`。
- **Nested Cards:** **禁止**。卡内再嵌卡是层级失败的征兆——改用 divider 或分组 title。

### Inputs / Fields

- **Style:** 白底、1px `#d9d9d9` 边框、4px 圆角、32px 高度、`4px 12px` 内边距。Antd 默认。
- **Focus:** 边框转 `#3ca7fa`、外发光 2px 同色半透明。沿用 Antd。
- **Error:** 边框 `#ff4d4f` + 下方 12px `#ff4d4f` 文字。错误信息必须说明**原因和下一步动作**，不可只写"输入有误"。

### Navigation

- **Sidebar:** 固定 200px 白底，垂直滚动 6px 细滚动条、`#e5e5e5` thumb。当前菜单项用主色文字 + 浅天空底色 `#f4fafe`。
- **Top Bar:** Antd Layout.Header 默认，不增加阴影；底部 1px `#e5e5e5` 分割线。
- **Mobile (h5):** 顶部固定栏 + 底部 Tab，主色用于当前 Tab 文字与图标。

### Status Cells（签名组件 / Signature Component）

表格中的"状态列"是 MeEdu admin 的核心场景。规范：

- **结构:** 8px 圆点 + 4px 间距 + 文字标签。
- **颜色:** 严格遵循"Status 调色板"——红/黄/绿不能改义。
- **可读性:** **不允许仅用颜色区分状态**，必须同时存在文字。这是无障碍底线，也是导出 / 截图 / 黑白打印场景的要求。

### Captcha / Inline Action Blocks

- **Style:** 浅天空底 `rgba(60,167,250,0.1)`、8px 圆角、48px 高度。
- **使用场景:** 验证码、内嵌的辅助操作块。比主输入框圆角更大（8px vs 4px），让"非主体"信号清晰。

## 6. Do's and Don'ts

### Do:

- **Do** 用 token 引用代替硬编码——`#3ca7fa` 写在 main.tsx 一处，其余都通过 Antd `theme.token` 或 CSS 变量消费。
- **Do** 把异常状态做成视觉头牌——红色 `#ff4d4f` + 文字 + 图标三位一体，确保运营"一眼定位异常"。
- **Do** 在长流程页面（设置向导、批量编辑）使用签名长柔阴影 `20px 20px 100px rgba(85, 102, 119, 0.1)`，让关键面板从工作台漂起来。
- **Do** 错误提示原位说清楚原因和下一步动作。
- **Do** 学员端 (pc/h5) 优先使用 toast / 顶部条 / inline 提示，**不用 modal 兜底任何可以 inline 完成的反馈**——保护学员心流。
- **Do** 把 `c-blue` / `c-primary` 工具类里的遗留 `#409eff` 顺手替换为 `#3ca7fa`（旧蓝退役律）。

### Don't:

- **Don't** 用卡通插画、彩虹渐变、奖章弹窗、放大成就动画——这是 K12 教育站的语言，与运营 / 职业学员场景不匹配。
- **Don't** 用满屏倒计时、滚动小红字、"已有 XXX 人购买"伪从众提示、闪烁加粗价格——这是微商课程页的语言，会破坏交易系统的可信度。
- **Don't** 套用左侧深蓝竖条 + 顶部灰蓝渐变 + Antd 默认主色的"工程师顺手搭"组合——这是老派 OA 后台的语言。
- **Don't** 写彩色玻璃卡片、渐变文字（`background-clip: text`）、大圆角通用 hero 模板——任何一眼能被识别为"AI 套模板"的元素。
- **Don't** 用 `border-left` > 1px 当彩色饰条加在卡片 / 列表 / Alert 上。改用整边框、底色 tint 或左侧图标。
- **Don't** 主色面积超过单屏 10%（One-Voice Rule）。蓝色按钮 + 蓝色 chip + 蓝色顶部条同屏出现就是失败信号。
- **Don't** 用绿色作"全部分类"装饰底——绿色专供"成功 / 通过 / 已支付"（Status-Reserves Rule）。
- **Don't** 嵌套卡片。卡内再开卡 = 层级失败。
- **Don't** 学员看视频时弹 modal 推送活动 / 推荐 / 升级——心流不被弹窗打断（PRODUCT.md 第 3 原则）。
- **Don't** 在静止表面上加阴影装饰。阴影是状态信号，不是装饰（Flat-By-Default Rule）。
- **Don't** 在按钮 / 标题 / 表格里用 emoji——B 端工具的"专业"语气不允许 emoji。
