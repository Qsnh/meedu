@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '权限列表'])

    <el-row>
        <el-col :span="24">
            @include('components.button', ['url' => route('backend.administrator_permission.create'), 'title' => '添加'])
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
                        <el-button
                                size="mini"
                                @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                        <el-button
                                size="mini"
                                type="danger"
                                @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </el-col>
    </el-row>

@endsection

@section('js')
    <script>
        Vue.mixin({
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
            },
            methods: {
                handleEdit: function (index, item) {
                    location.href = item.edit_url;
                },
                handleDelete: function (index, item) {
                    if (confirm('确定删除？')) {
                        location.href = item.destroy_url;
                    }
                },
            }
        });
    </script>
@endsection