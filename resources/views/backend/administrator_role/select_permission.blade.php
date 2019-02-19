@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '角色授权'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.administrator_role.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    @foreach($permissions as $permission)
                        <label>
                            <input type="checkbox"
                                   name="permission_id[]"
                                   value="{{ $permission->id }}"
                                    {{ $role->hasPermission($permission) ? 'checked' : '' }}> {{ $permission->display_name }}
                        </label><br>
                    @endforeach
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>

@endsection