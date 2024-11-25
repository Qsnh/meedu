<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>微信公众号登录成功</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #EDEDED;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 320px;
            text-align: center;
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: block;
            background-color: #f0f0f0;
        }

        h1 {
            color: #333;
            font-size: 20px;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            margin-bottom: 20px;
        }

        footer {
            margin-top: 30px;
            color: #999;
            font-size: 12px;
        }
    </style>
</head>
<body>
<main class="container" role="main">
    <h1>登录成功</h1>
    <p>您可以关闭当前窗口啦！</p>
</main>
<footer>
    <p>© {{date('Y')}} {{$appName}}</p>
</footer>
</body>
</html>