@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '用户角色[VIP]'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.role.create') }}'" :name="'添加'"></meedu-a>
        </el-col>

        <el-col :span="24">
            <el-table :data="roles" style="width: 100%">
                <el-table-column
                        prop="id"
                        label="ID">
                </el-table-column>
                <el-table-column
                        prop="weight"
                        label="权重">
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="角色名">
                </el-table-column>
                <el-table-column
                        prop="charge"
                        label="价格">
                </el-table-column>
                <el-table-column
                        prop="expire_days"
                        label="时长（单位：天）">
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

@endsection

@section('js')
    <script>
        var Page = new Vue({
            el: '#app',
            data: function () {
                return {
                    roles: @json($roles)
                }
            }
        });
    </script>
@endsection