@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑权限'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.administrator_permission.index') }}'" :name="'返回权限列表'"></meedu-a>
        </el-col>
        <el-col :span="12" :offset="6">
            <el-form label-position="top" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">
                <el-form-item label="Slug">
                    <el-input name="slug" value="{{ $permission->slug }}" disabled></el-input>
                </el-form-item>
                <el-form-item label="权限名">
                    <el-input name="display_name" value="{{ $permission->display_name }}" placeholder="请输入权限名"></el-input>
                </el-form-item>
                <el-form-item label="描述">
                    <el-input name="description" value="{{ $permission->description }}" placeholder="请输入描述"></el-input>
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
                    <el-input name="url" value="{{ $permission->url }}" placeholder="请输入请求地址"></el-input>
                </el-form-item>
                <el-button type="primary" native-type="submit">编辑</el-button>
            </el-form>
        </el-col>
    </el-row>

@endsection

@section('js')
    <script>
        var selectedMethods = JSON.parse('@json($permission->getMethodArray())');
        Vue.mixin({
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
                    selectedMethods: selectedMethods
                }
            }
        });
    </script>
@endsection