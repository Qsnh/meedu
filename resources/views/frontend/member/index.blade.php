@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row gap-y justify-content-center">
            @foreach($gRoles as $index => $role)
                <div class="col-sm-12 col-md-3">
                    <div class="card hover-shadow-2">
                        <div class="card-body text-center">
                            <h5 class="text-uppercase text-muted">{{$role['name']}}</h5>
                            <br>
                            <h3 class="price">
                                <sup>￥</sup>{{$role['charge']}}
                                <span>&nbsp;</span>
                            </h3>
                            <hr>
                            @foreach(explode("\n", $role['description']) as $row)
                                <p>{{$row}}</p>
                            @endforeach
                            <br><br>
                            <a class="btn btn-bold btn-block btn-primary" href="{{route('role.index')}}">立即订阅</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection