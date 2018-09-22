@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '权限列表'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.administrator_permission.create') }}'" :name="'添加'"></meedu-a>
        </el-col>
        <el-col :span="24">
            <el-table :data="administrators" style="width: 100%">
                <el-table-column
                        prop="display_name"
                        label="权限名">
                </el-table-column>
                <el-table-column
                        prop="slug"
                        label="Slug">
                </el-table-column>
                <el-table-column
                        prop="description"
                        label="描述">
                </el-table-column>
                <el-table-column
                        prop="method"
                        label="请求方法">
                </el-table-column>
                <el-table-column
                        prop="url"
                        label="请求地址">
                </el-table-column>
                <el-table-column
                        prop="created_at"
                        label="创建时间">
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
                    remoteData: @json($permissions),
                }
            },
            computed: {
                administrators: function () {
                    var data = this.remoteData.data;
                    return data;
                }
            }
        });
    </script>
@endsection