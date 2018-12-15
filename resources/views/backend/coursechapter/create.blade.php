@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加课程章节'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.coursechapter.index', $course->id) }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label>排序（升序） @include('components.backend.required')</label>
                    <input type="text" name="sort" class="form-control" placeholder="排序（升序：小数靠前）" required>
                </div>
                <div class="form-group">
                    <label>章节名 @include('components.backend.required')</label>
                    <input type="text" name="title" class="form-control" placeholder="章节名" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">创建</button>
                </div>
            </form>
        </div>
    </div>

@endsection