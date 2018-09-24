@extends('layouts.member')

@section('member')

    <div class="col-sm-5">
        <form action="" method="post" class="form-horizontal">
            {!! csrf_field() !!}
            <div class="form-group">
                <label>原密码</label>
                <input type="password" name="old_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>新密码</label>
                <input type="password" placeholder="请输入新密码" name="new_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>确认密码</label>
                <input type="password" placeholder="再输入一次" name="new_password_confirmation" class="form-control" required>
            </div>
            <div class="form-group">
                <button class="btn btn-primary">重置</button>
            </div>
        </form>
    </div>
    
@endsection