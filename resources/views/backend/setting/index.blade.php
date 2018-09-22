@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '全站配置'])

    <el-row :gutter="20">
        <el-form label-position="top" method="post">
            {!! csrf_field() !!}

            <template>
                <el-tabs v-model="activeName" @tab-click="handleClick">
                    <el-tab-pane label="支付网关" name="first">
                        <el-form-item label="有赞ClientId">
                            <el-input name="payment*youzan*client_id" v-model="config.payment.youzan.client_id"></el-input>
                        </el-form-item>
                        <el-form-item label="有赞ClientSecret">
                            <el-input name="payment*youzan*client_secret" v-model="config.payment.youzan.client_secret"></el-input>
                        </el-form-item>
                        <el-form-item label="有赞KdtId">
                            <el-input name="payment*youzan*kdt_id" v-model="config.payment.youzan.kdt_id"></el-input>
                        </el-form-item>
                    </el-tab-pane>
                    <el-tab-pane label="上传配置" name="second">
                        <el-form-item label="图片存储磁盘">
                            <el-input name="upload*image*disk" v-model="config.upload.image.disk"></el-input>
                        </el-form-item>
                        <el-form-item label="图片存储路径">
                            <el-input name="upload*image*path" v-model="config.upload.image.path"></el-input>
                        </el-form-item>
                    </el-tab-pane>
                    <el-tab-pane label="会员配置" name="third">
                        <el-col span="24">
                            <el-form-item label="会员注册默认激活">
                                <input type="radio" name="member*is_active_default" v-model="config.member.is_active_default" value="1"> 激活
                                <input type="radio" name="member*is_active_default" v-model="config.member.is_active_default" value="-1"> 不激活
                            </el-form-item>
                            <el-form-item label="会员注册默认锁定">
                                <input type="radio" name="member*is_lock_default" v-model="config.member.is_lock_default" value="1"> 锁定
                                <input type="radio" name="member*is_lock_default" v-model="config.member.is_lock_default" value="-1"> 不锁定
                            </el-form-item>
                            <el-form-item label="会员默认头像">
                                <meedu-upload-image :field="'member*default_avatar'" :give-image-url="config.member.default_avatar"></meedu-upload-image>
                            </el-form-item>
                        </el-col>
                    </el-tab-pane>
                    <el-tab-pane label="SEO配置" name="fourth">
                        <el-col span="8">
                            <el-form-item label="首页标题">
                                <el-input type="textarea" name="seo*index*title" placeholder="首页标题" v-model="config.seo.index.title"></el-input>
                            </el-form-item>
                            <el-form-item label="首页关键字">
                                <el-input type="textarea" name="seo*index*keywords" placeholder="首页关键字" v-model="config.seo.index.keywords"></el-input>
                            </el-form-item>
                            <el-form-item label="首页描述">
                                <el-input type="textarea" name="seo*index*description" placeholder="首页描述" v-model="config.seo.index.description"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col span="8">
                            <el-form-item label="课程列表页面标题">
                                <el-input type="textarea" name="seo*course_list*title" placeholder="课程列表页面标题" v-model="config.seo.course_list.title"></el-input>
                            </el-form-item>
                            <el-form-item label="课程列表页面关键字">
                                <el-input type="textarea" name="seo*course_list*keywords" placeholder="课程列表页面关键字" v-model="config.seo.course_list.keywords"></el-input>
                            </el-form-item>
                            <el-form-item label="课程列表页面描述">
                                <el-input type="textarea" name="seo*course_list*description" placeholder="课程列表页面描述" v-model="config.seo.course_list.description"></el-input>
                            </el-form-item>
                        </el-col>

                        <el-col span="8">
                            <el-form-item label="订阅页面标题">
                                <el-input type="textarea" name="seo*role_list*title" placeholder="订阅页面标题" v-model="config.seo.role_list.title"></el-input>
                            </el-form-item>
                            <el-form-item label="订阅页面关键字">
                                <el-input type="textarea" name="seo*role_list*keywords" placeholder="订阅页面关键字" v-model="config.seo.role_list.keywords"></el-input>
                            </el-form-item>
                            <el-form-item label="订阅页面描述">
                                <el-input type="textarea" name="seo*role_list*description" placeholder="订阅页面描述" v-model="config.seo.role_list.description"></el-input>
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
                    activeName: 'fourth',
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