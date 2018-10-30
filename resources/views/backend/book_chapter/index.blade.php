@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '章节列表'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.book.chapter.create', [$book->id]) }}'" :name="'添加'"></meedu-a>
        </el-col>

        <p style="line-height: 46px;">电子书 <b>《{{$book->title}}》</b> 的章节</p>

        <el-col :span="24">
            <el-table :data="chapters" style="width: 100%">
                <el-table-column
                        prop="id"
                        label="ID">
                </el-table-column>
                <el-table-column
                        prop="title"
                        label="章节名">
                </el-table-column>
                <el-table-column
                        prop="published_at"
                        label="上线时间">
                </el-table-column>
                <el-table-column label="显示">
                    @verbatim
                        <template slot-scope="scope">
                            <el-tag :type="scope.row.is_show == 1 ? 'success' : 'default'"
                                    disable-transitions>{{scope.row.is_show == 1 ? '显示' : '不显示'}}</el-tag>
                        </template>
                    @endverbatim
                </el-table-column>
                <el-table-column label="操作">
                    <template slot-scope="scope">
                        <meedu-a :size="'mini'" :name="'编辑'" :type="'warning'" :url="scope.row.edit_url"></meedu-a>
                        <meedu-destroy-button :url="scope.row.destroy_url"></meedu-destroy-button>
                    </template>
                </el-table-column>
            </el-table>
        </el-col>
    </el-row>

@endsection

@section('js')
    <script>
        new Vue({
            el: '#app',
            data: function () {
                return {
                    chapters: @json($chapters)
                }
            }
        });
    </script>
@endsection