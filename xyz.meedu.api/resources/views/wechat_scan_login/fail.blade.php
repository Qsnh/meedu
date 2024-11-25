<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>微信授权登录失败</title>
    <style>
        :root {
            --wechat-bg: #f8f8f8;
            --wechat-green: #07c160;
            --wechat-green-hover: #06ad56;
            --wechat-text: #353535;
            --wechat-text-secondary: #888888;
            --wechat-error: #fa5151;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            background-color: var(--wechat-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 320px;
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: normal;
            color: var(--wechat-text);
            text-align: center;
            margin-bottom: 1rem;
        }

        .card-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .error-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: var(--wechat-error);
            position: relative;
            margin-bottom: 1rem;
        }

        .error-icon::before,
        .error-icon::after {
            content: '';
            position: absolute;
            background-color: white;
        }

        .error-icon::before {
            width: 4px;
            height: 20px;
            top: 14px;
            left: 22px;
        }

        .error-icon::after {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            bottom: 14px;
            left: 22px;
        }

        .error-message {
            color: var(--wechat-text-secondary);
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .retry-button {
            background-color: var(--wechat-green);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .retry-button:hover {
            background-color: var(--wechat-green-hover);
        }
    </style>
</head>
<body>
<div class="card">
    <h1 class="card-title">授权登录失败</h1>
    <div class="card-content">
        <div class="error-icon"></div>
        <p class="error-message">很抱歉，微信授权登录失败。</p>
    </div>
</div>
</body>
</html>