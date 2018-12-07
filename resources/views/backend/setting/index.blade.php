@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '全站配置'])

    <div class="row row-cards">
        <div class="col-sm-12">

            <form action="" method="post">
                @csrf

                <div class="card">
                    <div class="card-header">系统配置</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>缓存开关</label><br>
                            <input type="radio" name="meedu*system*cache*status" value="1"
                                    {{config('meedu.system.cache.status') == 1 ? 'checked' : ''}}> 开启
                            <input type="radio" name="meedu*system*cache*status" value="-1"
                                    {{config('meedu.system.cache.status') == -1 ? 'checked' : ''}}> 不开启
                        </div>
                        <div class="form-group">
                            <label>缓存时间</label>
                            <input type="text" name="meedu*system*cache*expire" class="form-control" value="{{config('meedu.system.cache.expire')}}">
                        </div>
                        <div class="form-group">
                            <label>统计代码</label>
                            <input type="text" name="meedu*system*js" class="form-control" value="{{config('meedu.system.js')}}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">阿里云邮箱配置</div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <a href="https://www.aliyun.com/product/directmail?spm=5176.224200.search.1.67236ed6hjhyN0">阿里云邮件服务</a>
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
                </div>

                <div class="card">
                    <div class="card-header">阿里云短信配置</div>
                    <div class="card-body">
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
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">支付配置</div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <a href="https://www.youzanyun.com/">有赞云收款服务</a>。支付回调URL：<code>{{route('payment.callback')}}</code>
                        </div>
                        <div class="form-group">
                            <label>有赞ClientId</label>
                            <input type="text" name="meedu*payment*youzan*client_id" class="form-control"
                                   value="{{config('meedu.payment.youzan.client_id')}}">
                        </div>
                        <div class="form-group">
                            <label>有赞ClientSecret</label>
                            <input type="text" name="meedu*payment*youzan*client_secret" class="form-control"
                                   value="{{config('meedu.payment.youzan.client_secret')}}">
                        </div>
                        <div class="form-group">
                            <label>有赞KdtId</label>
                            <input type="text" name="meedu*payment*youzan*kdt_id" class="form-control"
                                   value="{{config('meedu.payment.youzan.kdt_id')}}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">图片上传设置</div>
                    <div class="card-body">
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
                </div>

                <div class="card">
                    <div class="card-header">视频上传配置</div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <a href="https://www.aliyun.com/product/vod?spm=5176.8142029.search.1.e9396d3eFvjBxH">阿里云视频服务</a>
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
                </div>

                <div class="card">
                    <div class="card-header">会员配置</div>
                    <div class="card-body">
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
                </div>

                <div class="card">
                    <div class="card-header">首页SEO配置</div>
                    <div class="card-body">
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
                </div>

                <div class="card">
                    <div class="card-header">课程列表SEO配置</div>
                    <div class="card-body">
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
                </div>

                <div class="card">
                    <div class="card-header">订阅页面SEO配置</div>
                    <div class="card-body">
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
                </div>

                <div class="card">
                    <div class="card-header">电子书列表页面SEO配置</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>电子书列表页面标题</label>
                            <textarea name="meedu*seo*book_list*title" class="form-control" rows="2">{{config('meedu.seo.book_list.title')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>电子书列表页面关键字</label>
                            <textarea name="meedu*seo*book_list*keywords" class="form-control" rows="2">{{config('meedu.seo.book_list.keywords')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>电子书列表页面描述</label>
                            <textarea name="meedu*seo*book_list*description" class="form-control" rows="2">{{config('meedu.seo.book_list.description')}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>

            </form>

        </div>
    </div>


@endsection