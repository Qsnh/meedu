@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '角色授权'])

    <el-row>
        <el-col :span="24">
            @include('components.button', ['url' => route('backend.administrator_role.index'), 'title' => '返回角色列表'])
        </el-col>
        <el-col :span="12" :offset="6">
            <el-form label-position="top" method="post">
                {!! csrf_field() !!}
                @foreach($permissions as $permission)
                    <label>
                        <input type="checkbox"
                               name="permission_id[]"
                               value="{{ $permission->id }}"
                                {{ $role->hasPermission($permission) ? 'checked' : '' }}> {{ $permission->display_name }}
                    </label>
                @endforeach
                <br><br>
                <el-button type="primary" native-type="submit">授权</el-button>
            </el-form>
        </el-col>
    </el-row>

@endsection