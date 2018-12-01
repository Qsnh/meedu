@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑角色'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.administrator_role.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label>角色名</label>
                    <input type="text" name="display_name" class="form-control" value="{{$role->display_name}}" placeholder="请输入角色名">
                </div>
                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" value="{{$role->slug}}" class="form-control" placeholder="Slug">
                </div>
                <div class="form-group">
                    <label>描述</label>
                    <input type="text" name="description" value="{{$role->description}}" class="form-control" placeholder="描述">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>

@endsection