@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加FAQ文章'])

    <el-row>
        <el-col :span="24" style="margin-bottom: 20px;">
            <meedu-a :url="'{{ route('backend.faq.article.index') }}'" :name="'返回列表'"></meedu-a>
        </el-col>
    </el-row>

    <el-row :gutter="20">
        <el-form label-position="top" method="post">
            {!! csrf_field() !!}
            <el-col :span="12" :offset="6">

                <el-form-item label="FAQ分类">
                    <select name="category_id">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </el-form-item>

                <el-form-item label="文章标题">
                    <el-input name="title" placeholder="文章标题" value="{{ old('title') }}"></el-input>
                </el-form-item>

                <el-form-item label="文章内容">
                    <meedu-markdown :markdown="''" field="content"></meedu-markdown>
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