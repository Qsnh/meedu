@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form class="card" method="post" action="">
                    @csrf
                    <h4 class="card-title"><strong>修改密码</strong></h4>

                    <div class="card-body">

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

                    </div>

                    <footer class="card-footer text-right">
                        <button class="btn btn-primary" type="submit">修改密码</button>
                    </footer>
                </form>
            </div>
        </div>
    </div>
    
@endsection