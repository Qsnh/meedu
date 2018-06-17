@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '角色列表'])

    <el-row>
        <el-col :span="24">
            @include('components.button', ['url' => route('backend.administrator_role.create'), 'title' => '添加'])
        </el-col>
        <el-col :span="24">
            <el-table :data="administrators" style="width: 100%">
                <el-table-column
                        prop="display_name"
                        label="角色名">
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
                        <el-button
                                size="mini"
                                type="primary"
                                @click="handlePermission(scope.$index, scope.row)">授权</el-button>
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
                    remoteData: @json($roles),
                }
            },
            computed: {
                administrators: function () {
                    var roles = this.remoteData.data;
                    return roles;
                }
            },
            methods: {
                handleEdit: function (index, role) {
                    location.href = role.edit_url;
                },
                handleDelete: function (index, role) {
                    if (confirm('确定删除？')) {
                        location.href = role.destroy_url;
                    }
                },
                handlePermission: function (index, role) {
                    location.href = role.permission_url;
                }
            }
        });
    </script>
@endsection