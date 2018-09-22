@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加权限'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.administrator_permission.index') }}'" :name="'返回权限列表'"></meedu-a>
        </el-col>
        <el-col :span="12" :offset="6">
            <el-form label-position="top" method="post">
                {!! csrf_field() !!}
                <el-form-item label="权限名">
                    <el-input name="display_name" value="{{ old('display_name') }}" placeholder="请输入权限名"></el-input>
                </el-form-item>
                <el-form-item label="Slug">
                    <el-input name="slug" value="{{ old('slug') }}" placeholder="请输入Slug"></el-input>
                </el-form-item>
                <el-form-item label="描述">
                    <el-input name="description" value="{{ old('description') }}" placeholder="请输入描述"></el-input>
                </el-form-item>
                <el-form-item label="请求方法">
                    <el-select v-model="selectedMethods" placeholder="请选择" :multiple="true">
                        <el-option v-for="method in methods"
                                   :key="method.value"
                                   :label="method.label"
                                   :value="method.value"></el-option>
                    </el-select>
                    <input type="hidden" name="method[]" :value="method" v-for="method in selectedMethods" :key="method">
                </el-form-item>
                <el-form-item label="请求地址">
                    <el-input name="url" value="{{ old('url') }}" placeholder="请输入请求地址"></el-input>
                </el-form-item>
                <el-button type="primary" native-type="submit">添加</el-button>
            </el-form>
        </el-col>
    </el-row>

@endsection

@section('js')
    <script>
        new Vue({
            el: '#app',
            data: function () {
                return {
                    methods: [
                        {
                            value: 'GET',
                            label: 'GET'
                        },
                        {
                            value: 'POST',
                            label: 'POST'
                        },
                        {
                            value: 'PUT',
                            label: 'PUT'
                        }
                    ],
                    selectedMethods: []
                }
            }
        });
    </script>
@endsection