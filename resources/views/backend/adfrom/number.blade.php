@extends('layouts.backend')

@section('title')
    推广效果
@endsection

@section('body')

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.adfrom.index') }}" class="btn btn-primary">返回列表</a>
        </div>
        <div class="col-sm-12 mt-2">
            <div class="card">
                <h4 class="card-title">{{$one->from_name}}的推广效果</h4>
                <div class="card-body">
                    <canvas id="chart" width="280" height="280"></canvas>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        app.ready(function () {
            new Chart($("#chart"), {
                type: 'line',
                data: {
                    labels: @json($rows->pluck('x')),
                    datasets: [{
                        label: '点击量',
                        data: @json($rows->pluck('y')),
                        fill: false,
                        borderWidth: 3,
                        pointRadius: 5,
                        borderColor: "#9966ff",
                        pointBackgroundColor: "#9966ff",
                        pointBorderColor: "#9966ff",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "#9966ff",
                    }]
                }
            });
        });
    </script>

@endsection