@extends('layouts.member')

@section('member')

    <div class="row">
        <h3>修改密码</h3>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-4" style="margin-top: 50px;">
            <form action="" method="post" class="form-horizontal">
                @csrf
                <div class="form-group">
                    <label>原密码</label>
                    <input type="password" name="old_password" placeholder="原密码" class="form-control" required>
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
                    <button class="btn btn-primary btn-block">重置</button>
                </div>
            </form>
        </div>
    </div>
    
@endsection