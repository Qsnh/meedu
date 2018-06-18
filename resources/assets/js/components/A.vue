<template>
    <el-button :size="getSize" :type="getType" @click="redirect">{{getName}}</el-button>
</template>

<script>
    export default {
        props: [
            'type', 'name', 'url', 'size',
        ],
        data: function () {
            return {};
        },
        computed: {
            getType: function () {
                return this.type ? this.type : 'primary';
            },
            getName: function () {
                return this.name ? this.name : '按钮';
            },
            getSize: function () {
                return this.size ? this.size : '';
            }
        },
        methods: {
            redirect: function () {
                location.href = this.url;
            }
        }
    }
</script>