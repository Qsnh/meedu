@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑图书'])

    <el-row>
        <el-col :span="24" style="margin-bottom: 20px;">
            <meedu-a :url="'{{ route('backend.book.index') }}'" :name="'返回图书列表'"></meedu-a>
        </el-col>
    </el-row>

    <el-row :gutter="20">
        <el-form label-position="top" method="post">
            <input type="hidden" name="_method" value="PUT">
            {!! csrf_field() !!}
            <el-col :span="12">
                <el-form-item label="书名">
                    <el-input name="title" placeholder="书名" v-model="book.title"></el-input>
                </el-form-item>
                <el-form-item label="描述">
                    <meedu-markdown :markdown="book.description" field="description"></meedu-markdown>
                </el-form-item>
            </el-col>
            <el-col :span="12">
                <el-form-item label="简短介绍">
                    <el-input type="textarea"
                              name="short_description"
                              placeholder="简短介绍"
                              v-model="book.short_description"></el-input>
                </el-form-item>
                <el-form-item label="课程封面">
                    <meedu-upload-image :field="'thumb'" :give-image-url="book.thumb"></meedu-upload-image>
                </el-form-item>
                <el-form-item label="上架时间">
                    <el-date-picker
                            v-model="book.published_at"
                            type="datetime"
                            placeholder="选择上线时间"
                            name="published_at">
                    </el-date-picker>
                </el-form-item>

                <el-form-item>
                    <el-button native-type="submit" type="primary" native-button="submit">保存</el-button>
                </el-form-item>

                <hr>

                <el-form-item label="是否显示">
                    <label><input type="radio" name="is_show" value="{{ \App\Models\Course::SHOW_YES }}" v-model="book.is_show"> 是</label>
                    <label><input type="radio" name="is_show" value="{{ \App\Models\Course::SHOW_NO }}" v-model="book.is_show"> 否</label>
                </el-form-item>
                <el-form-item label="价格">
                    <el-input name="charge" placeholder="价格" v-model="book.charge"></el-input>
                </el-form-item>
                <el-form-item label="SEO关键词">
                    <el-input type="textarea"
                              name="seo_keywords"
                              placeholder="SEO关键词"
                              v-model="book.seo_keywords"></el-input>
                </el-form-item>
                <el-form-item label="SEO描述">
                    <el-input type="textarea"
                              name="seo_description"
                              placeholder="SEO描述"
                              v-model="book.seo_description"></el-input>
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
                    book: @json($book)
                }
            }
        });
    </script>
@endsection