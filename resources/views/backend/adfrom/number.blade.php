@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '推广链接'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.adfrom.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12 mt-2">
            <h3>{{$one->from_name}}的推广效果</h3>
            <canvas id="chart"></canvas>
        </div>
    </div>

@endsection

@section('js')
    <script crossorigin="anonymous" integrity="sha384-WJu6cbQvbPRsw+66L1nOomDAZzhTALnUlpchFlWHimhJ9o95CMue7xEZXXDRKV2S" src="https://lib.baomitu.com/Chart.js/2.7.3/Chart.min.js"></script>
    <script>
        var labels = @json($rows->pluck('x'));
        var data = @json($rows->pluck('y'));
        var myLineChart = new Chart('chart', {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: '点击量',
                    data: data,
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    fill: false
                }]
            }
        });
    </script>

@endsection