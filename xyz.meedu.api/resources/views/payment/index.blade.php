<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>收银台</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #EDEDED;
            color: #333333;
        }

        .header {
            background-color: #3ca7fa;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }

        .order-info {
            background-color: white;
            margin: 15px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .order-info div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            align-items: center;
        }

        .order-info div > span:first-child {
            color: #666;
            font-size: 14px;
        }

        .order-info div > span:last-child {
            font-family: -apple-system, "SF Pro Display", "Helvetica Neue", sans-serif;
            font-size: 16px;
            font-weight: 500;
        }

        .order-info .amount {
            color: #3ca7fa;
            font-size: 28px !important;
            font-weight: bold;
            font-family: -apple-system, "SF Pro Display", "Helvetica Neue", sans-serif !important;
        }

        .order-info .discount {
            color: #FF6B6B;
            font-family: -apple-system, "SF Pro Display", "Helvetica Neue", sans-serif;
            font-weight: 500;
        }

        .order-info .order-id {
            font-family: "SF Mono", Consolas, Monaco, monospace;
            letter-spacing: 0.5px;
            color: #666;
        }

        .payment-methods {
            background-color: white;
            margin: 15px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .payment-methods h2 {
            font-size: 16px;
            color: #666;
            margin: 0 0 15px 0;
            font-weight: normal;
        }

        .payment-method {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border: 1px solid #EDEDED;
            border-radius: 8px;
            margin-bottom: 12px;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .payment-method:last-child {
            margin-bottom: 0;
        }

        .payment-method.selected {
            background-color: #F7F7F7;
            border-color: #3ca7fa;
        }

        .payment-method-icon {
            width: 32px;
            height: 32px;
            margin-right: 12px;
        }

        .payment-method-name {
            font-size: 15px;
            font-weight: 500;
            color: #333;
        }

        .radio {
            width: 18px;
            height: 18px;
            border: 2px solid #DDDDDD;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            transition: all 0.2s ease;
        }

        .radio.selected {
            border-color: #3ca7fa;
            background-color: #3ca7fa;
        }

        .radio.selected::after {
            content: '';
            width: 8px;
            height: 8px;
            background-color: white;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .confirm-button {
            position: fixed;
            bottom: 20px;
            left: 15px;
            right: 15px;
            background-color: #3ca7fa;
            color: white;
            border: none;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            width: calc(100% - 30px);
        }

        .confirm-button:disabled {
            background-color: #9ED2FA;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            opacity: 1;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 20% auto;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
            position: relative;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s ease;
            max-width: 320px;
            width: 85%;
            box-sizing: border-box;
        }

        .modal.show .modal-content {
            transform: translateY(0);
            opacity: 1;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h2 {
            font-size: 18px;
            color: #333;
            margin: 0;
            font-weight: 500;
        }

        .close {
            color: #999;
            font-size: 24px;
            font-weight: normal;
            cursor: pointer;
            padding: 5px;
            line-height: 1;
            transition: color 0.2s ease;
        }

        .close:hover {
            color: #666;
        }

        .modal-body {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
        }

        .modal-body p {
            margin: 0 0 12px 0;
        }

        .modal-body .bank-info {
            background-color: #F7F7F7;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }

        .modal-body .copy-btn {
            background-color: #3ca7fa;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .modal-body .copy-btn:hover {
            background-color: #2b96e9;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .loading::after {
            content: '';
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 2px solid #FFF;
            border-radius: 50%;
            border-top: 2px solid transparent;
            animation: spin 1s linear infinite;
            margin-left: 10px;
            vertical-align: middle;
        }

        .refresh-btn {
            background-color: #3ca7fa;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.2s ease;
        }

        .refresh-btn:hover {
            background-color: #2b96e9;
        }

        #paymentModal .modal-content {
            text-align: center;
            padding: 20px;
        }

        #paymentModal .modal-header {
            margin-bottom: 20px;
            justify-content: center;
        }

        #paymentModal .modal-header h2 {
            font-size: 18px;
            color: #333;
            margin: 0;
            font-weight: 500;
        }

        #paymentModal .modal-body p {
            color: #666;
            line-height: 1.5;
            margin-bottom: 12px;
            font-size: 14px;
        }

        #paymentModal .modal-body p:first-child {
            font-size: 15px;
        }

        #paymentModal .refresh-btn {
            background-color: #3ca7fa;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(60, 167, 250, 0.3);
            width: auto;
            max-width: 100%;
        }

        #paymentModal .refresh-btn:hover {
            background-color: #2b96e9;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(60, 167, 250, 0.4);
        }

        #paymentModal .refresh-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(60, 167, 250, 0.3);
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        #paymentModal .loading-dots {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        #paymentModal .loading-dots span {
            width: 6px;
            height: 6px;
            margin: 0 3px;
            background-color: #3ca7fa;
            border-radius: 50%;
            display: inline-block;
            animation: bounce 1s infinite;
        }

        #paymentModal .loading-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        #paymentModal .loading-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        .button-group {
            position: fixed;
            bottom: 20px;
            left: 15px;
            right: 15px;
            display: flex;
            gap: 12px;
        }

        .cancel-button {
            background-color: #f5f5f5;
            color: #666;
            border: none;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            flex: 1;
            transition: background-color 0.2s ease;
        }

        .cancel-button:active {
            background-color: #e8e8e8;
        }

        .confirm-button {
            position: static;
            flex: 1;
            width: auto;
        }
    </style>
</head>
<body>
<div class="header">收银台</div>

<div class="order-info">
    <div>
        <span>订单编号</span>
        <span class="order-id">{{$order['order_id']}}</span>
    </div>
    <div>
        <span>商品名称</span>
        <span>{{$orderGoodsList[0]['goods_name']}}</span>
    </div>
    <div>
        <span>原价</span>
        <span>¥{{$order['charge']}}</span>
    </div>
    @if($promoCodePaidRecord)
        <div>
            <span>优惠码抵扣</span>
            <span class="discount">-¥{{$promoCodePaidRecord['paid_total']}}</span>
        </div>
    @endif
    <div>
        <span>支付金额</span>
        <span class="amount">¥{{$total}}</span>
    </div>
</div>

<div class="payment-methods">
    <h2>选择支付方式</h2>
    @if($enabledWechatPayment)
        <div class="payment-method" data-method="wechat">
            <div style="display: flex; align-items: center;">
                <img class="payment-method-icon" src="/images/pay/wechat.svg"/>
                <span class="payment-method-name">微信支付</span>
            </div>
            <span class="radio"></span>
        </div>
    @endif

    @if($enabledAlipayPayment)
        <div class="payment-method" data-method="alipay">
            <div style="display: flex; align-items: center;">
                <img class="payment-method-icon" src="/images/pay/ali.svg"/>
                <span class="payment-method-name">支付宝</span>
            </div>
            <span class="radio"></span>
        </div>
    @endif

    @if($enabledHandPayment)
        <div class="payment-method" data-method="bank">
            <div style="display: flex; align-items: center;">
                <img class="payment-method-icon" src="/images/pay/card.svg"/>
                <span class="payment-method-name">线下支付</span>
            </div>
            <span class="radio"></span>
        </div>
    @endif
</div>

<div id="bankModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>收款账号信息</h2>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            {!! $handPayInfo !!}
        </div>
    </div>
</div>

<div id="paymentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>支付提交中</h2>
        </div>
        <div class="modal-body">
            <p>正在跳转到支付渠道，请稍候...</p>
            <div class="loading-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <p style="margin-top: 20px;">如果您已完成支付或支付遇到问题</p>
            <p style="margin-top: 5px;">请点击下方按钮刷新订单状态</p>
            <button class="refresh-btn" onclick="window.location.reload()">
                刷新支付状态
            </button>
        </div>
    </div>
</div>

@if($sUrl)
    <div class="button-group">
        <button class="cancel-button" onclick="history.back()">取消支付</button>
        <button class="confirm-button" id="confirmPayment">确认支付</button>
    </div>
@else
    <div class="button-group">
        <button class="confirm-button" id="confirmPayment">确认支付</button>
    </div>
@endif

<form id="paymentForm" method="POST" action="" style="display: none;">
    @csrf
    <input type="hidden" name="payment_method" id="paymentMethod">
    <input type="hidden" name="platform" id="paymentPlatform">
</form>

<script>
    // 添加浏览器环境检测函数
    function getBrowserEnvironment() {
        const ua = navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) && !ua.match(/wxwork/i)) {
            return 'weixin';
        } else if (ua.match(/wxwork/i)) {
            return 'wxwork';
        } else if (ua.match(/qq/i)) {
            return 'qq';
        } else if (ua.match(/alipayclient/i)) {
            return 'alipay';
        }
        return 'other';
    }

    let selectedMethod = null;
    const confirmButton = document.getElementById('confirmPayment');
    const bankModal = document.getElementById('bankModal');
    const closeModal = document.querySelector('.close');
    const paymentForm = document.getElementById('paymentForm');

    document.querySelectorAll('.payment-method').forEach(method => {
        method.addEventListener('click', function () {
            document.querySelectorAll('.payment-method').forEach(m => {
                m.classList.remove('selected');
                m.querySelector('.radio').classList.remove('selected');
            });
            this.classList.add('selected');
            this.querySelector('.radio').classList.add('selected');
            selectedMethod = this.dataset.method;
        });
    });

    function showModal() {
        bankModal.style.display = 'block';
        bankModal.offsetHeight;
        bankModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function hideModal() {
        bankModal.classList.remove('show');
        setTimeout(() => {
            bankModal.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    }

    confirmButton.addEventListener('click', function () {
        if (!selectedMethod) {
            alert('请选择支付方式');
            return;
        }

        const browserEnv = getBrowserEnvironment();

        // 检查支付环境限制
        if ((browserEnv === 'weixin' || browserEnv === 'wxwork' || browserEnv === 'qq') && selectedMethod === 'alipay') {
            alert('请在默认浏览器中打开本网页');
            return;
        }

        if (selectedMethod === 'bank') {
            showModal();
        } else {
            // 显示支付提交遮罩层
            const paymentModal = document.getElementById('paymentModal');
            paymentModal.style.display = 'block';
            paymentModal.offsetHeight;
            paymentModal.classList.add('show');
            document.body.style.overflow = 'hidden';

            // 设置支付方式
            document.getElementById('paymentMethod').value = selectedMethod;
            
            // 如果是微信支付且不在微信环境中，设置platform为h5
            if (selectedMethod === 'wechat' && browserEnv !== 'weixin') {
                document.getElementById('paymentPlatform').value = 'h5';
            } else {
                document.getElementById('paymentPlatform').value = '';
            }

            this.disabled = true;
            this.classList.add('loading');
            this.textContent = '正在跳转...';

            // 延迟一小段时间后提交表单，确保遮罩层显示
            setTimeout(() => {
                paymentForm.submit();
            }, 100);
        }
    });

    closeModal.addEventListener('click', hideModal);

    bankModal.addEventListener('click', function (event) {
        if (event.target === bankModal) {
            hideModal();
        }
    });

    document.querySelectorAll('.copy-btn').forEach(button => {
        button.addEventListener('click', function () {
            const text = this.dataset.text;
            if (text) {
                navigator.clipboard.writeText(text).then(() => {
                    const originalText = this.textContent;
                    this.textContent = '复制成功';
                    setTimeout(() => {
                        this.textContent = originalText;
                    }, 2000);
                });
            }
        });
    });
</script>
</body>
</html>