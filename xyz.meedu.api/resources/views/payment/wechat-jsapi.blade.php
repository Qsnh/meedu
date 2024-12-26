<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{__('微信支付')}}</title>
    <style>
        :root {
            --primary-color: #07c160;
            --error-color: #fa5151;
            --background-color: #f8f8f8;
            --text-color: #333;
            --secondary-text-color: #666;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Helvetica Neue', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        .header {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 16px;
            font-size: 18px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 32px 20px;
            max-width: 600px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
        }

        .status-icon {
            font-size: 64px;
            margin-bottom: 24px;
            transition: all 0.3s ease;
            opacity: 0;
            transform: scale(0.8);
            width: 64px;
            height: 64px;
        }

        .status-icon svg {
            width: 100%;
            height: 100%;
        }

        .success-icon {
            fill: var(--primary-color);
        }

        .error-icon {
            fill: var(--error-color);
        }

        .status-icon.show {
            opacity: 1;
            transform: scale(1);
        }

        .status-text {
            font-size: 18px;
            margin-bottom: 16px;
            transition: color 0.3s ease;
            text-align: center;
        }

        .amount {
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 24px;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .amount-symbol {
            font-size: 24px;
            color: var(--secondary-text-color);
        }

        .loading {
            width: 48px;
            height: 48px;
            border: 3px solid rgba(7, 193, 96, 0.1);
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            margin-bottom: 24px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.3s ease forwards;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }

        .button {
            padding: 8px 20px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }

        .primary-button {
            background-color: var(--primary-color);
            color: white;
        }

        .primary-button:hover {
            opacity: 0.9;
        }

        .secondary-button {
            background-color: #f5f5f5;
            color: var(--secondary-text-color);
            border: 1px solid #ddd;
        }

        .secondary-button:hover {
            background-color: #eee;
        }
    </style>
</head>
<body>
<div class="header">{{__('微信支付')}}</div>
<div class="content">
    <div id="loadingIcon" class="loading"></div>
    <div id="statusIcon" class="status-icon" style="display: none;"></div>
    <div id="statusText" class="status-text">{{__('正在支付')}}</div>
    <div id="redirectText" class="status-text" style="display: none; font-size: 14px; color: var(--secondary-text-color);"></div>
    <div id="buttonGroup" class="button-group" style="display: none;">
        <button onclick="location.reload()" class="button primary-button">{{__('继续支付')}}</button>
        <button onclick="window.location.href='{{$fUrl}}'" class="button secondary-button">{{__('取消支付')}}</button>
    </div>
</div>

<script>
    function updatePaymentStatus(isSuccess) {
        const loadingIcon = document.getElementById('loadingIcon');
        const statusIcon = document.getElementById('statusIcon');
        const statusText = document.getElementById('statusText');
        const redirectText = document.getElementById('redirectText');

        loadingIcon.style.display = 'none';
        statusIcon.style.display = 'block';
        
        setTimeout(() => {
            statusIcon.classList.add('show');
        }, 10);

        if (isSuccess) {
            statusIcon.innerHTML = `
                <svg class="success-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            `;
            statusText.textContent = '支付成功';
            statusText.style.color = 'var(--primary-color)';
            
            @if(!empty($sUrl))
                redirectText.style.display = 'block';
                let countdown = 2;
                const timer = setInterval(() => {
                    redirectText.textContent = `${countdown} 秒后自动跳转...`;
                    countdown--;
                    if (countdown < 0) {
                        clearInterval(timer);
                        window.location.href = '{{$sUrl}}';
                    }
                }, 1000);
            @endif
        } else {
            statusIcon.innerHTML = `
                <svg class="error-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
                </svg>
            `;
            statusText.textContent = '{{__("支付失败")}}';
            statusText.style.color = 'var(--error-color)';
            
            @if(!empty($fUrl))
                const buttonGroup = document.getElementById('buttonGroup');
                buttonGroup.style.display = 'flex';
            @endif
        }
    }

    function onBridgeReady() {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest', {
                "appId": "{{$data['appId']}}",     //公众号名称，由商户传入
                "timeStamp": "{{$data['timeStamp']}}",         //时间戳，自1970年以来的秒数
                "nonceStr": "{{$data['nonceStr']}}", //随机串
                "package": "{{$data['package']}}",
                "signType": "{{$data['signType']}}",         //微信签名方式：
                "paySign": "{{$data['paySign']}}" //微信签名
            },
            function (res) {
                updatePaymentStatus(res.err_msg === "get_brand_wcpay_request:ok");
            });
    }

    if (typeof WeixinJSBridge == "undefined") {
        if (document.addEventListener) {
            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
        } else if (document.attachEvent) {
            document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
            document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
        }
    } else {
        onBridgeReady();
    }
</script>
</body>
</html>