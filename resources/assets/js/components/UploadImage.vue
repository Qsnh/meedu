<template>
   <div>
       <p style="line-height: 26px; font-size: 14px;">{{name}}</p>
       <el-upload
               class="avatar-uploader"
               action="/backend/upload/image"
               :show-file-list="false"
               :on-success="handleAvatarSuccess">
           <img v-if="url" :src="url" class="avatar">
           <i v-else class="el-icon-plus avatar-uploader-icon"></i>
       </el-upload>
       <input type="hidden" :name="field" :value="url">
   </div>
</template>

<style>
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>

<script>
    export default {
        props: ['giveImageUrl', 'field', 'name'],
        data() {
            return {
                imageUrl: ''
            };
        },
        computed: {
            url: function () {
                if (this.imageUrl) {
                    return this.imageUrl;
                }
                return this.giveImageUrl ? this.giveImageUrl : '';
            }
        },
        methods: {
            handleAvatarSuccess(res, file) {
                this.imageUrl = res.url;
            }
        }
    }
</script>