@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '公告'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.announcement.create') }}'" :name="'添加'"></meedu-a>
        </el-col>
        <el-col :span="24">
            <el-table :data="announcements" style="width: 100%">
                <el-table-column
                        prop="administrator.name"
                        label="添加人">
                </el-table-column>
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
                    remoteData: @json($announcements),
                }
            },
            computed: {
                announcements: function () {
                    return this.remoteData.data;
                }
            }
        });
        (new Page).$mount('#app-body');
    </script>
@endsection