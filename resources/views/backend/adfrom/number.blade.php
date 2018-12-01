@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '推广链接'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.adfrom.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12 mt-2">
            <h3>{{$one->from_name}}的推广效果</h3>
            <div id="mountNode"></div>
        </div>
    </div>

@endsection

@section('js')
    <script>document.body.clientHeight;</script>
    <script src="https://gw.alipayobjects.com/os/antv/pkg/_antv.g2-3.4.1/dist/g2.min.js"></script>
    <script src="https://gw.alipayobjects.com/os/antv/pkg/_antv.data-set-0.10.1/dist/data-set.min.js"></script>
    <script>
        var data = @json($rows);
        var chart = new G2.Chart({
            container: 'mountNode',
            forceFit: true,
            height: window.innerHeight
        });
        chart.source(data);
        chart.scale('value', {
            min: 0
        });
        chart.scale('label', {
            range: [0, 1]
        });
        chart.tooltip({
            crosshairs: {
                type: 'line'
            }
        });
        chart.line().position('label*value');
        chart.point().position('label*value').size(4).shape('circle').style({
            stroke: '#fff',
            lineWidth: 1
        });
        chart.render();
    </script>

@endsection