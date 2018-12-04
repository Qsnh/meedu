@extends('install.layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-info">
                    <div class="card-header">
                        请配置数据库信息
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <div class="form-group">
                                <label>数据库地址</label>
                                <input type="text" name="DB_HOST" value="{{old('DB_HOST', '127.0.0.1')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>数据库名</label>
                                <input type="text" name="DB_DATABASE" value="{{old('DB_DATABASE')}}" placeholder="数据库名" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>数据库用户名</label>
                                <input type="text" name="DB_USERNAME" value="{{old('DB_USERNAME')}}" placeholder="数据库用户名" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>数据库密码</label>
                                <input type="password" name="DB_PASSWORD" value="{{old('DB_PASSWORD')}}" placeholder="数据库密码" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>连接端口</label>
                                <input type="text" name="DB_PORT" value="{{old('DB_PORT', 3306)}}" placeholder="连接端口" class="form-control">
                            </div>
                            <div class="form-group justify-content-end">
                                <a href="{{route('install.step1')}}" class="btn btn-warning">返回上一步</a>
                                <button class="btn btn-info">下一步</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection