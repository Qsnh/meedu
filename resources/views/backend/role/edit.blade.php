@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑VIP'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.role.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label class="form-label">VIP名</label>
                    <input type="text" name="name" value="{{$role->name}}" class="form-control" placeholder="VIP名">
                </div>
                <div class="form-group">
                    <label class="form-label">价格</label>
                    <input type="text" name="charge" value="{{$role->charge}}" class="form-control" placeholder="价格">
                </div>
                <div class="form-group">
                    <label class="form-label">有效期（单位：天）</label>
                    <input type="text" name="expire_days" value="{{$role->expire_days}}" class="form-control" placeholder="有效期（单位：天）">
                </div>
                <div class="form-group">
                    <label class="form-label">权重（权重越大，权限越大）</label>
                    <input type="text" name="weight" value="{{$role->weight}}" class="form-control" placeholder="权重（权重越大，权限越大）">
                </div>
                <div class="form-group">
                    <label class="form-label">权限内容(一行一条)</label>
                    <textarea name="description" class="form-control" rows="5" placeholder="权限内容(一行一条)">{{$role->description}}</textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>

@endsection