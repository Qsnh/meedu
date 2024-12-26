<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{__('支付成功')}}</title>
    <style>
        body {
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #fff;
            box-sizing: border-box;
        }

        .container {
            box-sizing: border-box;
            text-align: center;
            padding: 20px;
            width: 100%;
        }

        .success-icon {
            width: 60px;
            height: 60px;
            margin-bottom: 16px;
        }

        h1 {
            color: #07c160;
            font-size: 20px;
            margin: 0 0 12px;
            font-weight: 500;
        }

        p {
            color: #888;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
        }

        .countdown {
            color: #888;
            font-size: 14px;
            margin-top: 12px;
        }
    </style>
</head>
<body>
<div class="container">
    <svg class="success-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
              fill="#07C160"/>
        <path d="M7.5 12L10.5 15L16.5 9" stroke="white" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round"/>
    </svg>
    <h1>{{__('支付成功')}}</h1>
    <p>{{__('您的交易已完成')}}<br>{{__('请关闭页面')}}</p>
    
    @if(isset($sUrl) && $sUrl)
        <div class="countdown">{{__('页面将在')}} <span id="timer">3</span> {{__('秒后跳转')}}</div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let timeLeft = 3;
                const timerElement = document.getElementById('timer');
                
                function updateTimer() {
                    timerElement.textContent = timeLeft;
                    if (timeLeft <= 0) {
                        window.location.href = '{{ $sUrl }}';
                        return;
                    }
                    timeLeft--;
                    setTimeout(updateTimer, 1000);
                }
                
                updateTimer();
            });
        </script>
    @endif
</div>
</body>
</html>