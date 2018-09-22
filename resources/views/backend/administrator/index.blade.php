@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '管理员列表'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.administrator.create') }}'" :name="'添加'"></meedu-a>
        </el-col>
        <el-col :span="24">
            <el-table :data="administrators" style="width: 100%">
                <el-table-column
                        prop="name"
                        label="姓名">
                </el-table-column>
                <el-table-column
                        prop="email"
                        label="邮箱">
                </el-table-column>
                <el-table-column
                        prop="last_login_ip"
                        label="最后登录">
                    @verbatim
                    <template slot-scope="scope">
                        {{scope.row.last_login_date}}/{{scope.row.last_login_ip}}
                    </template>
                    @endverbatim
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
                    remoteData: @json($administrators),
                }
            },
            computed: {
                administrators: function () {
                    var administrators = this.remoteData.data;
                    return administrators;
                }
            }
        });
    </script>
@endsection