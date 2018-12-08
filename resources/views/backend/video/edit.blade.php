@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑视频'])

    <form action="" method="post">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="row row-cards">
            <div class="col-sm-12">
                <a href="{{ route('backend.video.index') }}" class="btn btn-primary ml-auto">返回列表</a>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>课程</label>
                    <select name="course_id" class="form-control">
                        <option value="">无</option>
                        @foreach($courses as $course)
                            <option value="{{$course->id}}" {{$video->course_id == $course->id ? 'selected' : ''}}>{{$course->title}}</option>
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
                    <input type="text" class="form-control" name="title" value="{{$video->title}}" placeholder="视频名">
                </div>
                <div class="form-group">
                    <label>上传视频</label>
                    @include('components.backend.video', ['video' => $video])
                </div>
                <div class="form-group">
                    <label>描述</label>
                    @include('components.backend.editor', ['name' => 'description', 'content' => $video->description])
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>一句话介绍</label>
                    <textarea name="short_description" class="form-control"
                              rows="2" placeholder="一句话介绍">{{$video->short_description}}</textarea>
                </div>
                <div class="form-group">
                    <label>上架时间</label>
                    @include('components.backend.datetime', ['name' => 'published_at', 'value' => $video->published_at])
                </div>
                <div class="form-group">
                    <label>是否显示</label><br>
                    <label><input type="radio" name="is_show"
                                  value="{{ \App\Models\Video::IS_SHOW_YES }}"
                                {{$video->is_show == \App\Models\Video::IS_SHOW_YES ? 'checked' : ''}}>是</label>
                    <label><input type="radio" name="is_show"
                                  value="{{ \App\Models\Video::IS_SHOW_NO }}"
                                {{$video->is_show == \App\Models\Video::IS_SHOW_NO ? 'checked' : ''}}>否</label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>价格</label>
                    <input type="text" name="charge" placeholder="价格" class="form-control" value="{{$video->charge}}">
                </div>
                <div class="form-group">
                    <label>SEO关键字</label>
                    <textarea name="seo_keywords" class="form-control" rows="2" placeholder="SEO关键字">{{$video->seo_keywords}}</textarea>
                </div>
                <div class="form-group">
                    <label>SEO描述</label>
                    <textarea name="seo_description" class="form-control" rows="2" placeholder="SEO描述">{{$video->seo_description}}</textarea>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('js')
    @include('components.backend.aliyun_upload_js')
    <script>
        $(function () {
            var selectedChapterId = '{{$video->chapter_id}}';

            var request = function (courseId) {
                $.getJSON(`/backend/ajax/course/${courseId}/chapters`, function (res) {
                    var html = '';
                    $.each(res, function (key, item) {
                        selected = selectedChapterId == item.id ? 'selected' : '';
                        html += `<option value='${item.id}' ${selected}>${item.title}</option>`;
                    });
                    $('select[name="chapter_id"]').html(html);
                })
            };

            $('select[name="course_id"]').change(function () {
                request($(this).val());
            });

            request('{{$video->course_id}}');
        });
    </script>
@endsection
