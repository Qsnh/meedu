# VIP接口

+ [VIP列表](#VIP列表)
+ [购买VIP](#购买VIP)


### VIP列表

接口(GET)：

```angular2html
/api/v1/roles
```

请求参数：

```angular2html
无
```

响应参数：

```angular2html
{
    "data": [
        {
            "name": "年度会员",
            "charge": 299,
            "expire_days": 365,
            "description": [
                "所有视频免费观看\r",
                "专属小密圈"
            ]
        }
    ]
}
```


### 购买VIP

接口（POST）：

```angular2html
/api/v1/role/{id}/buy
```

请求参数：

```angular2html
无
```

返回参数：

下面是错误消息，成功返回空值.

```angular2html
{
    "message": "余额不足",
    "code": 500
}
```