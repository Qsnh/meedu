<template>
    <div>
        <mavon-editor ref="md" v-model="content"
                      :boxShadow="false"
                      :subfield="false"
                      @imgAdd="$imgAdd" />
        <div v-show="false">
            <textarea :name="field" v-model="content"></textarea>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['markdown', 'field'],
        created: function () {
            this.content = this.markdown;
        },
        data: function () {
            return {
                content: ''
            }
        },
        methods: {
            $imgAdd(pos, $file){
                var formdata = new FormData();
                formdata.append('file', $file);
                axios({
                    url: '/backend/upload/image',
                    method: 'post',
                    data: formdata,
                    headers: { 'Content-Type': 'multipart/form-data' },
                }).then((res) => {
                    this.$refs.md.$img2Url(pos, res.data.url);
                })
            }
        }
    }
</script>