@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">更换头像</div>
                    <div class="card-body">
                        <form enctype="multipart/form-data" action="" method="post" class="form-horizontal">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>选择头像文件（支持png,jpg,gif格式）</label><br>
                                <input type="file" name="file">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">更换</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection