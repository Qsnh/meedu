@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-12 py-4">
                共{{$messages->total()}}条记录
            </div>
            <div class="col-12">
                <div class="w-100 float-left bg-fff px-3 pt-5 br-8 mb-4">
                    <table class="table table-hover">
                        <tbody>
                        @forelse($messages as $message)
                            <tr>
                                <td>
                                    {!! $message['message'] !!}
                                </td>
                            </tr>
                        @empty
                            <tr><td>暂无数据</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($messages->total() > $messages->perPage())
                <div class="col-md-12">
                    <div class="w-100 float-left bg-fff mb-4 br-8 px-3 py-4">
                        {{$messages->render()}}
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection