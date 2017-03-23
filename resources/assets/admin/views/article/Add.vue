<template>
    <el-form ref="form" :model="form" label-width="80px" @submit.prevent="onSubmit" style="margin:20px;width:60%;min-width:600px;">
        <el-form-item label="标题">
            <el-input v-model="form.title"></el-input>
        </el-form-item>
        <el-form-item label="Solgan">
            <el-input v-model="form.solgan"></el-input>
        </el-form-item>
        <el-form-item label="Topics">
            <el-checkbox-group v-model="form.topics">
                <el-checkbox label="Laravel" name="topics"></el-checkbox>
                <el-checkbox label="Vue" name="topics"></el-checkbox>
                <el-checkbox label="PHP" name="topics"></el-checkbox>
                <el-checkbox label="Linux" name="topics"></el-checkbox>
            </el-checkbox-group>
        </el-form-item>
        <el-form-item label="内容">
            <el-input type="textarea" v-model="form.content"></el-input>
        </el-form-item>
        <el-form-item label="发布时间">
            <el-col :span="11">
                <el-date-picker type="date" placeholder="选择日期" v-model="form.date1" style="width: 100%;"></el-date-picker>
            </el-col>
            <el-col class="line" :span="2">-</el-col>
            <el-col :span="11">
                <el-time-picker type="fixed-time" placeholder="选择时间" v-model="form.date2" style="width: 100%;"></el-time-picker>
            </el-col>
        </el-form-item>
        <el-form-item>
            <el-button type="primary">立即发布</el-button>
            <el-button type="info">存为草稿</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    title: '',
                    solgan: '',
                    date1: '',
                    date2: '',
                    topics: [],
                    content: '',
                }
            }
        },
        methods: {
            onSubmit() {
                console.log('submit!');
            }
        }
    }

</script>
