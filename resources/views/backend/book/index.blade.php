@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '电子书列表'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.book.create') }}'" :name="'添加电子书'"></meedu-a>
        </el-col>

        <el-col :span="24">
            <el-table :data="books" style="width: 100%">
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
                                <p><b>创建时间</b>：{{ props.row.created_at }}</p>
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
                        label="书名">
                </el-table-column>
                <el-table-column
                        prop="published_at"
                        label="上线时间">
                </el-table-column>
                <el-table-column label="操作">
                    <template slot-scope="scope">
                        <meedu-a :size="'mini'" :name="'编辑'" :type="'warning'" :url="scope.row.edit_url"></meedu-a>
                        <meedu-destroy-button :url="scope.row.destroy_url"></meedu-destroy-button>
                        <meedu-a :size="'mini'" :name="'章节'" :type="'primary'" :url="scope.row.chapter_url"></meedu-a>
                    </template>
                </el-table-column>
            </el-table>
        </el-col>
    </el-row>

    <meedu-pagination :pagination="remoteData"></meedu-pagination>

@endsection

@section('js')
    <script>
        var pagination = @json($books);
        new Vue({
            el: '#app',
            data: function () {
                return {
                    remoteData: pagination
                }
            },
            computed: {
                books: function () {
                    var data = this.remoteData.data;
                    return data;
                }
            }
        });
    </script>
@endsection