@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑章节'])

    <el-row>
        <el-col :span="24" style="margin-bottom: 20px;">
            <meedu-a :url="'{{ route('backend.book.chapter.index', [$book->id]) }}'" :name="'返回章节列表'"></meedu-a>
        </el-col>
    </el-row>

    <el-row :gutter="20">
        <el-form label-position="top" method="post">
            <input type="hidden" name="book_id" value="{{$book->id}}">
            <input type="hidden" name="_method" value="PUT">
            {!! csrf_field() !!}
            <el-col :span="12">
                <el-form-item label="章节名">
                    <el-input name="title" placeholder="书名" v-model="chapter.title"></el-input>
                </el-form-item>
                <el-form-item label="内容">
                    <meedu-markdown :markdown="chapter.content" field="content"></meedu-markdown>
                </el-form-item>
            </el-col>

            <el-col :span="12">

                <el-form-item label="是否显示">
                    <label><input type="radio" name="is_show" value="{{ \App\Models\Course::SHOW_YES }}" v-model="chapter.is_show"> 是</label>
                    <label><input type="radio" name="is_show" value="{{ \App\Models\Course::SHOW_NO }}" v-model="chapter.is_show"> 否</label>
                </el-form-item>

                <el-form-item label="上架时间">
                    <el-date-picker
                            v-model="chapter.published_at"
                            type="datetime"
                            placeholder="选择上线时间"
                            name="published_at">
                    </el-date-picker>
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
        new Vue({
            el: '#app',
            data: function () {
                return {
                    chapter: @json($chapter)
                }
            }
        });
    </script>
@endsection