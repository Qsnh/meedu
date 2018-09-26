@extends('layouts.member')

@section('member')
    <div class="row">
        <h3>更换头像</h3>
    </div>
    <form enctype="multipart/form-data" action="" method="post" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="form-group">
            <label>头像</label>
            <input type="file" name="file">
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">更换</button>
        </div>
    </form>

@endsection