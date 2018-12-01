@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加菜单'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.administrator_menu.index') }}" class="btn btn-primary ml-auto">返回菜单</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label>父菜单</label>
                    <select name="parent_id" class="form-control">
                        <option value="0">无父菜单</option>
                        @foreach($menus as $menu)
                            <option value="{{$menu->id}}">{{$menu->name}}</option>
                            @foreach($menu->children as $child)
                                <option value="{{$child->id}}" disabled="disabled">|----{{$child->name}}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>排序</label>
                    <input type="text" name="order" class="form-control" placeholder="排序" value="">
                </div>
                <div class="form-group">
                    <label>链接名</label>
                    <input type="text" name="name" class="form-control" placeholder="链接名" value="">
                </div>
                <div class="form-group">
                    <label>链接地址</label>
                    <input type="text" name="url" class="form-control" placeholder="链接地址" value="">
                </div>
                <div class="form-group">
                    <label>关联权限</label>
                    <select name="permission_id" class="form-control">
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">添加</button>
                </div>
            </form>
        </div>
    </div>

@endsection