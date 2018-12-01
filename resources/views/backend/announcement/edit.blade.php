@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加公告'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a class="btn btn-primary ml-auto" href="{{ route('backend.announcement.index') }}">返回公告列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label>公告内容</label>
                    @include('components.backend.editor', ['name' => 'announcement', 'content' => $announcement->announcement])
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script>
        var announcement = @json($announcement);
        new Vue({
            el: '#app',
            data: function () {
                return {
                    announcement: announcement
                }
            }
        });
    </script>
@endsection