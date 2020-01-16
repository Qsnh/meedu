@extends('layouts.member')

@section('member')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4 br-8 mb-4">
                <div class="card">
                    <div class="card-header">更换头像</div>
                    <div class="card-body">
                        <form method="post" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="alert alert-info">
                                <p class="mb-0">1.支持png,jpg,gif图片格式。</p>
                                <p class="mb-0">2.图片大小不能超过1MB。</p>
                            </div>
                            <div class="form-group">
                                <label>选择头像文件</label><br>
                                <input type="file" name="file">
                            </div>
                            <div class="form-group text-right mt-5">
                                <button class="btn btn-primary btn-block" type="submit">更换头像</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection