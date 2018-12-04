@extends('install.layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-info">
                    <div class="card-header">
                        管理员信息配置
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <div class="form-group">
                                <label>邮箱账号</label>
                                <input type="text" name="username" placeholder="邮箱账号" value="{{old('username')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>密码</label>
                                <input type="text" name="password" placeholder="密码" class="form-control">
                            </div>
                            <div class="form-group justify-content-end">
                                <a href="{{route('install.step2')}}" class="btn btn-warning">返回上一步</a>
                                <button class="btn btn-info">下一步</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection