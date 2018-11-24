@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑友情链接'])

    <el-row>
        <el-col :span="24" style="margin-bottom: 20px;">
            <meedu-a :url="'{{ route('backend.link.index') }}'" :name="'返回友情链接列表'"></meedu-a>
        </el-col>
    </el-row>

    <el-row :gutter="20">
        <el-form label-position="top" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
            <el-col :span="12" :offset="6">
                <el-form-item label="排序值（整数，小的靠前）">
                    <el-input name="sort" placeholder="排序值（整数，小的靠前）" v-model="link.sort"></el-input>
                </el-form-item>

                <el-form-item label="链接名">
                    <el-input name="name" placeholder="链接名" v-model="link.name"></el-input>
                </el-form-item>

                <el-form-item label="链接地址">
                    <el-input name="url" placeholder="链接地址" v-model="link.url"></el-input>
                </el-form-item>

                <el-form-item>
                    <el-button native-type="submit" type="primary" native-button="submit">保存</el-button>
                </el-form-item>
            </el-col>
        </el-form>
    </el-row>

@endsection

@section('js')
    <script>
        var Page = new Vue({
            el: '#app',
            data: function () {
                return {
                    link: @json($link)
                }
            }
        });
    </script>
@endsection