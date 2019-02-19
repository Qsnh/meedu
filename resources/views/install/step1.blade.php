@extends('install.layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        请配置基本信息
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <div class="form-group">
                                <label>网站名</label>
                                <input type="text" name="APP_NAME" value="MeEdu" placeholder="网站名" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>网站地址(包括 <code>http://</code> 或 <code>https://</code>)</label>
                                <input type="text" name="APP_URL" value="{{request()->getBaseUrl()}}" placeholder="网站地址" class="form-control">
                            </div>
                            <div class="form-group justify-content-end">
                                <button class="btn btn-info">下一步</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection