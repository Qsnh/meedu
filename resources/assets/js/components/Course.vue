<template>
    <div>
        <select class="form form-control">
            <option value="">无</option>
            <option v-for="course in courses" :value="course.id">{{course.title}}</option>
        </select>
        <input type="hidden" name="course_id" v-model="selectCourse">
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