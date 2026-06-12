# Docker 静默安装补写 install.lock 实施计划

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** 让 docker 静默部署在容器启动阶段也写入 `storage/install.lock`,堵住"已部署系统 install.php 仍可访问"的入口。

**Architecture:** 仅改 `Dockerfile` 运行时 `CMD`,在 `php artisan install administratorOnce` 之后用 `&&` 串接 `php artisan install:lock`。其它启动行为、应用代码、artisan 命令、install.php 一律不动。`install:lock` 命令本身在 `xyz.meedu.api/app/Console/Commands/InstallLockCommand.php:41` 已有 `!file_exists` 幂等守卫,重复触发无副作用。

**Tech Stack:** Dockerfile / Laravel artisan。无新增依赖。

**Spec:** `docs/superpowers/specs/2026-06-11-install-lock-docker-silent-design.md`

---

## File Structure

- 修改:`Dockerfile`(仓库根目录),仅第 49 行 `CMD` 一处。
- 不新建文件。
- 不动:`xyz.meedu.api/public/install.php`、`xyz.meedu.api/app/Console/Commands/InstallLockCommand.php`、`xyz.meedu.api/app/Console/Commands/ApplicationInstallCommand.php`、所有测试文件。

---

## Task 1: 在运行时 CMD 中补写 install.lock

**Files:**
- Modify: `Dockerfile:49`

- [ ] **Step 1: 确认 Dockerfile 当前 CMD 状态**

Run: `sed -n '49p' Dockerfile`

Expected output(单行,实际内容):
```
CMD echo "Waiting for mysql/redis to start..."; sleep 15; php artisan meedu:upgrade; php artisan install administratorOnce; nginx; php-fpm
```

如果输出与预期不符(例如已被改过或行号不对),先 `git log -p Dockerfile` 看上下文,**不要盲改**,回头同步 spec。

- [ ] **Step 2: 用 Edit 替换 CMD 行**

用 Edit 工具替换 `Dockerfile`,old_string 与 new_string 如下。整段是同一行,务必保持单引号外层、内部空格与 `;` 完全一致。

old_string:
```
CMD echo "Waiting for mysql/redis to start..."; sleep 15; php artisan meedu:upgrade; php artisan install administratorOnce; nginx; php-fpm
```

new_string:
```
CMD echo "Waiting for mysql/redis to start..."; sleep 15; php artisan meedu:upgrade; php artisan install administratorOnce && php artisan install:lock; nginx; php-fpm
```

唯一差异:`install administratorOnce` 之后的 `; ` 改成 ` && php artisan install:lock; `。其它 `;` 一个都不要动。

- [ ] **Step 3: 复核改动**

Run: `git diff Dockerfile`

Expected:只有第 49 行被改;diff 中新增片段精确包含 ` && php artisan install:lock`;`meedu:upgrade`、`administratorOnce`、`nginx`、`php-fpm` 之间的其余分隔符均保持 `;`。

如果 diff 显示其它行也变了(比如编辑器顺手 trim 了行尾、改了换行符),撤回 `git checkout -- Dockerfile` 重做。

- [ ] **Step 4: 语法静态校验**

Run:
```
docker --version
docker build --check . 2>&1 | head -40 || true
```

说明:
- 没有装 docker 也没关系,跳过该步。
- `--check` 在新版 docker buildx 上可做 lint;仅用于发现 Dockerfile 语法层面的低级错误,不强求通过(只要不出现 `Dockerfile parse error` 或 `unknown instruction` 即可)。

- [ ] **Step 5: 提交**

```bash
git add Dockerfile
git commit -m "$(cat <<'EOF'
修复:[Docker]静默安装在容器启动阶段补写 install.lock

挂载 storage volume 后构建期写入的 install.lock 会被空 volume 覆盖,
导致 install.php 仍可访问。在运行时 CMD 中用 && 把 install:lock
挂在 install administratorOnce 成功之后,DB 不可达时不会写入,
保留 install.php 作为应急通道。

Refs: docs/superpowers/specs/2026-06-11-install-lock-docker-silent-design.md
EOF
)"
```

---

## Task 2: 手动验证清单(交付前由发起人/运维执行)

**Files:** 无代码改动。本任务仅产出验证记录。

- [ ] **Step 1: 构建镜像**

Run:
```
docker build -t meedu-install-lock-verify .
```

Expected:构建成功,无报错。

- [ ] **Step 2: 场景 A — 挂载空 storage volume 启动**

Run(把 MySQL/Redis 接入方式替换成你的实际编排;下面用最简的临时 volume 表达):
```
docker run --rm -d --name meedu-vol \
  -v meedu-storage-test:/var/www/api/storage \
  -e DB_HOST=<mysql> -e DB_PORT=3306 -e DB_DATABASE=<db> \
  -e DB_USERNAME=<user> -e DB_PASSWORD=<pass> \
  meedu-install-lock-verify
sleep 25
docker exec meedu-vol ls -l /var/www/api/storage/install.lock
docker exec meedu-vol curl -sS -o /tmp/out.html -w '%{http_code}\n' http://127.0.0.1:8000/install.php
docker exec meedu-vol grep -o '检测到安装锁文件' /tmp/out.html
docker rm -f meedu-vol
docker volume rm meedu-storage-test
```

Expected:
- `ls -l ... install.lock` 显示文件存在、大小非 0。
- `install.php` HTTP 状态为 200,响应体含"检测到安装锁文件"字样。

- [ ] **Step 3: 场景 B — 不挂 volume 启动**

Run:
```
docker run --rm -d --name meedu-novol \
  -e DB_HOST=<mysql> -e DB_PORT=3306 -e DB_DATABASE=<db> \
  -e DB_USERNAME=<user> -e DB_PASSWORD=<pass> \
  meedu-install-lock-verify
sleep 25
docker exec meedu-novol ls -l /var/www/api/storage/install.lock
docker rm -f meedu-novol
```

Expected:`install.lock` 同样存在(构建期已写入;运行时再次触发 `install:lock` 因 `!file_exists` 跳过,无副作用)。

- [ ] **Step 4: 场景 C — DB 不可达**

Run(不连数据库,模拟 mysql 还没起):
```
docker run --rm -d --name meedu-nodb \
  -v meedu-storage-nodb:/var/www/api/storage \
  -e DB_HOST=127.0.0.1 -e DB_PORT=1 \
  -e DB_DATABASE=x -e DB_USERNAME=x -e DB_PASSWORD=x \
  meedu-install-lock-verify
sleep 30
docker exec meedu-nodb ls -l /var/www/api/storage/install.lock || echo "NOT_FOUND (expected)"
docker exec meedu-nodb curl -sS -o /tmp/out.html -w '%{http_code}\n' http://127.0.0.1:8000/install.php
docker exec meedu-nodb grep -q '环境检测\|数据库配置' /tmp/out.html && echo "INSTALL_PHP_REACHABLE (expected)"
docker rm -f meedu-nodb
docker volume rm meedu-storage-nodb
```

Expected:
- `install.lock` 不存在(因为 `install administratorOnce` 在没有 role/admin 表时会失败,`&&` 阻止后续 `install:lock`)。
- `install.php` 仍可访问,显示环境检测或数据库配置页面 —— 这是我们想要的"应急通道"行为。

- [ ] **Step 5: 场景 D — 容器二次启动幂等**

Run(以场景 A 的 volume 为例):
```
docker run --rm -d --name meedu-vol \
  -v meedu-storage-test:/var/www/api/storage \
  -e DB_HOST=<mysql> -e DB_PORT=3306 -e DB_DATABASE=<db> \
  -e DB_USERNAME=<user> -e DB_PASSWORD=<pass> \
  meedu-install-lock-verify
sleep 25
docker logs meedu-vol | tail -50
docker exec meedu-vol stat -c '%Y' /var/www/api/storage/install.lock
docker rm -f meedu-vol
```

Expected:`install:lock` 命令日志没有报错;`install.lock` 的 mtime 与首次启动一致(`InstallLockCommand.php:41` 已经判断 `!file_exists`,所以不会重写)。

- [ ] **Step 6: 记录验证结论**

把以上四个场景的实际输出粘到 PR 描述或对话里,作为本次改动的验收证据。

---

## Self-Review

- **Spec 覆盖**:spec 中 "改动范围 / 改动内容 / 为什么用 && / 风险与权衡 / 验证" 五块均映射到 Task 1 (步骤 1-5) 和 Task 2 (步骤 1-6)。"构建期 install:lock 是否保留" 的决定在 Task 1 步骤 2 体现(只改一行,构建期那行不动)。
- **Placeholder 扫描**:无 TBD/TODO;所有"appropriate / handle edge cases"类模糊措辞已消除;每一步都给了具体命令和期望输出。
- **类型/命名一致**:全文统一使用 `install:lock`、`install administratorOnce`、`storage/install.lock`、`Dockerfile:49`,与 spec 一致。
- **范围合理**:一个分支、一行代码、一次提交,可独立交付。手动验证作为独立 Task 不阻塞代码合并,但是上线前必做项。
