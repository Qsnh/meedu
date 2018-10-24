@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加菜单'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.administrator_menu.index') }}'" :name="'返回后台菜单'"></meedu-a>
        </el-col>
        <el-col :span="12" :offset="6">
            <el-form label-position="top" method="post">
                @csrf
                <el-form-item label="父菜单">
                    <select name="parent_id">
                        <option value="0">无父菜单</option>
                        @foreach($menus as $menu)
                        <option value="{{$menu->id}}">{{$menu->name}}</option>
                            @foreach($menu->children as $child)
                                <option value="{{$child->id}}" disabled="disabled">|----{{$child->name}}</option>
                            @endforeach
                        @endforeach
                    </select>
                </el-form-item>
                <el-form-item label="排序（升序）">
                    <el-input name="order" value="{{ old('order') }}" placeholder="请输入整数"></el-input>
                </el-form-item>
                <el-form-item label="链接名">
                    <el-input name="name" value="{{ old('name') }}" placeholder="请输入链接名"></el-input>
                </el-form-item>
                <el-form-item label="链接地址">
                    <el-input name="url" value="{{ old('url') }}" placeholder="请输入链接地址"></el-input>
                </el-form-item>
                <el-form-item label="权限">
                    <select name="permission_id">
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->display_name }}</option>
                        @endforeach
                    </select>
                </el-form-item>
                <el-button type="primary" native-type="submit">添加</el-button>
            </el-form>
        </el-col>
    </el-row>

@endsection

@section('js')
    @include('components.vue_init')
@endsection