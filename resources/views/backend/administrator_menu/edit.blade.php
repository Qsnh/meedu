@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑菜单'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.administrator_menu.index') }}'" :name="'返回后台菜单'"></meedu-a>
        </el-col>
        <el-col :span="12" :offset="6">
            <el-form label-position="top" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <el-form-item label="父菜单">
                    <select name="parent_id" v-model="menu.parent_id">
                        <option value="0">无父菜单</option>
                        @foreach($menus as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @foreach($item->children as $child)
                                <option value="{{$child->id}}" disabled="disabled">|----{{$child->name}}</option>
                            @endforeach
                        @endforeach
                    </select>
                </el-form-item>
                <el-form-item label="排序（升序）">
                    <el-input name="order" value="{{ old('order') }}" v-model="menu.order" placeholder="请输入整数"></el-input>
                </el-form-item>
                <el-form-item label="链接名">
                    <el-input name="name" value="{{ old('name') }}" v-model="menu.name" placeholder="请输入链接名"></el-input>
                </el-form-item>
                <el-form-item label="链接地址">
                    <el-input name="url" value="{{ old('url') }}" v-model="menu.url" placeholder="请输入链接地址"></el-input>
                </el-form-item>
                <el-form-item label="权限" v-model="menu.permission_id">
                    <select name="permission_id">
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->display_name }}</option>
                        @endforeach
                    </select>
                </el-form-item>
                <el-button type="primary" native-type="submit">保存</el-button>
            </el-form>
        </el-col>
    </el-row>

@endsection

@section('js')
    <script>
        new Vue({
            el: '#app',
            data: function () {
                return {
                    menu: @json($menu)
                }
            }
        })
    </script>
@endsection