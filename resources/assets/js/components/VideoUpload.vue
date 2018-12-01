<template>
    <div>
        <label><input type="radio" value="使用阿里云视频服务" v-model="show">使用阿里云视频服务</label>
        <label><input type="radio" value="直接使用URL地址" v-model="show">直接使用URL地址</label>

        <div v-show="show == '使用阿里云视频服务'">
            <input type="file" name="file" id="video_files"/>
            <p>上传进度：<span id="upload-progress">暂无</span></p>
            <input type="text" name="aliyun_video_id" id="video_id" v-model="video_id">
            <div>
                <button type="button" class="btn btn-success" id="start-upload">开始上传</button>
                <button type="button" class="btn btn-success" id="stop-upload">停止上传</button>
            </div>
        </div>
        <div v-show="show == '直接使用URL地址'">
            <input type="text" name="url" v-model="url" placeholder="请输入视频播放地址">
        </div>
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