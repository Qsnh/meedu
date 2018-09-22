@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => 'FAQ文章'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.faq.article.create') }}'" :name="'添加'"></meedu-a>
        </el-col>

        <el-col :span="24">
            <el-table :data="articles" style="width: 100%">
                <el-table-column
                        prop="id"
                        label="ID">
                </el-table-column>
                <el-table-column
                        prop="category.name"
                        label="分类">
                </el-table-column>
                <el-table-column
                        prop="title"
                        label="标题">
                </el-table-column>
                <el-table-column
                        prop="updated_at"
                        label="最后编辑时间">
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

    <meedu-pagination :pagination="remoteData"></meedu-pagination>

@endsection

@section('js')
    <script>
        var pagination = @json($articles);
        new Vue({
            el: '#app',
            data: function () {
                return {
                    remoteData: pagination
                }
            },
            computed: {
                articles: function () {
                    return this.remoteData.data;
                }
            }
        });
    </script>
@endsection