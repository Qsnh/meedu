<template>
    <div>
        <el-row style="text-align: right; margin-top: 20px; margin-bottom: 20px;">
            <el-col :span="24">
                <el-pagination
                        background
                        layout="total, prev, pager, next"
                        @current-change="changePage"
                        :total="pagination.total"
                        :current-page="pagination.current_page"
                        :page-size="pagination.per_page">
                </el-pagination>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        props: ['pagination'],
        data: function () {
            return {};
        },
        methods: {
            changePage: function (page) {
                var $url = this.pagination.first_page_url.replace(/page=\d+/, 'page=' + page);
                location.href = $url;
            }
        }
    }
</script>