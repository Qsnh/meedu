@extends('layouts.backend')

@section('title')
    系统配置
    @endsection

@section('body')

    <form action="" method="post">
        @csrf

        <ul class="nav nav-tabs nav-tabs-success">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#system">系统配置</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">社交登录</a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" data-toggle="tab" href="#socialite-github">Github登录</a>
                    <a class="dropdown-item" data-toggle="tab" href="#socialite-qq">QQ登录</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#aliyun-email">邮箱</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">短信</a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" data-toggle="tab" href="#sms-service">服务商</a>
                    <a class="dropdown-item" data-toggle="tab" href="#sms-aliyun">阿里云短信</a>
                    <a class="dropdown-item" data-toggle="tab" href="#sms-yunpian">云片短信</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#image">图片上传</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">支付</a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" data-toggle="tab" href="#payment-alipay">支付宝</a>
                    <a class="dropdown-item" data-toggle="tab" href="#payment-wechat">微信</a>
                    <a class="dropdown-item" data-toggle="tab" href="#payment-eshanghu">易商户</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">视频上传</a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" data-toggle="tab" href="#video-aliyun">阿里云视频</a>
                    <a class="dropdown-item" data-toggle="tab" href="#video-tencent">腾讯云视频</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#member">会员配置</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">SEO</a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" data-toggle="tab" href="#seo-index">首页</a>
                    <a class="dropdown-item" data-toggle="tab" href="#seo-course-list">课程列表</a>
                    <a class="dropdown-item" data-toggle="tab" href="#seo-vip">订阅页面</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#other">其它配置</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade active show" id="system">
                <div class="form-group">
                    <label>缓存开关（缓存开启之后会提高网站性能）</label><br>
                    <input type="radio" name="meedu*system*cache*status" value="1"
                            {{config('meedu.system.cache.status') == 1 ? 'checked' : ''}}> 开启
                    <input type="radio" name="meedu*system*cache*status" value="-1"
                            {{config('meedu.system.cache.status') != 1 ? 'checked' : ''}}> 不开启
                </div>
                <div class="form-group">
                    <label>缓存时间</label>
                    <input type="text" name="meedu*system*cache*expire" class="form-control" value="{{config('meedu.system.cache.expire')}}">
                </div>
                <div class="form-group">
                    <label>备份开关（将会自动备份网站和数据库数据）</label><br>
                    <input type="radio" name="meedu*system*backup" value="1"
                            {{config('meedu.system.backup') == 1 ? 'checked' : ''}}> 开启
                    <input type="radio" name="meedu*system*backup" value="-1"
                            {{config('meedu.system.backup') != 1 ? 'checked' : ''}}> 不开启
                </div>
                <div class="form-group">
                    <label>统计代码</label>
                    <input type="text" name="meedu*system*js" class="form-control" value="{{config('meedu.system.js')}}">
                </div>
            </div>
            <div class="tab-pane fade" id="socialite-github">
                <div class="form-group">
                    <label></label><br>
                    <input type="radio" name="meedu*member*socialite*github*enabled" value="1"
                            {{config('meedu.member.socialite.github.enabled') == 1 ? 'checked' : ''}}> 开启
                    <input type="radio" name="meedu*member*socialite*github*enabled" value="0"
                            {{config('meedu.member.socialite.github.enabled') == 0 ? 'checked' : ''}}> 不开启
                </div>
                <div class="form-group">
                    <label>Github ClientId</label>
                    <input type="text" name="services*github*client_id" class="form-control" value="{{config('services.github.client_id')}}">
                </div>
                <div class="form-group">
                    <label>Github ClientSecret</label>
                    <input type="text" name="services*github*client_secret" class="form-control" value="{{config('services.github.client_secret')}}">
                </div>
                <div class="form-group">
                    <label>Github ClientSecret</label>
                    <input type="text" name="services*github*redirect" class="form-control" value="{{config('services.github.redirect')}}">
                </div>
            </div>
            <div class="tab-pane fade" id="socialite-qq">
                <div class="form-group">
                    <label>QQ登录</label><br>
                    <input type="radio" name="meedu*member*socialite*qq*enabled" value="1"
                            {{config('meedu.member.socialite.qq.enabled') == 1 ? 'checked' : ''}}> 开启
                    <input type="radio" name="meedu*member*socialite*qq*enabled" value="0"
                            {{config('meedu.member.socialite.qq.enabled') == 0 ? 'checked' : ''}}> 不开启
                </div>
                <div class="form-group">
                    <label>QQ ClientId</label>
                    <input type="text" name="services*qq*client_id" class="form-control" value="{{config('services.qq.client_id')}}">
                </div>
                <div class="form-group">
                    <label>QQ ClientSecret</label>
                    <input type="text" name="services*qq*client_secret" class="form-control" value="{{config('services.qq.client_secret')}}">
                </div>
                <div class="form-group">
                    <label>QQ RedirectUrl</label>
                    <input type="text" name="services*qq*redirect" class="form-control" value="{{config('services.qq.redirect')}}">
                </div>
            </div>
            <div class="tab-pane fade" id="aliyun-email">
                <div class="alert alert-warning">
                    <a href="https://www.aliyun.com/product/directmail">阿里云邮件服务</a>
                </div>
                <div class="form-group">
                    <label>阿里云AccessKeyId</label>
                    <input type="text" name="services*directmail*app_key" class="form-control"
                           value="{{config('services.directmail.app_key')}}">
                </div>
                <div class="form-group">
                    <label>阿里云AccessKeySecret</label>
                    <input type="text" name="services*directmail*app_secret" class="form-control"
                           value="{{config('services.directmail.app_secret')}}">
                </div>
                <div class="form-group">
                    <label>邮件发送用户名</label>
                    <input type="text" name="services*directmail*account*alias" class="form-control"
                           value="{{config('services.directmail.account.alias')}}">
                </div>
                <div class="form-group">
                    <label>邮件发送地址</label>
                    <input type="text" name="services*directmail*account*name" class="form-control"
                           value="{{config('services.directmail.account.name')}}">
                </div>
            </div>
            <div class="tab-pane fade" id="sms-service">
                <div class="form-group">
                    <label>短信服务商</label>
                    <select name="meedu*system*sms" class="form-control">
                        <option value="aliyun" {{config('meedu.system.sms') == 'aliyun' ? 'selected' : ''}}>阿里云</option>
                        <option value="yunpian" {{config('meedu.system.sms') == 'yunpian' ? 'selected' : ''}}>云片</option>
                    </select>
                </div>
            </div>
            <div class="tab-pane fade" id="sms-aliyun">
                <div class="alert alert-warning">
                    <a href="https://www.aliyun.com/product/sms?spm=5176.8142029.search.1.e9396d3e9M6zyh">阿里云短信服务</a>
                </div>
                <div class="form-group">
                    <label>阿里云AccessKeyId</label>
                    <input type="text" name="sms*gateways*aliyun*access_key_id" class="form-control"
                           value="{{config('sms.gateways.aliyun.access_key_id')}}">
                </div>
                <div class="form-group">
                    <label>阿里云AccessKeySecret</label>
                    <input type="text" name="sms*gateways*aliyun*access_key_secret" class="form-control"
                           value="{{config('sms.gateways.aliyun.access_key_secret')}}">
                </div>
                <div class="form-group">
                    <label>阿里云短信签名</label>
                    <input type="text" name="sms*gateways*aliyun*sign_name" class="form-control"
                           value="{{config('sms.gateways.aliyun.sign_name')}}">
                </div>
                <div class="form-group">
                    <label>密码重置短信模板ID</label>
                    <input type="text" name="sms*gateways*aliyun*template*password_reset" class="form-control"
                           value="{{config('sms.gateways.aliyun.template.password_reset')}}">
                </div>
                <div class="form-group">
                    <label>注册短信模板ID</label>
                    <input type="text" name="sms*gateways*aliyun*template*register" class="form-control"
                           value="{{config('sms.gateways.aliyun.template.register')}}">
                </div>
                <div class="form-group">
                    <label>手机号绑定模板ID</label>
                    <input type="text" name="sms*gateways*aliyun*template*mobile_bind" class="form-control"
                           value="{{config('sms.gateways.aliyun.template.mobile_bind')}}">
                </div>
            </div>
            <div class="tab-pane fade" id="sms-yunpian">
                <div class="alert alert-warning">
                    <a href="https://www.yunpian.com/component/reg?inviteCode=kwfrte">云片短信服务</a>
                </div>
                <div class="form-group">
                    <label>云片APIKEY</label>
                    <input type="text" name="sms*gateways*yunpian*api_key" class="form-control"
                           value="{{config('sms.gateways.yunpian.api_key')}}">
                </div>
                <div class="form-group">
                    <label>密码重置短信模板</label>
                    <input type="text" name="sms*gateways*yunpian*template*password_reset" class="form-control"
                           value="{{config('sms.gateways.yunpian.template.password_reset')}}">
                </div>
                <div class="form-group">
                    <label>注册短信模板</label>
                    <input type="text" name="sms*gateways*yunpian*template*register" class="form-control"
                           value="{{config('sms.gateways.yunpian.template.register')}}">
                </div>
                <div class="form-group">
                    <label>手机号绑定模板</label>
                    <input type="text" name="sms*gateways*yunpian*template*mobile_bind" class="form-control"
                           value="{{config('sms.gateways.yunpian.template.mobile_bind')}}">
                </div>
            </div>
            <div class="tab-pane fade" id="image">
                <div class="form-group">
                    <label>图片存储磁盘</label>
                    <input type="text" name="meedu*upload*image*disk" class="form-control"
                           value="{{config('meedu.upload.image.disk')}}">
                </div>
                <div class="form-group">
                    <label>图片存储路径</label>
                    <input type="text" name="meedu*upload*image*path" class="form-control"
                           value="{{config('meedu.upload.image.path')}}">
                </div>
                <div class="form-group">
                    <label>图片参数（用于第三方图片存储）</label>
                    <input type="text" name="meedu*upload*image*params" class="form-control"
                           value="{{config('meedu.upload.image.params')}}">
                </div>
            </div>
            <div class="tab-pane fade" id="payment-alipay">
                <div class="form-group">
                    <label>是否开启</label><br>
                    <input type="radio" name="meedu*payment*alipay*enabled" value="1"
                            {{config('meedu.payment.alipay.enabled') == 1 ? 'checked' : ''}}> 启用
                    <input type="radio" name="meedu*payment*alipay*enabled" value="0"
                            {{config('meedu.payment.alipay.enabled') == 0 ? 'checked' : ''}}> 不启用
                </div>
                <div class="form-group">
                    <label>AppId</label>
                    <input type="text" name="pay*alipay*app_id" class="form-control"
                           value="{{config('pay.alipay.app_id')}}">
                </div>
                <div class="form-group">
                    <label>公钥(RSA2加密方式)</label>
                    <textarea name="pay*alipay*ali_public_key" class="form-control" rows="3">{{config('pay.alipay.ali_public_key')}}</textarea>
                </div>
                <div class="form-group">
                    <label>私钥(RSA2加密方式)</label>
                    <textarea name="pay*alipay*private_key" class="form-control" rows="3">{{config('pay.alipay.private_key')}}</textarea>
                </div>
                <div class="form-group">
                    <label>返回地址</label>
                    <input type="text" name="pay*alipay*return_url" class="form-control"
                           value="{{config('pay.alipay.return_url')}}">
                </div>
                <div class="form-group">
                    <label>回调地址</label>
                    <input type="text" name="pay*alipay*notify_url" class="form-control"
                           value="{{config('pay.alipay.notify_url')}}">
                    <span class="form-text text-muted">示例：http://demo.com/payment/callback/alipay</span>
                </div>
            </div>
            <div class="tab-pane fade" id="payment-wechat">
                <div class="form-group">
                    <label>是否开启</label><br>
                    <input type="radio" name="meedu*payment*wechat*enabled" value="1"
                            {{config('meedu.payment.wechat.enabled') == 1 ? 'checked' : ''}}> 启用
                    <input type="radio" name="meedu*payment*wechat*enabled" value="0"
                            {{config('meedu.payment.wechat.enabled') == 0 ? 'checked' : ''}}> 不启用
                </div>
                <div class="form-group">
                    <label>公众号ID</label>
                    <input type="text" name="pay*wechat*app_id" class="form-control"
                           value="{{config('pay.wechat.app_id')}}">
                </div>
                <div class="form-group">
                    <label>商户ID</label>
                    <input type="text" name="pay*wechat*mch_id" class="form-control"
                           value="{{config('pay.wechat.mch_id')}}">
                </div>
                <div class="form-group">
                    <label>密钥</label>
                    <textarea name="pay*wechat*key" class="form-control" rows="3">{{config('pay.wechat.key')}}</textarea>
                </div>
                <div class="form-group">
                    <label>回调地址</label>
                    <input type="text" name="pay*wechat*notify_url" class="form-control"
                           value="{{config('pay.wechat.notify_url')}}">
                    <span class="form-text text-muted">示例：http://demo.com/payment/callback/wechat</span>
                </div>
            </div>
            <div class="tab-pane fade" id="payment-eshanghu">
                <div class="alert alert-info">
                    <p>个人收款解决方案，申请地址 <a target="_blank" href="https://1shanghu.com">易商户</a></p>
                </div>
                <div class="form-group">
                    <label>是否开启</label><br>
                    <input type="radio" name="meedu*payment*eshanghu*enabled" value="1"
                            {{config('meedu.payment.eshanghu.enabled') == 1 ? 'checked' : ''}}> 启用
                    <input type="radio" name="meedu*payment*eshanghu*enabled" value="0"
                            {{config('meedu.payment.eshanghu.enabled') == 0 ? 'checked' : ''}}> 不启用
                </div>
                <div class="form-group">
                    <label>AppKey</label>
                    <input type="text" name="eshanghu*app_key" class="form-control"
                           value="{{config('eshanghu.app_key')}}">
                </div>
                <div class="form-group">
                    <label>AppSecret</label>
                    <input type="text" name="eshanghu*app_secret" class="form-control"
                           value="{{config('eshanghu.app_secret')}}">
                </div>
                <div class="form-group">
                    <label>子商户ID</label>
                    <input type="text" name="eshanghu*sub_mch_id" class="form-control"
                           value="{{config('eshanghu.sub_mch_id')}}">
                </div>
                <div class="form-group">
                    <label>回调地址</label>
                    <input type="text" name="eshanghu*notify" class="form-control"
                           value="{{config('eshanghu.notify')}}">
                    <span class="form-text text-muted">示例：http://demo.com/payment/callback/eshanghu</span>
                </div>
            </div>
            <div class="tab-pane fade" id="video-aliyun">
                <div class="alert alert-warning">
                    <a href="https://www.aliyun.com/product/vod?spm=5176.8142029.search.1.e9396d3eFvjBxH">
                        阿里云视频服务，<b>注意这里是阿里云的视频服务不是oss服务</b>
                    </a>
                </div>
                <div class="form-group">
                    <label>区域ID</label>
                    <input type="text" name="meedu*upload*video*aliyun*region" class="form-control"
                           value="{{config('meedu.upload.video.aliyun.region')}}">
                </div>
                <div class="form-group">
                    <label>AccessKeyId</label>
                    <input type="text" name="meedu*upload*video*aliyun*access_key_id" class="form-control"
                           value="{{config('meedu.upload.video.aliyun.access_key_id')}}">
                </div>
                <div class="form-group">
                    <label>AccessKeySecret</label>
                    <input type="text" name="meedu*upload*video*aliyun*access_key_secret" class="form-control"
                           value="{{config('meedu.upload.video.aliyun.access_key_secret')}}">
                </div>
            </div>
            <div class="tab-pane fade" id="video-tencent">
                <div class="alert alert-warning">
                    <a href="https://cloud.tencent.com/product/vod">腾讯云视频服务</a>
                </div>
                <div class="form-group">
                    <label>SecretId</label>
                    <input type="text" name="tencent*vod*secret_id" class="form-control"
                           value="{{config('tencent.vod.secret_id')}}">
                </div>
                <div class="form-group">
                    <label>SecretKey</label>
                    <input type="text" name="tencent*vod*secret_key" class="form-control"
                           value="{{config('tencent.vod.secret_key')}}">
                </div>
            </div>
            <div class="tab-pane fade" id="member">
                <div class="form-group">
                    <label>会员注册默认激活</label><br>
                    <input type="radio" name="meedu*member*is_active_default" value="1"
                            {{config('meedu.member.is_active_default') == 1 ? 'checked' : ''}}> 激活
                    <input type="radio" name="meedu*member*is_active_default" value="-1"
                            {{config('meedu.member.is_active_default') == -1 ? 'checked' : ''}}> 不激活
                </div>
                <div class="form-group">
                    <label>会员注册默认锁定</label><br>
                    <input type="radio" name="meedu*member*is_lock_default" value="1"
                            {{config('meedu.member.is_lock_default') == 1 ? 'checked' : ''}}> 锁定
                    <input type="radio" name="meedu*member*is_lock_default" value="-1"
                            {{config('meedu.member.is_lock_default') == -1 ? 'checked' : ''}}> 不锁定
                </div>
                <div class="form-group">
                    <label>会员默认头像</label>
                    @include('components.backend.image', ['name' => 'meedu*member*default_avatar', 'value' => config('meedu.member.default_avatar')])
                </div>
            </div>
            <div class="tab-pane fade" id="seo-index">
                <div class="form-group">
                    <label>首页标题</label>
                    <textarea name="meedu*seo*index*title" class="form-control" rows="2">{{config('meedu.seo.index.title')}}</textarea>
                </div>
                <div class="form-group">
                    <label>首页关键字</label>
                    <textarea name="meedu*seo*index*keywords" class="form-control" rows="2">{{config('meedu.seo.index.keywords')}}</textarea>
                </div>
                <div class="form-group">
                    <label>首页描述</label>
                    <textarea name="meedu*seo*index*description" class="form-control" rows="2">{{config('meedu.seo.index.description')}}</textarea>
                </div>
            </div>
            <div class="tab-pane fade" id="seo-course-list">
                <div class="form-group">
                    <label>课程列表页面标题</label>
                    <textarea name="meedu*seo*course_list*title" class="form-control" rows="2">{{config('meedu.seo.course_list.title')}}</textarea>
                </div>
                <div class="form-group">
                    <label>课程列表页面关键字</label>
                    <textarea name="meedu*seo*course_list*keywords" class="form-control" rows="2">{{config('meedu.seo.course_list.keywords')}}</textarea>
                </div>
                <div class="form-group">
                    <label>课程列表页面描述</label>
                    <textarea name="meedu*seo*course_list*description" class="form-control" rows="2">{{config('meedu.seo.course_list.description')}}</textarea>
                </div>
            </div>
            <div class="tab-pane fade" id="seo-vip">
                <div class="form-group">
                    <label>订阅页面标题</label>
                    <textarea name="meedu*seo*role_list*title" class="form-control" rows="2">{{config('meedu.seo.role_list.title')}}</textarea>
                </div>
                <div class="form-group">
                    <label>订阅页面关键字</label>
                    <textarea name="meedu*seo*role_list*keywords" class="form-control" rows="2">{{config('meedu.seo.role_list.keywords')}}</textarea>
                </div>
                <div class="form-group">
                    <label>订阅页面描述</label>
                    <textarea name="meedu*seo*role_list*description" class="form-control" rows="2">{{config('meedu.seo.role_list.description')}}</textarea>
                </div>
            </div>

            <div class="tab-pane fade" id="other">
                <div class="form-group">
                    <label>课程列表页展示课程条数</label>
                    <input type="text" name="meedu*other*course_list_page_size" class="form-control" value="{{config('meedu.other.course_list_page_size')}}">
                </div>
                <div class="form-group">
                    <label>视频列表页面展示视频条数</label>
                    <input type="text" name="meedu*other*video_list_page_size" class="form-control" value="{{config('meedu.other.video_list_page_size')}}">
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <button class="btn btn-primary" type="submit">保存</button>
        </div>

    </form>

@endsection