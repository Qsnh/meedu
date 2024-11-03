<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>微信公众号登录</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .container {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            color: #07c160;
            text-align: center;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        p {
            color: #666;
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .btn-wechat {
            background-color: #07c160;
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 4px;
            width: 100%;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }

        .btn-wechat:hover, .btn-wechat:focus {
            background-color: #06ad56;
        }

        .btn-wechat::before {
            content: "";
            display: inline-block;
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M4 11.9C4 7.6 7.6 4 12 4s8 3.6 8 7.9c0 4.3-3.6 7.9-8 7.9-1 0-1.9-.2-2.8-.5l-2.7 1.5c-.3.2-.7 0-.8-.3v-2.9c-1.1-1.3-1.7-3-1.7-4.7z'%3E%3C/path%3E%3C/svg%3E");
            background-size: contain;
            margin-right: 0.5rem;
        }

        .terms {
            margin-top: 1rem;
            display: flex;
            align-items: flex-start;
        }

        .terms input[type="checkbox"] {
            margin-right: 0.5rem;
            margin-top: 0.25rem;
        }

        .terms label {
            font-size: 0.8rem;
            color: #666;
            line-height: 1.4;
        }

        .terms a {
            color: #07c160;
            text-decoration: none;
        }

        .terms a:hover, .terms a:focus {
            text-decoration: underline;
        }

        footer {
            margin-top: 1.5rem;
            color: #999;
            font-size: 0.75rem;
            text-align: center;
        }

        @media (max-width: 480px) {
            .container {
                padding: 1rem;
            }

            h1 {
                font-size: 1.3rem;
            }

            p {
                font-size: 0.85rem;
            }

            .btn-wechat {
                font-size: 0.9rem;
            }

            .terms label {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>微信公众号登录</h1>
    <p>使用您的微信账号登录</p>
    <button onclick="handleLogin()" class="btn-wechat">微信登录</button>
    <div class="terms">
        <input type="checkbox" id="agree" required>
        <label for="agree">
            我已阅读并同意
            <a href="{{route('user.protocol')}}" target="_blank">用户协议</a>
            和
            <a href="{{route('user.private_protocol')}}" target="_blank">隐私政策</a>
        </label>
    </div>
</div>
<footer>
    © {{date('Y')}} {{$appName}}
</footer>

<script>
    function handleLogin() {
        const agreeCheckbox = document.getElementById('agree');
        if (!agreeCheckbox.checked) {
            alert('请先同意用户协议和隐私政策');
            return;
        }
        window.location.href = '{!! $loginUrl !!}';
    }
</script>
</body>
</html>