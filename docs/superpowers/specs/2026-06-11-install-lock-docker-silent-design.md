# Docker 静默安装补写 install.lock

- 日期:2026-06-11
- 范围:Dockerfile 运行时 CMD
- 目标:docker 静默安装完成后,install.php 不可再被访问

## 背景

`xyz.meedu.api/public/install.php:463` 通过检测 `storage/install.lock` 判定是否已安装。文件不存在则放行向导,可能覆盖 `.env`、重置配置,带来"已部署系统被意外重装"的风险。

`storage/install.lock` 目前只在两处生成:
- `xyz.meedu.api/public/install.php:698` —— 向导走到第 3 步成功后写入。
- `xyz.meedu.api/app/Console/Commands/InstallLockCommand.php:41` —— `php artisan install:lock` 命令,内部判断 `!file_exists` 后再写入。

`Dockerfile:40` 在镜像构建期跑过 `php artisan install:lock`。但生产 docker 部署普遍把 `storage` 当 volume 挂出:
- 容器启动时空 volume 覆盖镜像内的 `storage/`,构建期写入的 lock 丢失。
- 当前运行时 `CMD`(`Dockerfile:49`)是 `meedu:upgrade; install administratorOnce; nginx; php-fpm`,**没有补写 lock**。
- 结果:用户跑完静默安装,数据库已迁移、超管已建,但 `install.php` 仍可被外网触发"全新安装",可覆盖 `.env`。

## 决策

最小改动:在运行时 CMD 中,把"写 lock"挂到 `install administratorOnce` 之后,仅此一处。其它启动行为与 install.php、artisan 命令均不改。

不采用的方案:
- B(install.php 多信号检测):本次范围之外,延后议题。
- C(纵深防御 A+B):超出"修最小问题"的边界。
- D(镜像删 install.php):失去 Web 向导回退路径。

## 改动

只改 `Dockerfile:49`。

当前:
```
CMD echo "Waiting for mysql/redis to start..."; sleep 15; \
    php artisan meedu:upgrade; \
    php artisan install administratorOnce; \
    nginx; php-fpm
```

改为:
```
CMD echo "Waiting for mysql/redis to start..."; sleep 15; \
    php artisan meedu:upgrade; \
    php artisan install administratorOnce && php artisan install:lock; \
    nginx; php-fpm
```

唯一新增片段是 `&& php artisan install:lock`。其它 `;` 连接保持不变,避免顺带改动现有"失败-继续"启动语义。

构建期的 `Dockerfile:40` `php artisan install:lock` **保留**,覆盖无 volume 挂载的部署形态。

## 为什么用 `&&` 而非 `;`

把 `install:lock` 严格挂在 `install administratorOnce` 成功之后:
- `install administratorOnce` 自带幂等(`ApplicationInstallCommand.php:40-64`:管理员存在则警告但仍返回 SUCCESS),正常路径永远成功 → lock 写入。
- DB 不可达时 `install administratorOnce` 失败 → `install:lock` 不会触发 → install.php 仍可用,作为应急通道。
- `meedu:upgrade` 失败一般会让 `install administratorOnce` 跟着失败(找不到角色/管理员表),链路自动收敛到"不写 lock"。

`install:lock` 自身已是 `!file_exists` 守卫(`InstallLockCommand.php:41`),重复触发无副作用。

## 风险与权衡

| 风险 | 评估 |
| --- | --- |
| 运维删 lock 想重装 | docker 每次重启容器都会补写 lock。这是与本次目标一致的预期行为。如确需重装,需先停容器或临时改启动参数。 |
| DB 一直连不上 | lock 不会写入,install.php 仍可访问,可作恢复入口。**这是我们想要的副作用**。 |
| `install administratorOnce` 行为漂移 | 当前实现两条路径都返回 SUCCESS(已建/新建),`&&` 行为可预测。 |
| 与 `/setup` 新流程的耦合 | 与本次无关,独立议题不在范围内。 |

## 验证

无自动化测试新增。`install:lock` 自身有 `tests/Commands/InstallLockCommandTest.php` 覆盖。

手动验证清单:
- [ ] `docker build` 后,挂载空 `storage` volume 启动 → 启动完成后容器内 `ls storage/install.lock` 存在;`/install.php` 显示"检测到安装锁文件"页。
- [ ] 不挂 volume 启动 → 同上,lock 来源于构建期。
- [ ] 模拟 DB 不可达(停 mysql 容器)→ `install.lock` **不**生成,`install.php` 可访问。
- [ ] 容器二次重启 → `install:lock` 因 `!file_exists` 跳过,启动日志正常。

## 不在范围

- `install.php` 内部多信号检测(.env / DB / administrators 表),记入后续 issue。
- 非 docker 场景的"已装完不可重装"加固。
- `install administratorOnce` 与 `/setup` 新流程的协同审视(参见 ebe9ce9c "安装流程不再静默创建默认超管账号")。
