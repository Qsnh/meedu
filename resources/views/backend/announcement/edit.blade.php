@extends('layouts.backend')

@section('title')
    编辑公告
@endsection

@section('body')

    <div class="row row-cards">
        <div class="col-sm-12">
            <a class="btn btn-primary" href="{{ route('backend.announcement.index') }}">返回公告列表</a>
        </div>
        <div class="col-sm-12 mt-3">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="publisher publisher-multi">
                    <textarea class="publisher-input" name="announcement" rows="3" placeholder="说点什么吧">{{$announcement->announcement}}</textarea>
                    <div class="flexbox flex-row-reverse">
                        <button type="submit" class="btn btn-sm btn-bold btn-primary">发布</button>
                    </div>
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