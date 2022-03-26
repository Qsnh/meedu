<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
</head>
<body>

<script>
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
                if (res.err_msg === "get_brand_wcpay_request:ok") {
                    alert('支付成功');
                    window.location = decodeURIComponent('{{request()->input('s_url')}}');
                } else {
                    alert('未支付');
                    window.location = decodeURIComponent('{{request()->input('f_url')}}');
                }
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