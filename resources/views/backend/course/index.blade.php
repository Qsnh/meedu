@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '课程列表'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.course.create') }}'" :name="'添加'"></meedu-a>
        </el-col>

        <el-col :span="12" :offset="6">
            <el-form action="" method="get">
                <el-form-item label="课程名">
                    <el-input name="keywords"
                              value="{{ request()->input('keywords', '') }}"
                              placeholder="请输入关键字">
                    </el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" native-type="submit">搜索</el-button>
                    <meedu-a :type="'warning'" :name="'重置'" :url="'{{ route('backend.course.index') }}'">
                    </meedu-a>
                </el-form-item>
            </el-form>
        </el-col>

        <el-col :span="24">
            <el-table :data="administrators" style="width: 100%">
                <el-table-column type="expand">
                    @verbatim
                        <template slot-scope="props">
                            <div style="line-height: 26px;">
                                <p><b>Slug</b>：{{ props.row.slug }}</p>
                                <p><b>封面</b>：<br><img :src="props.row.thumb" width="200" height="120"></p>
                                <p><b>价格</b>：{{ props.row.charge }}</p>
                                <p><b>简短描述</b>：{{ props.row.short_description }}</p>
                                <p><b>SEO关键字</b>：{{ props.row.seo_keywords }}</p>
                                <p><b>SEO描述</b>：{{ props.row.seo_description }}</p>
                                <p><b>上线时间</b>：{{ props.row.published_at }}</p>
                                <p><b>显示</b>：<el-tag type="success" v-if="props.row.is_show == 1">是</el-tag>
                                    <el-tag type="warning" v-else>否</el-tag></p>
                            </div>
                        </template>
                    @endverbatim
                </el-table-column>
                <el-table-column
                        prop="id"
                        label="ID">
                </el-table-column>
                <el-table-column
                        prop="title"
                        label="课程">
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

    <meedu-pagination :pagination="remoteData"></meedu-pagination>

@endsection

@section('js')
    <script>
        var pagination = JSON.parse('@json($courses)');
        var Page = new Vue({
            el: '#app',
            data: function () {
                return {
                    remoteData: pagination
                }
            },
            computed: {
                administrators: function () {
                    var data = this.remoteData.data;
                    return data;
                }
            }
        });
        (new Page).$mount('#app-body');
    </script>
@endsection