<template>
    <div style="margin-top: 15px;">
        <el-radio-group v-model="show">
            <el-radio-button label="使用阿里云视频服务"></el-radio-button>
            <el-radio-button label="直接使用URL地址"></el-radio-button>
        </el-radio-group>
        <el-form-item v-show="show == '使用阿里云视频服务'" label="请选择视频文件（不修改请勿操作）">
            <input type="file" name="file" id="video_files"/>
            <p>上传进度：<span id="upload-progress">暂无</span></p>
            <input type="text" name="aliyun_video_id" id="video_id" v-model="video_id">
            <el-col :span="24">
                <el-button type="success" id="start-upload">开始上传</el-button>
                <el-button type="danger" id="stop-upload">停止上传</el-button>
            </el-col>
        </el-form-item>
        <el-form-item v-show="show == '直接使用URL地址'" label="请输入视频播放地址">
            <el-input typeof="text" name="url" v-model="url" placeholder="请输入视频播放地址"></el-input>
        </el-form-item>
    </div>
</template>

<script>
    export default  {
        props: [
            'video',
        ],
        created() {
            this.video_id = this.video.aliyun_video_id;
            this.url = this.video.url;
            this.showTab();
        },
        data () {
            return {
                show: '使用阿里云视频服务',
                url: '',
                video_id: ''
            }
        },
        methods: {
            showTab() {
                if (this.url == '' && this.video_id == '') {
                    this.show =  '使用阿里云视频服务';
                } else if (this.url != '') {
                    this.show =  '直接使用URL地址';
                } else if (this.video_id != '') {
                    this.show = '使用阿里云视频服务';
                }
            }
        }
    }
</script>