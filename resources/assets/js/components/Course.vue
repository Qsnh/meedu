<template>
    <div>
        <el-row>
            <el-col :span="24">
                <el-select v-model="selectCourse">
                    <el-option v-for="course in courses"
                    :key="course.id"
                    :label="course.title"
                    :value="course.id">
                    </el-option>
                </el-select>
                <input type="hidden" name="course_id" v-model="selectCourse">
            </el-col>
        </el-row>
    </div>
</template>

<script>
    var url = '/backend/ajax/course';
    export default {
        mounted () {
            this.getCourses();
            this.selectCourse = this.course_id;
        },
        props: [
            'course_id',
        ],
        data () {
            return {
                courses: [],
                keywords: '',
                selectCourse: []
            }
        },
        methods: {
            getCourses() {
                window.axios.get(url).then(({ data }) => {
                    this.courses = data;
                }).catch(err => {
                    this.$message.errors('网络错误');
                });
            }
        }
    }
</script>