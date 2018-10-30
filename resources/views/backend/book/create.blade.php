@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加电子书'])

    <el-row>
        <el-col :span="24" style="margin-bottom: 20px;">
            <meedu-a :url="'{{ route('backend.book.index') }}'" :name="'返回电子书列表'"></meedu-a>
        </el-col>
    </el-row>

    <el-row :gutter="20">
        <el-form label-position="top" method="post">
            {!! csrf_field() !!}
            <el-col :span="12">
                <el-form-item label="书名">
                    <el-input name="title" placeholder="书名" value="{{ old('title') }}"></el-input>
                </el-form-item>
                <el-form-item label="描述">
                    <meedu-markdown :markdown="''" field="description"></meedu-markdown>
                </el-form-item>
            </el-col>
            <el-col :span="12">
                <el-form-item label="简短介绍">
                    <el-input type="textarea"
                              name="short_description"
                              placeholder="简短介绍"
                              value="{{ old('short_description') }}"></el-input>
                </el-form-item>
                <el-form-item label="封面">
                    <meedu-upload-image :field="'thumb'"></meedu-upload-image>
                </el-form-item>
                <el-form-item label="上架时间">
                    <el-date-picker
                            v-model="published_at"
                            type="datetime"
                            placeholder="选择上线时间"
                            name="published_at">
                    </el-date-picker>
                </el-form-item>

                <el-form-item>
                    <el-button native-type="submit" type="primary" native-button="submit">添加</el-button>
                </el-form-item>

                <hr>

                <el-form-item label="是否显示">
                    <label><input type="radio" name="is_show" value="{{ \App\Models\Course::SHOW_YES }}" checked> 是</label>
                    <label><input type="radio" name="is_show" value="{{ \App\Models\Course::SHOW_NO }}"> 否</label>
                </el-form-item>
                <el-form-item label="价格">
                    <el-input name="charge" placeholder="价格" value="{{ old('charge', 0) }}"></el-input>
                </el-form-item>
                <el-form-item label="SEO关键词">
                    <el-input type="textarea"
                              name="seo_keywords"
                              placeholder="SEO关键词"
                              value="{{ old('seo_keywords') }}"></el-input>
                </el-form-item>
                <el-form-item label="SEO描述">
                    <el-input type="textarea"
                              name="seo_description"
                              placeholder="SEO描述"
                              value="{{ old('seo_description') }}"></el-input>
                </el-form-item>
            </el-col>
        </el-form>
    </el-row>

@endsection

@section('js')
    <script>
        var now = new Date();
        var Page = new Vue({
            el: '#app',
            data: function () {
                return {
                    published_at: now
                }
            }
        });
    </script>
@endsection