@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '全站配置'])

    <el-row :gutter="20">
        <el-form label-position="top" method="post">
            {!! csrf_field() !!}

            <template>
                <el-tabs v-model="activeName" @tab-click="handleClick">
                    <el-tab-pane label="邮箱配置" name="email">
                        <el-col :span="24">
                            <p>下面是阿里云的邮箱配置：</p>
                            <el-form-item label="阿里云AccessKeyId">
                                <el-input name="services*directmail*app_key" v-model="config.services.directmail.app_key"></el-input>
                            </el-form-item>
                            <el-form-item label="阿里云AccessKeySecret">
                                <el-input name="services*directmail*app_secret" v-model="config.services.directmail.app_secret"></el-input>
                            </el-form-item>
                            <el-form-item label="邮件发送用户名">
                                <el-input name="services*directmail*account*alias" v-model="config.services.directmail.account.alias"></el-input>
                            </el-form-item>
                            <el-form-item label="邮件发送地址">
                                <el-input name="services*directmail*account*name" v-model="config.services.directmail.account.name"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-tab-pane>
                    <el-tab-pane label="系统配置" name="system">
                        <el-col :span="24">
                            <el-form-item label="缓存开关">
                                <input type="radio" name="meedu*system*cache*status" v-model="config.meedu.system.cache.status" value="1"> 开启
                                <input type="radio" name="meedu*system*cache*status" v-model="config.meedu.system.cache.status" value="-1"> 不开启
                            </el-form-item>
                            <el-form-item label="缓存有效期（单位：分钟）">
                                <el-input name="meedu*system*cache*expire" v-model="config.meedu.system.cache.expire"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-tab-pane>
                    <el-tab-pane label="短信配置" name="sms">
                        <el-form-item label="阿里云AccessKeyId">
                            <el-input name="sms*gateways*aliyun*access_key_id" v-model="config.sms.gateways.aliyun.access_key_id"></el-input>
                        </el-form-item>
                        <el-form-item label="阿里云AccessKeySecret">
                            <el-input name="sms*gateways*aliyun*access_key_secret" v-model="config.sms.gateways.aliyun.access_key_secret"></el-input>
                        </el-form-item>
                        <el-form-item label="阿里云短信签名">
                            <el-input name="sms*gateways*aliyun*sign_name" v-model="config.sms.gateways.aliyun.sign_name"></el-input>
                        </el-form-item>
                        <el-form-item label="密码重置短信模板ID">
                            <el-input name="sms*gateways*aliyun*template*password_reset" v-model="config.sms.gateways.aliyun.template.password_reset"></el-input>
                        </el-form-item>
                        <el-form-item label="注册短信模板ID">
                            <el-input name="sms*gateways*aliyun*template*register" v-model="config.sms.gateways.aliyun.template.register"></el-input>
                        </el-form-item>
                    </el-tab-pane>
                    <el-tab-pane label="支付配置" name="payment">
                        <el-form-item label="有赞ClientId">
                            <el-input name="meedu*payment*youzan*client_id" v-model="config.meedu.payment.youzan.client_id"></el-input>
                        </el-form-item>
                        <el-form-item label="有赞ClientSecret">
                            <el-input name="meedu*payment*youzan*client_secret" v-model="config.meedu.payment.youzan.client_secret"></el-input>
                        </el-form-item>
                        <el-form-item label="有赞KdtId">
                            <el-input name="meedu*payment*youzan*kdt_id" v-model="config.meedu.payment.youzan.kdt_id"></el-input>
                        </el-form-item>
                    </el-tab-pane>
                    <el-tab-pane label="图片上传配置" name="image">
                        <el-form-item label="图片存储磁盘">
                            <el-input name="meedu*upload*image*disk" v-model="config.meedu.upload.image.disk"></el-input>
                        </el-form-item>
                        <el-form-item label="图片存储路径">
                            <el-input name="meedu*upload*image*path" v-model="config.meedu.upload.image.path"></el-input>
                        </el-form-item>
                        <el-form-item label="图片参数（用于第三方图片存储）">
                            <el-input name="meedu*upload*image*params" v-model="config.meedu.upload.image.params"></el-input>
                        </el-form-item>
                    </el-tab-pane>
                    <el-tab-pane label="视频上传配置" name="video">
                        <p>下面是阿里云的视频存储配置</p>
                        <el-form-item label="区域ID">
                            <el-input name="meedu*upload*video*aliyun*region" v-model="config.meedu.upload.video.aliyun.region"></el-input>
                        </el-form-item>
                        <el-form-item label="AccessKeyId">
                            <el-input name="meedu*upload*video*aliyun*access_key_id" v-model="config.meedu.upload.video.aliyun.access_key_id"></el-input>
                        </el-form-item>
                        <el-form-item label="AccessKeySecret">
                            <el-input name="meedu*upload*video*aliyun*access_key_secret" v-model="config.meedu.upload.video.aliyun.access_key_secret"></el-input>
                        </el-form-item>
                    </el-tab-pane>
                    <el-tab-pane label="会员配置" name="member">
                        <el-col span="24">
                            <el-form-item label="会员注册默认激活">
                                <input type="radio" name="meedu*member*is_active_default" v-model="config.meedu.member.is_active_default" value="1"> 激活
                                <input type="radio" name="meedu*member*is_active_default" v-model="config.meedu.member.is_active_default" value="-1"> 不激活
                            </el-form-item>
                            <el-form-item label="会员注册默认锁定">
                                <input type="radio" name="meedu*member*is_lock_default" v-model="config.meedu.member.is_lock_default" value="1"> 锁定
                                <input type="radio" name="meedu*member*is_lock_default" v-model="config.meedu.member.is_lock_default" value="-1"> 不锁定
                            </el-form-item>
                            <el-form-item label="会员默认头像">
                                <meedu-upload-image :field="'meedu*member*default_avatar'" :give-image-url="config.meedu.member.default_avatar"></meedu-upload-image>
                            </el-form-item>
                        </el-col>
                    </el-tab-pane>
                    <el-tab-pane label="SEO配置" name="seo">
                        <el-col span="8">
                            <el-form-item label="首页标题">
                                <el-input type="textarea" name="meedu*seo*index*title" placeholder="首页标题" v-model="config.meedu.seo.index.title"></el-input>
                            </el-form-item>
                            <el-form-item label="首页关键字">
                                <el-input type="textarea" name="meedu*seo*index*keywords" placeholder="首页关键字" v-model="config.meedu.seo.index.keywords"></el-input>
                            </el-form-item>
                            <el-form-item label="首页描述">
                                <el-input type="textarea" name="meedu*seo*index*description" placeholder="首页描述" v-model="config.meedu.seo.index.description"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col span="8">
                            <el-form-item label="课程列表页面标题">
                                <el-input type="textarea" name="meedu*seo*course_list*title" placeholder="课程列表页面标题" v-model="config.meedu.seo.course_list.title"></el-input>
                            </el-form-item>
                            <el-form-item label="课程列表页面关键字">
                                <el-input type="textarea" name="meedu*seo*course_list*keywords" placeholder="课程列表页面关键字" v-model="config.meedu.seo.course_list.keywords"></el-input>
                            </el-form-item>
                            <el-form-item label="课程列表页面描述">
                                <el-input type="textarea" name="meedu*seo*course_list*description" placeholder="课程列表页面描述" v-model="config.meedu.seo.course_list.description"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col span="8">
                            <el-form-item label="订阅页面标题">
                                <el-input type="textarea" name="meedu*seo*role_list*title" placeholder="订阅页面标题" v-model="config.meedu.seo.role_list.title"></el-input>
                            </el-form-item>
                            <el-form-item label="订阅页面关键字">
                                <el-input type="textarea" name="meedu*seo*role_list*keywords" placeholder="订阅页面关键字" v-model="config.meedu.seo.role_list.keywords"></el-input>
                            </el-form-item>
                            <el-form-item label="订阅页面描述">
                                <el-input type="textarea" name="meedu*seo*role_list*description" placeholder="订阅页面描述" v-model="config.meedu.seo.role_list.description"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col span="8">
                            <el-form-item label="电子书列表页面标题">
                                <el-input type="textarea" name="meedu*seo*book_list*title" placeholder="电子书列表页面标题" v-model="config.meedu.seo.book_list.title"></el-input>
                            </el-form-item>
                            <el-form-item label="电子书列表页面关键字">
                                <el-input type="textarea" name="meedu*seo*book_list*keywords" placeholder="电子书列表页面关键字" v-model="config.meedu.seo.book_list.keywords"></el-input>
                            </el-form-item>
                            <el-form-item label="电子书列表页面描述">
                                <el-input type="textarea" name="meedu*seo*book_list*description" placeholder="电子书列表页面描述" v-model="config.meedu.seo.book_list.description"></el-input>
                            </el-form-item>
                        </el-col>

                    </el-tab-pane>
                </el-tabs>
            </template>

            <el-form-item>
                <el-button native-type="submit" type="primary" native-button="submit">保存修改</el-button>
            </el-form-item>

        </el-form>
    </el-row>

@endsection

@section('js')
    <script>
        var Page = new Vue({
            el: '#app',
            data: function () {
                return {
                    activeName: 'system',
                    config: @json($config)
                }
            },
            methods: {
                handleClick(tab, event) {
                    console.log(tab, event);
                }
            }
        });
    </script>
@endsection