@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '友情链接'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.link.create') }}'" :name="'添加'"></meedu-a>
        </el-col>

        <el-col :span="24">
            <el-table :data="roles" style="width: 100%">
                <el-table-column
                        prop="id"
                        label="ID">
                </el-table-column>
                <el-table-column
                        prop="sort"
                        label="排序">
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="链接名">
                </el-table-column>
                <el-table-column
                        prop="url"
                        label="链接地址">
                </el-table-column>
                <el-table-column
                        prop="created_at"
                        label="添加时间">
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
        var Page = new Vue({
            el: '#app',
            data: function () {
                return {
                    roles: @json($links)
                }
            }
        });
    </script>
@endsection