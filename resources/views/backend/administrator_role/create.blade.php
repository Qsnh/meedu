@extends('layouts.backend')

@section('title')
    添加角色
@endsection

@section('body')

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.administrator_role.index') }}" class="btn btn-primary">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label>角色名 @include('components.backend.required')</label>
                    <input type="text" name="display_name" class="form-control" placeholder="请输入角色名" required>
                </div>
                <div class="form-group">
                    <label>Slug @include('components.backend.required')</label>
                    <input type="text" name="slug" class="form-control" placeholder="Slug" required>
                </div>
                <div class="form-group">
                    <label>描述 @include('components.backend.required')</label>
                    <input type="text" name="description" class="form-control" placeholder="描述" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">创建</button>
                </div>
            </form>
        </div>
    </div>

@endsection