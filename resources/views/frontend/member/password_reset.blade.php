@extends('layouts.member')

@section('member')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4 br-8 mb-4">
                <div class="card">
                    <div class="card-header">修改密码</div>
                    <div class="card-body">
                        <form method="post" action="">
                            @csrf
                            <div class="form-group">
                                <label>原密码</label>
                                <input type="password" name="old_password" placeholder="原密码" class="form-control"
                                       required>
                            </div>
                            <div class="form-group">
                                <label>新密码</label>
                                <input type="password" placeholder="请输入新密码" name="new_password" class="form-control"
                                       required>
                            </div>
                            <div class="form-group">
                                <label>确认密码</label>
                                <input type="password" placeholder="再输入一次" name="new_password_confirmation"
                                       class="form-control" required>
                            </div>
                            <div class="form-group text-right">
                                <button class="btn btn-primary" type="submit">修改密码</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection