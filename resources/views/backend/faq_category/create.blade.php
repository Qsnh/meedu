@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加FAQ分类'])

    <el-row>
        <el-col :span="24" style="margin-bottom: 20px;">
            <meedu-a :url="'{{ route('backend.faq.category.index') }}'" :name="'返回列表'"></meedu-a>
        </el-col>
    </el-row>

    <el-row :gutter="20">
        <el-form label-position="top" method="post">
            {!! csrf_field() !!}
            <el-col :span="12" :offset="6">
                <el-form-item label="排序值（整数，升序）">
                    <el-input name="sort" placeholder="排序值（整数，升序）" value="{{ old('sort') }}"></el-input>
                </el-form-item>

                <el-form-item label="分类名">
                    <el-input name="name" placeholder="分类名" value="{{ old('name') }}"></el-input>
                </el-form-item>

                <el-form-item>
                    <el-button native-type="submit" type="primary" native-button="submit">添加</el-button>
                </el-form-item>
            </el-col>
        </el-form>
    </el-row>

@endsection

@section('js')
    <script>
        new Vue({
            el: '#app',
            data: function () {
                return {
                }
            }
        });
    </script>
@endsection