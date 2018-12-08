@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加视频'])

    <form action="" method="post">
        @csrf
        <div class="row row-cards">
            <div class="col-sm-12">
                <a href="{{ route('backend.video.index') }}" class="btn btn-primary ml-auto">返回列表</a>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>课程</label>
                    <select name="course_id" class="form-control">
                        <option value="">请选择</option>
                        @foreach($courses as $course)
                        <option value="{{$course->id}}">{{$course->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>章节</label>
                    <select name="chapter_id" class="form-control">
                        <option value="">请选择</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>课程名</label>
                    <input type="text" class="form-control" name="title" value="{{old('title')}}" placeholder="视频名">
                </div>
                <div class="form-group">
                    <label>上传视频</label>
                    @include('components.backend.video')
                </div>
                <div class="form-group">
                    <label>描述</label>
                    @include('components.backend.editor', ['name' => 'description'])
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>一句话介绍</label>
                    <textarea name="short_description" class="form-control" rows="2" placeholder="一句话介绍"></textarea>
                </div>
                <div class="form-group">
                    <label>上架时间</label>
                    @include('components.backend.datetime', ['name' => 'published_at', 'value' => date('Y-m-d H:i:s')])
                </div>
                <div class="form-group">
                    <label>是否显示</label><br>
                    <label><input type="radio" name="is_show" value="{{ \App\Models\Video::IS_SHOW_YES }}" checked>是</label>
                    <label><input type="radio" name="is_show" value="{{ \App\Models\Video::IS_SHOW_NO }}">否</label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>价格</label>
                    <input type="text" name="charge" placeholder="价格" class="form-control" value="{{old('charge')}}">
                </div>
                <div class="form-group">
                    <label>SEO关键字</label>
                    <textarea name="seo_keywords" class="form-control" rows="2" placeholder="SEO关键字"></textarea>
                </div>
                <div class="form-group">
                    <label>SEO描述</label>
                    <textarea name="seo_description" class="form-control" rows="2" placeholder="SEO描述"></textarea>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">创建</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('js')
@include('components.backend.aliyun_upload_js')
<script>
    $(function () {
        $('select[name="course_id"]').change(function () {
            var courseId = $(this).val();
            $.getJSON(`/backend/ajax/course/${courseId}/chapters`, function (res) {
                var html = '';
                $.each(res, function (key, item) {
                    html += `<option value='${item.id}'>${item.title}</option>`;
                })
                $('select[name="chapter_id"]').html(html);
            })
        });
    });
</script>
@endsection