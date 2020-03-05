@extends('layouts.app')

@section('content')

    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center py-5">
                            <h2 class="fw-400 pt-4 c-primary">加入本站会员</h2>
                            <p class="pb-5 pt-3 fs-14px c-2">所有视频免费观看</p>
                        </div>
                        @foreach($gRoles as $index => $roleItem)
                            @if($index == 4)
                                @break
                            @endif
                            <div class="col-md-3 col-12 text-center role-item mb-3">
                                <a href="{{route('member.role.buy', [$roleItem['id']])}}" class="login-auth" data-login="{{$user ? 1 : 0}}">
                                    <div class="role-item-box px-3 py-5 {{$index == 1 ? 'bg-primary' : 'bg-fff'}} br-8 box-shadow1 t1">
                                        <p class="pb-3 name {{$index == 1 ? 'c-fff' : ''}}">{{$roleItem['name']}}</p>
                                        <p class="price {{$index == 1 ? 'c-fff' : ''}}"><b>￥{{$roleItem['charge']}}</b>
                                        </p>
                                        @foreach($roleItem['desc_rows'] as $item)
                                            <p class="p-0 desc-item {{$index == 1 ? 'c-fff' : ''}}">{{$item}}</p>
                                        @endforeach
                                    </div>
                                </a>
                            </div>
                        @endforeach


                        <div class="col-12 mt-5">
                            <h3 class="c-2 mt-3">常见问题</h3>
                            <div class="accordion mt-4" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left c-2" type="button"
                                                    data-toggle="collapse" data-target="#collapseOne"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                购买会员之后如果不满意是否可以退款？
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                         data-parent="#accordionExample">
                                        <div class="card-body">
                                            本站所有收费资源，包括但不限制课程，视频，套餐等一经购买均不可以退款，如果问题请联系客服。
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading2">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left c-2" type="button"
                                                    data-toggle="collapse" data-target="#collapse2" aria-expanded="true"
                                                    aria-controls="collapse2">
                                                会员之后是否可以下载收费视频？
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapse2" class="collapse" aria-labelledby="heading2"
                                         data-parent="#accordionExample">
                                        <div class="card-body">
                                            为了防止视频被盗版，我们不提供视频下载功能，只能在线观看。如有疑问，请联系客服。
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection