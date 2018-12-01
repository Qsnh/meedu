<template>
    <a class="btn btn-danger btn-sm" :href="handle">删除</a>
</template>

<script>
    export default {
        props: ['url', 'size'],
        data: function () {
            return {

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