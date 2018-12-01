@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '订单列表'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <form action="" method="get">
                <div class="form-group">
                    <label>用户呢称/手机号</label>
                    <input type="text" class="form-control" name="keywords" value="{{ request()->input('keywords', '') }}" placeholder="请输入关键字">
                </div>
                <div class="form-group">
                    <label>状态</label>
                    <select name="status" class="form-control">
                        <option value="">无</option>
                        <option value="9" {{input_equal('status', 9) ? 'selected' : ''}}>已支付</option>
                        <option value="1" {{input_equal('status', 1) ? 'selected' : ''}}>未支付</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">过滤</button>
                    <a href="{{ route('backend.orders') }}" class="btn btn-warning">重置</a>
                </div>
            </form>
        </div>
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>订单号</th>
                    <th>商品</th>
                    <th>用户</th>
                    <th>总金额</th>
                    <th>状态</th>
                    <th>时间</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{$order->order_id}}</td>
                    <td>
                        @foreach($order->goods as $good)
                            <span class="badge badge-info">{{$good->getGoodsTypeText()}}</span>
                        @endforeach
                    </td>
                    <td>{{$order->user->nick_name}}</td>
                    <td>{{$order->charge}}</td>
                    <td>{{$order->statusText()}}</td>
                    <td>{{$order->updated_at}}</td>
                </tr>
                    @empty
                <tr>
                    <td class="text-center" colspan="6">暂无记录</td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{$orders->render()}}

@endsection