<template>
    <el-button :size="getSize" type="danger" @click="handle">删除</el-button>
</template>

<script>
    export default {
        props: ['url', 'size'],
        data: function () {
            return {}
        },
        computed: {
            getSize: function () {
                return this.size ? this.size : 'mini';
            }
        },
        methods: {
            handle: function () {
                if (confirm('确定删除吗？')) {
                    location.href = this.url;
                }
            }
        }
    }
</script>