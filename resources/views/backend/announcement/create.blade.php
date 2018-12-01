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
                <div class="form-group">
                    <label>公告内容</label>
                    @include('components.backend.editor', ['name' => 'announcement'])
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">添加</button>
                </div>
            </form>
        </div>
    </div>

@endsection