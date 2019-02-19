@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => 'FAQ分类'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.faq.category.create') }}" class="btn btn-primary ml-auto">添加</a>
        </div>
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>排序值</th>
                    <th>分类名</th>
                    <th>最后编辑时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->sort}}</td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->updated_at}}</td>
                    <td>
                        <a href="{{route('backend.faq.category.edit', $category)}}" class="btn btn-warning btn-sm">编辑</a>
                        @include('components.backend.destroy', ['url' => route('backend.faq.category.destroy', $category)])
                    </td>
                </tr>
                    @empty
                <tr>
                    <td class="text-center" colspan="5">暂无记录</td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection